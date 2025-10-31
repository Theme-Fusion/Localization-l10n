<?php

defined('BASEPATH') or exit('No direct script access allowed');

/**
 * CRON jobs for Dietician Patient Tracking module
 *
 * Add to Perfex CRM cron (Setup → Settings → Cron Job):
 * */5 * * * * php /path/to/perfex/index.php dietician_patient_tracking/cron/process
 */

class DPT_Cron
{
    private $CI;
    private $model;

    public function __construct()
    {
        $this->CI = &get_instance();
        $this->CI->load->model('dietician_patient_tracking/dietician_patient_tracking_model');
        $this->model = $this->CI->dietician_patient_tracking_model;
    }

    /**
     * Main CRON processor - runs every 5 minutes
     */
    public function process()
    {
        $this->log('Starting CRON process');

        // Check if reminders are enabled
        $reminders_enabled = $this->model->get_setting('dpt_enable_reminders');
        if ($reminders_enabled && $reminders_enabled != '0') {
            $this->process_reminders();
        }

        // Check if satisfaction surveys are enabled
        $surveys_enabled = $this->model->get_setting('dpt_enable_satisfaction_surveys');
        if ($surveys_enabled && $surveys_enabled != '0') {
            $this->process_satisfaction_surveys();
        }

        // Run daily tasks (once per day)
        $last_daily_run = $this->model->get_setting('dpt_last_daily_cron');
        $today = date('Y-m-d');

        if ($last_daily_run != $today) {
            $this->process_daily_tasks();
            $this->model->update_setting('dpt_last_daily_cron', $today);
        }

        $this->log('CRON process completed');
    }

    /**
     * Process due reminders
     */
    private function process_reminders()
    {
        $this->log('Processing reminders');

        $due_reminders = $this->model->get_due_reminders();
        $count = 0;

        foreach ($due_reminders as $reminder) {
            try {
                // Get patient details
                $patient = $this->model->get_patient_profile($reminder->patient_id);
                if (!$patient) {
                    continue;
                }

                // Get contact info
                $this->CI->load->model('clients_model');
                $contact = $this->CI->clients_model->get_contact($patient->contact_id);
                if (!$contact) {
                    continue;
                }

                $sent = false;

                // Send via Email
                if ($reminder->send_via_email && !empty($contact->email)) {
                    $subject = $reminder->title;
                    $message = $this->format_reminder_message($reminder, $patient);

                    if (dpt_send_patient_notification($patient->contact_id, $subject, $message)) {
                        $this->model->log_reminder_sent($reminder->id, 'email', 'sent');
                        $sent = true;
                    } else {
                        $this->model->log_reminder_sent($reminder->id, 'email', 'failed');
                    }
                }

                // Send via SMS
                if ($reminder->send_via_sms && !empty($contact->phonenumber)) {
                    $message = $this->format_reminder_sms($reminder, $patient);

                    if ($this->model->send_sms($contact->phonenumber, $message, $patient->id, 'reminder')) {
                        $this->model->log_reminder_sent($reminder->id, 'sms', 'sent');
                        $sent = true;
                    } else {
                        $this->model->log_reminder_sent($reminder->id, 'sms', 'failed');
                    }
                }

                if ($sent) {
                    // Update next trigger date based on frequency
                    $next_date = $this->calculate_next_reminder_date($reminder);

                    if ($next_date && (!$reminder->end_date || $next_date <= $reminder->end_date)) {
                        $this->model->update_reminder($reminder->id, [
                            'next_trigger_date' => $next_date
                        ]);
                    } else {
                        // Mark as completed if no more occurrences
                        $this->model->update_reminder($reminder->id, [
                            'status' => 'completed'
                        ]);
                    }

                    $count++;
                }

            } catch (Exception $e) {
                $this->log('Error processing reminder ' . $reminder->id . ': ' . $e->getMessage());
            }
        }

        $this->log("Processed {$count} reminders");
    }

