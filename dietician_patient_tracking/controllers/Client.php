<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Client extends ClientsController
{
    public function __construct()
    {
        parent::__construct();

        if (!is_client_logged_in()) {
            redirect(site_url('authentication/login'));
        }

        $this->load->model('dietician_patient_tracking/dietician_patient_tracking_model');
        $this->load->helper('dietician_patient_tracking/dietician_patient_tracking');
    }

    /**
     * Patient Dashboard
     */
    public function dashboard()
    {
        $contact_id = get_contact_user_id();
        $data['patient'] = $this->dietician_patient_tracking_model->get_patient_profile(null, $contact_id);

        if (!$data['patient']) {
            // Create patient profile if doesn't exist
            $contact = $this->clients_model->get_contact($contact_id);
            $patient_data = [
                'contact_id' => $contact_id,
                'client_id' => $contact->userid,
                'dietician_id' => 0, // Will be assigned later
                'status' => 'active'
            ];
            $patient_id = $this->dietician_patient_tracking_model->add_patient_profile($patient_data);
            $data['patient'] = $this->dietician_patient_tracking_model->get_patient_profile($patient_id);
        }

        $patient_id = $data['patient']->id;

        // Get latest measurement
        $data['latest_measurement'] = $this->dietician_patient_tracking_model->get_latest_measurement($patient_id);

        // Get statistics
        $data['statistics'] = $this->dietician_patient_tracking_model->get_patient_statistics($patient_id);

        // Get upcoming consultations
        $data['upcoming_consultations'] = array_slice(
            $this->dietician_patient_tracking_model->get_consultations($patient_id, ['status' => 'scheduled']),
            0,
            5
        );

        // Get active goals
        $data['active_goals'] = $this->dietician_patient_tracking_model->get_goals($patient_id, 'active');

        // Get recent achievements
        $data['recent_achievements'] = array_slice(
            $this->dietician_patient_tracking_model->get_achievements($patient_id),
            0,
            5
        );

        // Get active meal plan
        $active_meal_plans = $this->dietician_patient_tracking_model->get_meal_plans($patient_id, ['status' => 'active']);
        $data['active_meal_plan'] = !empty($active_meal_plans) ? $active_meal_plans[0] : null;

        // Calculate current metrics
        if ($data['latest_measurement'] && $data['patient']->height) {
            $data['current_bmi'] = dpt_calculate_bmi(
                $data['latest_measurement']->weight,
                $data['patient']->height
            );
            $data['bmi_category'] = dpt_get_bmi_category($data['current_bmi']);

            if ($data['patient']->date_of_birth) {
                $age = dpt_calculate_age($data['patient']->date_of_birth);
                $data['bmr'] = dpt_calculate_bmr(
                    $data['latest_measurement']->weight,
                    $data['patient']->height,
                    $age,
                    $data['patient']->gender
                );
                $data['tdee'] = dpt_calculate_tdee($data['bmr'], $data['patient']->activity_level);
            }
        }

        // Unread messages count
        $enable_messaging = $this->dietician_patient_tracking_model->get_setting('dpt_enable_messaging');
        if ($enable_messaging) {
            $data['unread_messages'] = $this->dietician_patient_tracking_model->get_unread_messages_count($patient_id, 'patient');
        }

        $data['title'] = _l('dpt_my_tracking');
        $this->data($data);
        $this->view('client/dashboard');
        $this->layout();
    }

    /**
     * My Profile
     */
    public function profile()
    {
        $contact_id = get_contact_user_id();
        $data['patient'] = $this->dietician_patient_tracking_model->get_patient_profile(null, $contact_id);

        if (!$data['patient']) {
            redirect(site_url('dietician_patient_tracking/client/dashboard'));
        }

        if ($this->input->post()) {
            $update_data = $this->input->post();
            $success = $this->dietician_patient_tracking_model->update_patient_profile($data['patient']->id, $update_data);

            if ($success) {
                set_alert('success', _l('updated_successfully', _l('dpt_profile')));
            } else {
                set_alert('danger', _l('updated_fail', _l('dpt_profile')));
            }

            redirect(site_url('dietician_patient_tracking/client/profile'));
        }

        $data['activity_levels'] = dpt_get_activity_levels();
        $data['goal_types'] = dpt_get_goal_types();
        $data['title'] = _l('dpt_my_profile');

        $this->data($data);
        $this->view('client/profile');
        $this->layout();
    }

    /**
     * Measurements
     */
    public function measurements()
    {
        $contact_id = get_contact_user_id();
        $patient = $this->dietician_patient_tracking_model->get_patient_profile(null, $contact_id);

        if (!$patient) {
            redirect(site_url('dietician_patient_tracking/client/dashboard'));
        }

        $data['patient'] = $patient;
        $data['measurements'] = $this->dietician_patient_tracking_model->get_measurements($patient->id);

        // Generate weight chart
        if (!empty($data['measurements'])) {
            $data['weight_chart_data'] = dpt_generate_weight_chart_data(array_reverse($data['measurements']));
        }

        $data['title'] = _l('dpt_my_measurements');
        $this->data($data);
        $this->view('client/measurements');
        $this->layout();
    }

    /**
     * Add Measurement (Patient self-entry)
     */
    public function add_measurement()
    {
        if ($this->input->post()) {
            $contact_id = get_contact_user_id();
            $patient = $this->dietician_patient_tracking_model->get_patient_profile(null, $contact_id);

            if (!$patient) {
                set_alert('danger', _l('patient_not_found'));
                redirect(site_url('dietician_patient_tracking/client/dashboard'));
            }

            $data = $this->input->post();
            $data['patient_id'] = $patient->id;
            $data['created_by'] = 0; // Self-entry
            $data['measurement_date'] = date('Y-m-d');

            $id = $this->dietician_patient_tracking_model->add_measurement($data);

            if ($id) {
                dpt_check_achievement($patient->id, 'first_measurement');
                set_alert('success', _l('added_successfully', _l('dpt_measurement')));
            } else {
                set_alert('danger', _l('added_fail', _l('dpt_measurement')));
            }

            redirect(site_url('dietician_patient_tracking/client/measurements'));
        }
    }

    /**
     * Food Diary
     */
    public function food_diary()
    {
        $contact_id = get_contact_user_id();
        $patient = $this->dietician_patient_tracking_model->get_patient_profile(null, $contact_id);

        if (!$patient) {
            redirect(site_url('dietician_patient_tracking/client/dashboard'));
        }

        // Check if food diary is enabled
        $enable_food_diary = $this->dietician_patient_tracking_model->get_setting('dpt_enable_food_diary');
        if (!$enable_food_diary) {
            show_404();
        }

        $from_date = $this->input->get('from_date') ?: date('Y-m-d', strtotime('-7 days'));
        $to_date = $this->input->get('to_date') ?: date('Y-m-d');

        $data['patient'] = $patient;
        $data['food_diary'] = $this->dietician_patient_tracking_model->get_food_diary($patient->id, $from_date, $to_date);
        $data['food_items'] = $this->dietician_patient_tracking_model->get_food_items();
        $data['meal_types'] = dpt_get_meal_types();
        $data['from_date'] = $from_date;
        $data['to_date'] = $to_date;

        // Calculate daily totals
        $daily_totals = [];
        foreach ($data['food_diary'] as $entry) {
            $date = $entry->diary_date;
            if (!isset($daily_totals[$date])) {
                $daily_totals[$date] = [
                    'calories' => 0,
                    'protein' => 0,
                    'carbs' => 0,
                    'fat' => 0
                ];
            }
            $daily_totals[$date]['calories'] += $entry->calories;
            $daily_totals[$date]['protein'] += $entry->protein;
            $daily_totals[$date]['carbs'] += $entry->carbs;
            $daily_totals[$date]['fat'] += $entry->fat;
        }
        $data['daily_totals'] = $daily_totals;

        $data['title'] = _l('dpt_food_diary');
        $this->data($data);
        $this->view('client/food_diary');
        $this->layout();
    }

    /**
     * Add food diary entry
     */
    public function add_food_diary_entry()
    {
        if ($this->input->post()) {
            $contact_id = get_contact_user_id();
            $patient = $this->dietician_patient_tracking_model->get_patient_profile(null, $contact_id);

            if (!$patient) {
                echo json_encode(['success' => false, 'message' => _l('patient_not_found')]);
                return;
            }

            $data = $this->input->post();
            $data['patient_id'] = $patient->id;

            $id = $this->dietician_patient_tracking_model->add_food_diary_entry($data);
            $success = $id ? true : false;

            if ($success) {
                dpt_check_achievement($patient->id, 'consistent_logging');
            }

            echo json_encode([
                'success' => $success,
                'message' => $success ? _l('added_successfully', _l('dpt_food_entry')) : _l('added_fail', _l('dpt_food_entry'))
            ]);
        }
    }

    /**
     * Delete food diary entry
     */
    public function delete_food_diary_entry($id)
    {
        $success = $this->dietician_patient_tracking_model->delete_food_diary_entry($id);
        echo json_encode([
            'success' => $success,
            'message' => $success ? _l('deleted') : _l('problem_deleting')
        ]);
    }

    /**
     * Meal Plans
     */
    public function meal_plans()
    {
        $contact_id = get_contact_user_id();
        $patient = $this->dietician_patient_tracking_model->get_patient_profile(null, $contact_id);

        if (!$patient) {
            redirect(site_url('dietician_patient_tracking/client/dashboard'));
        }

        $data['patient'] = $patient;
        $data['meal_plans'] = $this->dietician_patient_tracking_model->get_meal_plans($patient->id);

        $data['title'] = _l('dpt_my_meal_plans');
        $this->data($data);
        $this->view('client/meal_plans');
        $this->layout();
    }

    /**
     * View Meal Plan
     */
    public function meal_plan($id)
    {
        $contact_id = get_contact_user_id();
        $patient = $this->dietician_patient_tracking_model->get_patient_profile(null, $contact_id);

        if (!$patient) {
            redirect(site_url('dietician_patient_tracking/client/dashboard'));
        }

        $data['meal_plan'] = $this->dietician_patient_tracking_model->get_meal_plan($id);

        if (!$data['meal_plan'] || $data['meal_plan']->patient_id != $patient->id) {
            show_404();
        }

        $data['meal_plan_items'] = $this->dietician_patient_tracking_model->get_meal_plan_items($id);
        $data['meal_types'] = dpt_get_meal_types();

        // Group items by day
        $items_by_day = [];
        foreach ($data['meal_plan_items'] as $item) {
            $items_by_day[$item->day_number][] = $item;
        }
        $data['items_by_day'] = $items_by_day;

        $data['title'] = $data['meal_plan']->name;
        $this->data($data);
        $this->view('client/meal_plan_view');
        $this->layout();
    }

    /**
     * Goals
     */
    public function goals()
    {
        $contact_id = get_contact_user_id();
        $patient = $this->dietician_patient_tracking_model->get_patient_profile(null, $contact_id);

        if (!$patient) {
            redirect(site_url('dietician_patient_tracking/client/dashboard'));
        }

        $data['patient'] = $patient;
        $data['goals'] = $this->dietician_patient_tracking_model->get_goals($patient->id);

        $data['title'] = _l('dpt_my_goals');
        $this->data($data);
        $this->view('client/goals');
        $this->layout();
    }

    /**
     * Consultations
     */
    public function consultations()
    {
        $contact_id = get_contact_user_id();
        $patient = $this->dietician_patient_tracking_model->get_patient_profile(null, $contact_id);

        if (!$patient) {
            redirect(site_url('dietician_patient_tracking/client/dashboard'));
        }

        $data['patient'] = $patient;
        $data['consultations'] = $this->dietician_patient_tracking_model->get_consultations($patient->id);

        $data['title'] = _l('dpt_my_consultations');
        $this->data($data);
        $this->view('client/consultations');
        $this->layout();
    }

    /**
     * View Consultation
     */
    public function consultation($id)
    {
        $contact_id = get_contact_user_id();
        $patient = $this->dietician_patient_tracking_model->get_patient_profile(null, $contact_id);

        if (!$patient) {
            redirect(site_url('dietician_patient_tracking/client/dashboard'));
        }

        $data['consultation'] = $this->dietician_patient_tracking_model->get_consultation($id);

        if (!$data['consultation'] || $data['consultation']->patient_id != $patient->id) {
            show_404();
        }

        $data['title'] = _l('dpt_consultation') . ' - ' . $data['consultation']->subject;
        $this->data($data);
        $this->view('client/consultation_view');
        $this->layout();
    }

    /**
     * Achievements
     */
    public function achievements()
    {
        $contact_id = get_contact_user_id();
        $patient = $this->dietician_patient_tracking_model->get_patient_profile(null, $contact_id);

        if (!$patient) {
            redirect(site_url('dietician_patient_tracking/client/dashboard'));
        }

        // Check if gamification is enabled
        $enable_gamification = $this->dietician_patient_tracking_model->get_setting('dpt_enable_gamification');
        if (!$enable_gamification) {
            show_404();
        }

        $data['patient'] = $patient;
        $data['achievements'] = $this->dietician_patient_tracking_model->get_achievements($patient->id);

        // Calculate total points
        $total_points = 0;
        foreach ($data['achievements'] as $achievement) {
            $total_points += $achievement->points;
        }
        $data['total_points'] = $total_points;

        $data['title'] = _l('dpt_my_achievements');
        $this->data($data);
        $this->view('client/achievements');
        $this->layout();
    }

    /**
     * Messages
     */
    public function messages()
    {
        $contact_id = get_contact_user_id();
        $patient = $this->dietician_patient_tracking_model->get_patient_profile(null, $contact_id);

        if (!$patient) {
            redirect(site_url('dietician_patient_tracking/client/dashboard'));
        }

        // Check if messaging is enabled
        $enable_messaging = $this->dietician_patient_tracking_model->get_setting('dpt_enable_messaging');
        if (!$enable_messaging) {
            show_404();
        }

        if ($this->input->post()) {
            $message_data = [
                'patient_id' => $patient->id,
                'sender_type' => 'patient',
                'sender_id' => $contact_id,
                'message' => $this->input->post('message')
            ];

            $id = $this->dietician_patient_tracking_model->add_message($message_data);
            if ($id) {
                set_alert('success', _l('dpt_message_sent'));
            }

            redirect(site_url('dietician_patient_tracking/client/messages'));
        }

        $data['patient'] = $patient;
        $data['messages'] = $this->dietician_patient_tracking_model->get_messages($patient->id);

        // Mark unread messages as read
        foreach ($data['messages'] as $message) {
            if (!$message->is_read && $message->sender_type == 'dietician') {
                $this->dietician_patient_tracking_model->mark_message_as_read($message->id);
            }
        }

        $data['title'] = _l('dpt_messages');
        $this->data($data);
        $this->view('client/messages');
        $this->layout();
    }
}
