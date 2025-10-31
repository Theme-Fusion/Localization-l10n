<?php

defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Upgrade script for Dietician Patient Tracking module
 * Adds new tables for enhanced functionality
 */

// Table: dpt_dietitians (dedicated dietitian profiles)
if (!$CI->db->table_exists(db_prefix() . 'dpt_dietitians')) {
    $CI->db->query('CREATE TABLE `' . db_prefix() . 'dpt_dietitians` (
        `id` int(11) NOT NULL AUTO_INCREMENT,
        `staff_id` int(11) NOT NULL UNIQUE,
        `specialties` text NULL COMMENT "JSON array of specialties",
        `languages` varchar(255) NULL COMMENT "Comma-separated language codes",
        `bio` text NULL,
        `qualifications` text NULL,
        `license_number` varchar(100) NULL,
        `consultation_fee` decimal(10,2) NULL,
        `availability` text NULL COMMENT "JSON availability schedule",
        `signature` varchar(255) NULL COMMENT "Digital signature image path",
        `max_patients` int(11) DEFAULT 0 COMMENT "0 = unlimited",
        `status` enum("active","inactive","on_leave") DEFAULT "active",
        `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
        `updated_at` datetime NULL ON UPDATE CURRENT_TIMESTAMP,
        PRIMARY KEY (`id`),
        KEY `staff_id` (`staff_id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=' . $CI->db->char_set . ';');
}

// Table: dpt_anamnesis (structured patient medical history)
if (!$CI->db->table_exists(db_prefix() . 'dpt_anamnesis')) {
    $CI->db->query('CREATE TABLE `' . db_prefix() . 'dpt_anamnesis` (
        `id` int(11) NOT NULL AUTO_INCREMENT,
        `patient_id` int(11) NOT NULL,
        `consultation_id` int(11) NULL,
        `created_by` int(11) NOT NULL,
        `medical_history` text NULL COMMENT "Past illnesses, surgeries",
        `current_medications` text NULL,
        `allergies` text NULL,
        `food_intolerances` text NULL,
        `chronic_conditions` text NULL COMMENT "Diabetes, hypertension, etc.",
        `family_history` text NULL,
        `lifestyle_habits` text NULL COMMENT "Smoking, alcohol, sleep",
        `eating_habits` text NULL,
        `physical_activity` text NULL,
        `stress_level` enum("low","moderate","high","very_high") DEFAULT "moderate",
        `sleep_quality` enum("poor","fair","good","excellent") DEFAULT "fair",
        `motivation_level` int(11) DEFAULT 5 COMMENT "1-10 scale",
        `main_objective` text NULL,
        `secondary_objectives` text NULL,
        `obstacles` text NULL COMMENT "Barriers to success",
        `support_system` text NULL COMMENT "Family, friends support",
        `previous_diets` text NULL,
        `preferences` text NULL COMMENT "Food likes/dislikes",
        `budget_constraints` enum("low","medium","high","unlimited") DEFAULT "medium",
        `cooking_skills` enum("beginner","intermediate","advanced","expert") DEFAULT "intermediate",
        `meal_prep_time` int(11) NULL COMMENT "Available minutes per day",
        `pdf_attachment` varchar(255) NULL,
        `notes` text NULL,
        `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
        `updated_at` datetime NULL ON UPDATE CURRENT_TIMESTAMP,
        PRIMARY KEY (`id`),
        KEY `patient_id` (`patient_id`),
        KEY `consultation_id` (`consultation_id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=' . $CI->db->char_set . ';');
}

// Table: dpt_programs (dietary programs with milestones)
if (!$CI->db->table_exists(db_prefix() . 'dpt_programs')) {
    $CI->db->query('CREATE TABLE `' . db_prefix() . 'dpt_programs` (
        `id` int(11) NOT NULL AUTO_INCREMENT,
        `patient_id` int(11) NOT NULL,
        `dietician_id` int(11) NOT NULL,
        `name` varchar(255) NOT NULL,
        `description` text NULL,
        `start_date` date NOT NULL,
        `end_date` date NULL,
        `duration_weeks` int(11) NULL,
        `program_type` enum("weight_loss","weight_gain","muscle_building","health_improvement","sports_nutrition","therapeutic") DEFAULT "weight_loss",
        `target_weight` decimal(5,2) NULL COMMENT "in kg",
        `target_body_fat` decimal(4,2) NULL COMMENT "percentage",
        `daily_calories_target` int(11) NULL,
        `daily_protein_target` decimal(6,2) NULL COMMENT "in grams",
        `daily_carbs_target` decimal(6,2) NULL COMMENT "in grams",
        `daily_fat_target` decimal(6,2) NULL COMMENT "in grams",
        `training_frequency` int(11) NULL COMMENT "sessions per week",
        `training_type` varchar(255) NULL,
        `milestones` text NULL COMMENT "JSON array of milestones",
        `status` enum("draft","active","paused","completed","cancelled") DEFAULT "draft",
        `completion_percentage` int(11) DEFAULT 0,
        `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
        `updated_at` datetime NULL ON UPDATE CURRENT_TIMESTAMP,
        PRIMARY KEY (`id`),
        KEY `patient_id` (`patient_id`),
        KEY `dietician_id` (`dietician_id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=' . $CI->db->char_set . ';');
}

// Table: dpt_program_milestones
if (!$CI->db->table_exists(db_prefix() . 'dpt_program_milestones')) {
    $CI->db->query('CREATE TABLE `' . db_prefix() . 'dpt_program_milestones` (
        `id` int(11) NOT NULL AUTO_INCREMENT,
        `program_id` int(11) NOT NULL,
        `title` varchar(255) NOT NULL,
        `description` text NULL,
        `target_date` date NOT NULL,
        `target_value` decimal(10,2) NULL,
        `metric_type` enum("weight","body_fat","measurements","calories","other") DEFAULT "weight",
        `achieved` tinyint(1) DEFAULT 0,
        `achieved_date` date NULL,
        `achieved_value` decimal(10,2) NULL,
        `sort_order` int(11) DEFAULT 0,
        PRIMARY KEY (`id`),
        KEY `program_id` (`program_id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=' . $CI->db->char_set . ';');
}

// Table: dpt_reminders
if (!$CI->db->table_exists(db_prefix() . 'dpt_reminders')) {
    $CI->db->query('CREATE TABLE `' . db_prefix() . 'dpt_reminders` (
        `id` int(11) NOT NULL AUTO_INCREMENT,
        `patient_id` int(11) NOT NULL,
        `reminder_type` enum("meal","hydration","medication","appointment","measurement","plan_renewal","custom") NOT NULL,
        `title` varchar(255) NOT NULL,
        `message` text NULL,
        `frequency` enum("once","daily","weekly","monthly","custom") DEFAULT "daily",
        `time_of_day` time NULL,
        `days_of_week` varchar(50) NULL COMMENT "Comma-separated 1-7 (Monday-Sunday)",
        `start_date` date NOT NULL,
        `end_date` date NULL,
        `next_trigger_date` datetime NULL,
        `send_via_sms` tinyint(1) DEFAULT 0,
        `send_via_email` tinyint(1) DEFAULT 1,
        `send_via_notification` tinyint(1) DEFAULT 1,
        `status` enum("active","paused","completed","cancelled") DEFAULT "active",
        `created_by` int(11) NOT NULL,
        `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
        `updated_at` datetime NULL ON UPDATE CURRENT_TIMESTAMP,
        PRIMARY KEY (`id`),
        KEY `patient_id` (`patient_id`),
        KEY `next_trigger_date` (`next_trigger_date`),
        KEY `status` (`status`)
    ) ENGINE=InnoDB DEFAULT CHARSET=' . $CI->db->char_set . ';');
}

// Table: dpt_reminder_logs
if (!$CI->db->table_exists(db_prefix() . 'dpt_reminder_logs')) {
    $CI->db->query('CREATE TABLE `' . db_prefix() . 'dpt_reminder_logs` (
        `id` int(11) NOT NULL AUTO_INCREMENT,
        `reminder_id` int(11) NOT NULL,
        `sent_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
        `sent_via` enum("sms","email","notification") NOT NULL,
        `status` enum("sent","failed","pending") DEFAULT "sent",
        `error_message` text NULL,
        PRIMARY KEY (`id`),
        KEY `reminder_id` (`reminder_id`),
        KEY `sent_at` (`sent_at`)
    ) ENGINE=InnoDB DEFAULT CHARSET=' . $CI->db->char_set . ';');
}

// Table: dpt_sms_logs (for SMS LAM API)
if (!$CI->db->table_exists(db_prefix() . 'dpt_sms_logs')) {
    $CI->db->query('CREATE TABLE `' . db_prefix() . 'dpt_sms_logs` (
        `id` int(11) NOT NULL AUTO_INCREMENT,
        `patient_id` int(11) NULL,
        `contact_id` int(11) NULL,
        `phone_number` varchar(20) NOT NULL,
        `message` text NOT NULL,
        `message_type` enum("reminder","notification","otp","marketing","other") DEFAULT "notification",
        `sender_id` varchar(50) NULL,
        `api_response` text NULL COMMENT "JSON response from LAM API",
        `status` enum("sent","failed","pending") DEFAULT "pending",
        `sent_at` datetime NULL,
        `cost` decimal(10,4) NULL,
        `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
        PRIMARY KEY (`id`),
        KEY `patient_id` (`patient_id`),
        KEY `phone_number` (`phone_number`),
        KEY `status` (`status`)
    ) ENGINE=InnoDB DEFAULT CHARSET=' . $CI->db->char_set . ';');
}

// Table: dpt_gdpr_consents
if (!$CI->db->table_exists(db_prefix() . 'dpt_gdpr_consents')) {
    $CI->db->query('CREATE TABLE `' . db_prefix() . 'dpt_gdpr_consents` (
        `id` int(11) NOT NULL AUTO_INCREMENT,
        `patient_id` int(11) NOT NULL,
        `consent_type` enum("health_data_processing","data_sharing","marketing","photography","sms_notifications") NOT NULL,
        `consent_given` tinyint(1) NOT NULL DEFAULT 0,
        `consent_text` text NULL COMMENT "Text shown at consent time",
        `ip_address` varchar(45) NULL,
        `user_agent` text NULL,
        `consented_at` datetime NULL,
        `withdrawn_at` datetime NULL,
        `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
        PRIMARY KEY (`id`),
        KEY `patient_id` (`patient_id`),
        KEY `consent_type` (`consent_type`)
    ) ENGINE=InnoDB DEFAULT CHARSET=' . $CI->db->char_set . ';');
}

// Table: dpt_audit_log
if (!$CI->db->table_exists(db_prefix() . 'dpt_audit_log')) {
    $CI->db->query('CREATE TABLE `' . db_prefix() . 'dpt_audit_log` (
        `id` int(11) NOT NULL AUTO_INCREMENT,
        `patient_id` int(11) NULL,
        `user_id` int(11) NOT NULL COMMENT "Staff or contact ID",
        `user_type` enum("staff","client") NOT NULL,
        `action` varchar(100) NOT NULL COMMENT "create, update, delete, view, export",
        `entity_type` varchar(100) NOT NULL COMMENT "patient, anamnesis, measurement, etc.",
        `entity_id` int(11) NULL,
        `description` text NULL,
        `old_values` text NULL COMMENT "JSON of previous values",
        `new_values` text NULL COMMENT "JSON of new values",
        `ip_address` varchar(45) NULL,
        `user_agent` text NULL,
        `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
        PRIMARY KEY (`id`),
        KEY `patient_id` (`patient_id`),
        KEY `user_id` (`user_id`),
        KEY `entity_type` (`entity_type`),
        KEY `created_at` (`created_at`)
    ) ENGINE=InnoDB DEFAULT CHARSET=' . $CI->db->char_set . ';');
}

// Table: dpt_satisfaction_surveys (NPS/Satisfaction post-consultation)
if (!$CI->db->table_exists(db_prefix() . 'dpt_satisfaction_surveys')) {
    $CI->db->query('CREATE TABLE `' . db_prefix() . 'dpt_satisfaction_surveys` (
        `id` int(11) NOT NULL AUTO_INCREMENT,
        `consultation_id` int(11) NOT NULL,
        `patient_id` int(11) NOT NULL,
        `dietician_id` int(11) NOT NULL,
        `nps_score` int(11) NULL COMMENT "0-10 Net Promoter Score",
        `overall_satisfaction` int(11) NULL COMMENT "1-5 stars",
        `communication_rating` int(11) NULL COMMENT "1-5 stars",
        `expertise_rating` int(11) NULL COMMENT "1-5 stars",
        `plan_quality_rating` int(11) NULL COMMENT "1-5 stars",
        `waiting_time_rating` int(11) NULL COMMENT "1-5 stars",
        `would_recommend` tinyint(1) NULL,
        `positive_feedback` text NULL,
        `negative_feedback` text NULL,
        `suggestions` text NULL,
        `survey_sent_at` datetime NULL,
        `completed_at` datetime NULL,
        `reminder_sent_count` int(11) DEFAULT 0,
        PRIMARY KEY (`id`),
        KEY `consultation_id` (`consultation_id`),
        KEY `patient_id` (`patient_id`),
        KEY `dietician_id` (`dietician_id`),
        KEY `nps_score` (`nps_score`)
    ) ENGINE=InnoDB DEFAULT CHARSET=' . $CI->db->char_set . ';');
}

// Add new columns to existing tables if they don't exist
if (!$CI->db->field_exists('nps_score', db_prefix() . 'dpt_consultations')) {
    $CI->db->query('ALTER TABLE `' . db_prefix() . 'dpt_consultations`
        ADD COLUMN `nps_score` int(11) NULL COMMENT "Quick NPS 0-10" AFTER `status`,
        ADD COLUMN `satisfaction_rating` int(11) NULL COMMENT "1-5 stars" AFTER `nps_score`');
}

if (!$CI->db->field_exists('program_id', db_prefix() . 'dpt_meal_plans')) {
    $CI->db->query('ALTER TABLE `' . db_prefix() . 'dpt_meal_plans`
        ADD COLUMN `program_id` int(11) NULL AFTER `patient_id`,
        ADD COLUMN `version` int(11) DEFAULT 1 AFTER `name`,
        ADD COLUMN `parent_plan_id` int(11) NULL COMMENT "For plan versions" AFTER `version`');
}

// Insert default SMS LAM API settings
$sms_settings = [
    ['setting_key' => 'dpt_sms_enabled', 'setting_value' => '0', 'setting_type' => 'boolean'],
    ['setting_key' => 'dpt_sms_lam_api_key', 'setting_value' => '', 'setting_type' => 'string'],
    ['setting_key' => 'dpt_sms_lam_sender_id', 'setting_value' => '', 'setting_type' => 'string'],
    ['setting_key' => 'dpt_sms_lam_api_url', 'setting_value' => 'https://api.lam-express.com/send', 'setting_type' => 'string'],
    ['setting_key' => 'dpt_enable_reminders', 'setting_value' => '1', 'setting_type' => 'boolean'],
    ['setting_key' => 'dpt_enable_satisfaction_surveys', 'setting_value' => '1', 'setting_type' => 'boolean'],
    ['setting_key' => 'dpt_survey_send_delay_hours', 'setting_value' => '24', 'setting_type' => 'integer'],
    ['setting_key' => 'dpt_require_gdpr_consent', 'setting_value' => '1', 'setting_type' => 'boolean'],
    ['setting_key' => 'dpt_enable_audit_log', 'setting_value' => '1', 'setting_type' => 'boolean'],
];

foreach ($sms_settings as $setting) {
    if (!$CI->db->get_where(db_prefix() . 'dpt_settings', ['setting_key' => $setting['setting_key']])->row()) {
        $CI->db->insert(db_prefix() . 'dpt_settings', $setting);
    }
}

log_activity('Dietician Patient Tracking Module: Database upgraded successfully');