    /**
     * Process satisfaction surveys
     */
    private function process_satisfaction_surveys()
    {
        $this->log('Processing satisfaction surveys');

        // Send surveys for completed consultations
        $delay_hours = (int)$this->model->get_setting('dpt_survey_send_delay_hours') ?: 24;
        $cutoff_date = date('Y-m-d H:i:s', strtotime("-{$delay_hours} hours"));

        // Get completed consultations without surveys
        $this->CI->db->select('c.*');
        $this->CI->db->from(db_prefix() . 'dpt_consultations c');
        $this->CI->db->where('c.status', 'completed');
        $this->CI->db->where('c.updated_at <=', $cutoff_date);
        $this->CI->db->where('NOT EXISTS (
            SELECT 1 FROM ' . db_prefix() . 'dpt_satisfaction_surveys s
            WHERE s.consultation_id = c.id
        )', null, false);
        $this->CI->db->limit(10); // Process max 10 per run

        $consultations = $this->CI->db->get()->result();
        $count = 0;

        foreach ($consultations as $consultation) {
            try {
                // Create survey
                $survey_id = $this->model->add_satisfaction_survey([
                    'consultation_id' => $consultation->id,
                    'patient_id' => $consultation->patient_id,
                    'dietician_id' => $consultation->dietician_id,
                    'survey_sent_at' => date('Y-m-d H:i:s')
                ]);

                if ($survey_id) {
                    // Send survey invitation
                    $this->send_survey_invitation($survey_id, $consultation);
                    $count++;
                }

            } catch (Exception $e) {
                $this->log('Error creating survey for consultation ' . $consultation->id . ': ' . $e->getMessage());
            }
        }

        // Send reminders for pending surveys (max 3 reminders)
        $pending_surveys = $this->model->get_pending_surveys();
        $reminder_count = 0;

        foreach ($pending_surveys as $survey) {
            try {
                $days_since_sent = round((time() - strtotime($survey->survey_sent_at)) / 86400);

                // Send reminder after 3, 7, and 14 days
                $should_remind = false;
                if ($survey->reminder_sent_count == 0 && $days_since_sent >= 3) {
                    $should_remind = true;
                } elseif ($survey->reminder_sent_count == 1 && $days_since_sent >= 7) {
                    $should_remind = true;
                } elseif ($survey->reminder_sent_count == 2 && $days_since_sent >= 14) {
                    $should_remind = true;
                }

                if ($should_remind) {
                    $consultation = $this->model->get_consultation($survey->consultation_id);
                    if ($consultation) {
                        $this->send_survey_invitation($survey->id, $consultation, true);

                        $this->model->update_satisfaction_survey($survey->id, [
                            'reminder_sent_count' => $survey->reminder_sent_count + 1
                        ]);

                        $reminder_count++;
                    }
                }

            } catch (Exception $e) {
                $this->log('Error sending survey reminder ' . $survey->id . ': ' . $e->getMessage());
            }
        }

        $this->log("Sent {$count} new surveys and {$reminder_count} reminders");
    }

    /**
     * Daily tasks (run once per day)
     */
    private function process_daily_tasks()
    {
        $this->log('Running daily tasks');

        // Update program completion percentages
        $this->update_program_progress();

        // Check and update goal statuses
        $this->update_goal_statuses();

        // Send consultation reminders (3 days before)
        $this->send_consultation_reminders();

        // Cleanup old temporary files
        $this->cleanup_temp_files();

        // Generate daily reports if configured
        $this->generate_daily_reports();

        $this->log('Daily tasks completed');
    }

    /**
     * Update program completion percentages
     */
    private function update_program_progress()
    {
        $active_programs = $this->model->get_programs(null, ['status' => 'active']);

        foreach ($active_programs as $program) {
            try {
                $start = new DateTime($program->start_date);
                $end = $program->end_date ? new DateTime($program->end_date) : null;
                $now = new DateTime();

                if ($end && $now >= $end) {
                    // Program completed
                    $this->model->update_program($program->id, [
                        'status' => 'completed',
                        'completion_percentage' => 100
                    ]);
                } elseif ($end) {
                    // Calculate percentage
                    $total_days = $start->diff($end)->days;
                    $elapsed_days = $start->diff($now)->days;
                    $percentage = min(100, round(($elapsed_days / $total_days) * 100));

                    $this->model->update_program($program->id, [
                        'completion_percentage' => $percentage
                    ]);
                }

            } catch (Exception $e) {
                $this->log('Error updating program ' . $program->id . ': ' . $e->getMessage());
            }
        }
    }

    /**
     * Update goal statuses
     */
    private function update_goal_statuses()
    {
        // Check for overdue goals
        $this->CI->db->where('status', 'active');
        $this->CI->db->where('target_date <', date('Y-m-d'));
        $this->CI->db->where('completion_percentage <', 100);
        $overdue_goals = $this->CI->db->get(db_prefix() . 'dpt_goals')->result();

        foreach ($overdue_goals as $goal) {
            // Could send notification to patient about overdue goal
            $this->log("Goal {$goal->id} is overdue");
        }
    }

    /**
     * Send consultation reminders
     */
    private function send_consultation_reminders()
    {
        $reminder_days = (int)$this->model->get_setting('dpt_consultation_reminder_days') ?: 3;
        $reminder_date = date('Y-m-d', strtotime("+{$reminder_days} days"));

        $this->CI->db->select('c.*, p.contact_id, co.firstname, co.lastname, co.email, co.phonenumber');
        $this->CI->db->from(db_prefix() . 'dpt_consultations c');
        $this->CI->db->join(db_prefix() . 'dpt_patient_profiles p', 'p.id = c.patient_id');
        $this->CI->db->join(db_prefix() . 'contacts co', 'co.id = p.contact_id');
        $this->CI->db->where('c.status', 'scheduled');
        $this->CI->db->where('DATE(c.consultation_date)', $reminder_date);

        $consultations = $this->CI->db->get()->result();
        $count = 0;

        foreach ($consultations as $consultation) {
            try {
                $subject = 'Rappel: Consultation le ' . date('d/m/Y à H:i', strtotime($consultation->consultation_date));
                $message = "Bonjour {$consultation->firstname},\n\n";
                $message .= "Nous vous rappelons votre consultation de suivi diététique prévue le " .
                           date('d/m/Y à H:i', strtotime($consultation->consultation_date)) . ".\n\n";
                $message .= "Sujet: {$consultation->subject}\n\n";
                $message .= "À bientôt!";

                // Send email
                if (!empty($consultation->email)) {
                    dpt_send_patient_notification($consultation->contact_id, $subject, $message);
                    $count++;
                }

                // Send SMS if enabled
                $sms_enabled = $this->model->get_setting('dpt_sms_enabled');
                if ($sms_enabled && !empty($consultation->phonenumber)) {
                    $sms_message = "Rappel: Consultation le " .
                                  date('d/m/Y à H:i', strtotime($consultation->consultation_date)) .
                                  ". Sujet: {$consultation->subject}";

                    $this->model->send_sms($consultation->phonenumber, $sms_message, $consultation->patient_id, 'reminder');
                }

            } catch (Exception $e) {
                $this->log('Error sending consultation reminder ' . $consultation->id . ': ' . $e->getMessage());
            }
        }

        $this->log("Sent {$count} consultation reminders");
    }

    /**
     * Cleanup temporary files
     */
    private function cleanup_temp_files()
    {
        // Clean old temp files (older than 7 days)
        $temp_dir = 'uploads/dietician_patient_tracking/temp/';

        if (is_dir($temp_dir)) {
            $files = glob($temp_dir . '*');
            $now = time();
            $count = 0;

            foreach ($files as $file) {
                if (is_file($file)) {
                    if ($now - filemtime($file) >= 7 * 24 * 3600) { // 7 days
                        unlink($file);
                        $count++;
                    }
                }
            }

            if ($count > 0) {
                $this->log("Cleaned up {$count} temporary files");
            }
        }
    }

    /**
     * Generate daily reports
     */
    private function generate_daily_reports()
    {
        // This could generate and email daily summaries to dietitians
        // Implementation depends on specific requirements
        $this->log('Daily report generation complete');
    }

    /**
     * Send survey invitation
     */
    private function send_survey_invitation($survey_id, $consultation, $is_reminder = false)
    {
        $patient = $this->model->get_patient_profile($consultation->patient_id);
        if (!$patient) {
            return false;
        }

        $this->CI->load->model('clients_model');
        $contact = $this->CI->clients_model->get_contact($patient->contact_id);
        if (!$contact || empty($contact->email)) {
            return false;
        }

        $survey_url = site_url("dietician_patient_tracking/client/satisfaction_survey/{$survey_id}");

        $subject = $is_reminder ?
                  'Rappel: Votre avis nous intéresse' :
                  'Comment s\'est passée votre consultation?';

        $message = "Bonjour {$contact->firstname},\n\n";

        if ($is_reminder) {
            $message .= "Nous aimerions toujours connaître votre avis sur votre dernière consultation.\n\n";
        } else {
            $message .= "Merci d'avoir consulté. Votre avis est important pour nous!\n\n";
        }

        $message .= "Pourriez-vous prendre 2 minutes pour répondre à notre questionnaire de satisfaction?\n\n";
        $message .= "Cliquez ici: {$survey_url}\n\n";
        $message .= "Merci de votre confiance!";

        return dpt_send_patient_notification($patient->contact_id, $subject, $message);
    }

    /**
     * Format reminder message for email
     */
    private function format_reminder_message($reminder, $patient)
    {
        $message = "Bonjour {$patient->firstname} {$patient->lastname},\n\n";
        $message .= $reminder->message ?: $reminder->title;
        $message .= "\n\nCe rappel est automatique.\n";
        $message .= "Votre équipe de suivi diététique";

        return $message;
    }

    /**
     * Format reminder message for SMS
     */
    private function format_reminder_sms($reminder, $patient)
    {
        return substr($reminder->message ?: $reminder->title, 0, 160); // SMS limit
    }

    /**
     * Calculate next reminder date based on frequency
     */
    private function calculate_next_reminder_date($reminder)
    {
        $current = new DateTime($reminder->next_trigger_date);

        switch ($reminder->frequency) {
            case 'daily':
                $current->modify('+1 day');
                break;

            case 'weekly':
                $current->modify('+7 days');
                break;

            case 'monthly':
                $current->modify('+1 month');
                break;

            case 'once':
                return null; // No next occurrence

            default:
                return null;
        }

        // Set time of day
        if ($reminder->time_of_day) {
            $time_parts = explode(':', $reminder->time_of_day);
            $current->setTime((int)$time_parts[0], (int)$time_parts[1]);
        }

        return $current->format('Y-m-d H:i:s');
    }

    /**
     * Log CRON activity
     */
    private function log($message)
    {
        log_activity('[DPT CRON] ' . $message);
    }
}

// Run if called directly (for manual testing)
if (php_sapi_name() === 'cli' || (isset($_GET['cron_key']) && $_GET['cron_key'] == get_option('cron_key'))) {
    $cron = new DPT_Cron();
    $cron->process();
}
