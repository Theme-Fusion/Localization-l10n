<?php

defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Installation script for Dietician Patient Tracking module
 */

if (!$CI->db->table_exists(db_prefix() . 'dpt_patient_profiles')) {
    $CI->db->query('CREATE TABLE `' . db_prefix() . 'dpt_patient_profiles` (
        `id` int(11) NOT NULL AUTO_INCREMENT,
        `contact_id` int(11) NOT NULL,
        `client_id` int(11) NOT NULL,
        `dietician_id` int(11) NOT NULL COMMENT "Staff ID",
        `date_of_birth` date NULL,
        `gender` enum("male","female","other") DEFAULT "male",
        `height` decimal(5,2) NULL COMMENT "in cm",
        `medical_history` text NULL,
        `allergies` text NULL,
        `dietary_restrictions` text NULL,
        `activity_level` enum("sedentary","lightly_active","moderately_active","very_active","extremely_active") DEFAULT "sedentary",
        `goal_type` enum("lose_weight","gain_weight","maintain","muscle_gain","health") DEFAULT "maintain",
        `target_weight` decimal(5,2) NULL COMMENT "in kg",
        `weekly_goal` decimal(4,2) NULL COMMENT "kg per week",
        `profile_photo` varchar(255) NULL,
        `notes` text NULL,
        `status` enum("active","inactive","completed","archived") DEFAULT "active",
        `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
        `updated_at` datetime NULL ON UPDATE CURRENT_TIMESTAMP,
        PRIMARY KEY (`id`),
        KEY `contact_id` (`contact_id`),
        KEY `client_id` (`client_id`),
        KEY `dietician_id` (`dietician_id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=' . $CI->db->char_set . ';');
}

if (!$CI->db->table_exists(db_prefix() . 'dpt_measurements')) {
    $CI->db->query('CREATE TABLE `' . db_prefix() . 'dpt_measurements` (
        `id` int(11) NOT NULL AUTO_INCREMENT,
        `patient_id` int(11) NOT NULL,
        `measurement_date` date NOT NULL,
        `weight` decimal(5,2) NOT NULL COMMENT "in kg",
        `body_fat_percentage` decimal(4,2) NULL,
        `muscle_mass` decimal(5,2) NULL COMMENT "in kg",
        `waist_circumference` decimal(5,2) NULL COMMENT "in cm",
        `hip_circumference` decimal(5,2) NULL COMMENT "in cm",
        `chest_circumference` decimal(5,2) NULL COMMENT "in cm",
        `arm_circumference` decimal(5,2) NULL COMMENT "in cm",
        `thigh_circumference` decimal(5,2) NULL COMMENT "in cm",
        `blood_pressure_systolic` int(11) NULL,
        `blood_pressure_diastolic` int(11) NULL,
        `blood_sugar` decimal(5,2) NULL COMMENT "mg/dL",
        `notes` text NULL,
        `photos` text NULL COMMENT "JSON array of photo paths",
        `created_by` int(11) NOT NULL,
        `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
        PRIMARY KEY (`id`),
        KEY `patient_id` (`patient_id`),
        KEY `measurement_date` (`measurement_date`)
    ) ENGINE=InnoDB DEFAULT CHARSET=' . $CI->db->char_set . ';');
}

if (!$CI->db->table_exists(db_prefix() . 'dpt_consultations')) {
    $CI->db->query('CREATE TABLE `' . db_prefix() . 'dpt_consultations` (
        `id` int(11) NOT NULL AUTO_INCREMENT,
        `patient_id` int(11) NOT NULL,
        `dietician_id` int(11) NOT NULL,
        `project_id` int(11) NULL COMMENT "Link to Perfex project",
        `consultation_date` datetime NOT NULL,
        `consultation_type` enum("initial","followup","emergency","final") DEFAULT "followup",
        `duration` int(11) NULL COMMENT "in minutes",
        `subject` varchar(255) NOT NULL,
        `anamnesis` text NULL COMMENT "Patient history and current state",
        `diagnosis` text NULL,
        `recommendations` text NULL,
        `next_consultation_date` datetime NULL,
        `attachments` text NULL COMMENT "JSON array of attachments",
        `status` enum("scheduled","completed","cancelled","no_show") DEFAULT "scheduled",
        `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
        `updated_at` datetime NULL ON UPDATE CURRENT_TIMESTAMP,
        PRIMARY KEY (`id`),
        KEY `patient_id` (`patient_id`),
        KEY `dietician_id` (`dietician_id`),
        KEY `consultation_date` (`consultation_date`)
    ) ENGINE=InnoDB DEFAULT CHARSET=' . $CI->db->char_set . ';');
}

if (!$CI->db->table_exists(db_prefix() . 'dpt_food_library')) {
    $CI->db->query('CREATE TABLE `' . db_prefix() . 'dpt_food_library` (
        `id` int(11) NOT NULL AUTO_INCREMENT,
        `name` varchar(255) NOT NULL,
        `category` varchar(100) NULL,
        `serving_size` decimal(6,2) NOT NULL COMMENT "in grams",
        `calories` decimal(6,2) NOT NULL,
        `protein` decimal(6,2) NOT NULL COMMENT "in grams",
        `carbohydrates` decimal(6,2) NOT NULL COMMENT "in grams",
        `fat` decimal(6,2) NOT NULL COMMENT "in grams",
        `fiber` decimal(6,2) NULL COMMENT "in grams",
        `sugar` decimal(6,2) NULL COMMENT "in grams",
        `sodium` decimal(6,2) NULL COMMENT "in mg",
        `cholesterol` decimal(6,2) NULL COMMENT "in mg",
        `vitamins` text NULL COMMENT "JSON data",
        `minerals` text NULL COMMENT "JSON data",
        `allergens` text NULL COMMENT "JSON array",
        `description` text NULL,
        `is_custom` tinyint(1) DEFAULT 0,
        `created_by` int(11) NULL,
        `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
        `updated_at` datetime NULL ON UPDATE CURRENT_TIMESTAMP,
        PRIMARY KEY (`id`),
        KEY `category` (`category`),
        KEY `name` (`name`)
    ) ENGINE=InnoDB DEFAULT CHARSET=' . $CI->db->char_set . ';');
}

if (!$CI->db->table_exists(db_prefix() . 'dpt_meal_plans')) {
    $CI->db->query('CREATE TABLE `' . db_prefix() . 'dpt_meal_plans` (
        `id` int(11) NOT NULL AUTO_INCREMENT,
        `patient_id` int(11) NOT NULL,
        `dietician_id` int(11) NOT NULL,
        `name` varchar(255) NOT NULL,
        `start_date` date NOT NULL,
        `end_date` date NULL,
        `target_calories` int(11) NULL,
        `target_protein` decimal(6,2) NULL COMMENT "in grams",
        `target_carbs` decimal(6,2) NULL COMMENT "in grams",
        `target_fat` decimal(6,2) NULL COMMENT "in grams",
        `description` text NULL,
        `status` enum("draft","active","completed","archived") DEFAULT "draft",
        `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
        `updated_at` datetime NULL ON UPDATE CURRENT_TIMESTAMP,
        PRIMARY KEY (`id`),
        KEY `patient_id` (`patient_id`),
        KEY `dietician_id` (`dietician_id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=' . $CI->db->char_set . ';');
}

if (!$CI->db->table_exists(db_prefix() . 'dpt_meal_plan_items')) {
    $CI->db->query('CREATE TABLE `' . db_prefix() . 'dpt_meal_plan_items` (
        `id` int(11) NOT NULL AUTO_INCREMENT,
        `meal_plan_id` int(11) NOT NULL,
        `day_number` int(11) NOT NULL COMMENT "1-7 for week days",
        `meal_type` enum("breakfast","morning_snack","lunch","afternoon_snack","dinner","evening_snack") NOT NULL,
        `meal_time` time NULL,
        `food_id` int(11) NULL,
        `food_name` varchar(255) NOT NULL,
        `quantity` decimal(6,2) NOT NULL,
        `unit` varchar(50) DEFAULT "g",
        `calories` decimal(6,2) NOT NULL,
        `protein` decimal(6,2) NULL,
        `carbs` decimal(6,2) NULL,
        `fat` decimal(6,2) NULL,
        `instructions` text NULL,
        `sort_order` int(11) DEFAULT 0,
        PRIMARY KEY (`id`),
        KEY `meal_plan_id` (`meal_plan_id`),
        KEY `day_number` (`day_number`)
    ) ENGINE=InnoDB DEFAULT CHARSET=' . $CI->db->char_set . ';');
}

if (!$CI->db->table_exists(db_prefix() . 'dpt_food_diary')) {
    $CI->db->query('CREATE TABLE `' . db_prefix() . 'dpt_food_diary` (
        `id` int(11) NOT NULL AUTO_INCREMENT,
        `patient_id` int(11) NOT NULL,
        `diary_date` date NOT NULL,
        `meal_type` enum("breakfast","morning_snack","lunch","afternoon_snack","dinner","evening_snack","other") NOT NULL,
        `meal_time` time NULL,
        `food_id` int(11) NULL,
        `food_name` varchar(255) NOT NULL,
        `quantity` decimal(6,2) NOT NULL,
        `unit` varchar(50) DEFAULT "g",
        `calories` decimal(6,2) NOT NULL,
        `protein` decimal(6,2) NULL,
        `carbs` decimal(6,2) NULL,
        `fat` decimal(6,2) NULL,
        `notes` text NULL,
        `photo` varchar(255) NULL,
        `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
        PRIMARY KEY (`id`),
        KEY `patient_id` (`patient_id`),
        KEY `diary_date` (`diary_date`)
    ) ENGINE=InnoDB DEFAULT CHARSET=' . $CI->db->char_set . ';');
}

if (!$CI->db->table_exists(db_prefix() . 'dpt_goals')) {
    $CI->db->query('CREATE TABLE `' . db_prefix() . 'dpt_goals` (
        `id` int(11) NOT NULL AUTO_INCREMENT,
        `patient_id` int(11) NOT NULL,
        `goal_type` enum("weight","body_fat","measurements","nutrition","habit","other") NOT NULL,
        `title` varchar(255) NOT NULL,
        `description` text NULL,
        `target_value` decimal(10,2) NULL,
        `current_value` decimal(10,2) NULL,
        `unit` varchar(50) NULL,
        `start_date` date NOT NULL,
        `target_date` date NULL,
        `frequency` enum("daily","weekly","monthly") DEFAULT "weekly",
        `priority` enum("low","medium","high") DEFAULT "medium",
        `status` enum("active","completed","cancelled","on_hold") DEFAULT "active",
        `completion_percentage` int(11) DEFAULT 0,
        `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
        `updated_at` datetime NULL ON UPDATE CURRENT_TIMESTAMP,
        PRIMARY KEY (`id`),
        KEY `patient_id` (`patient_id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=' . $CI->db->char_set . ';');
}

if (!$CI->db->table_exists(db_prefix() . 'dpt_goal_progress')) {
    $CI->db->query('CREATE TABLE `' . db_prefix() . 'dpt_goal_progress` (
        `id` int(11) NOT NULL AUTO_INCREMENT,
        `goal_id` int(11) NOT NULL,
        `progress_date` date NOT NULL,
        `value` decimal(10,2) NOT NULL,
        `notes` text NULL,
        `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
        PRIMARY KEY (`id`),
        KEY `goal_id` (`goal_id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=' . $CI->db->char_set . ';');
}

if (!$CI->db->table_exists(db_prefix() . 'dpt_achievements')) {
    $CI->db->query('CREATE TABLE `' . db_prefix() . 'dpt_achievements` (
        `id` int(11) NOT NULL AUTO_INCREMENT,
        `patient_id` int(11) NOT NULL,
        `achievement_type` varchar(100) NOT NULL,
        `title` varchar(255) NOT NULL,
        `description` text NULL,
        `icon` varchar(100) NULL,
        `points` int(11) DEFAULT 0,
        `earned_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
        PRIMARY KEY (`id`),
        KEY `patient_id` (`patient_id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=' . $CI->db->char_set . ';');
}

if (!$CI->db->table_exists(db_prefix() . 'dpt_messages')) {
    $CI->db->query('CREATE TABLE `' . db_prefix() . 'dpt_messages` (
        `id` int(11) NOT NULL AUTO_INCREMENT,
        `patient_id` int(11) NOT NULL,
        `sender_type` enum("dietician","patient") NOT NULL,
        `sender_id` int(11) NOT NULL,
        `message` text NOT NULL,
        `attachments` text NULL COMMENT "JSON array",
        `is_read` tinyint(1) DEFAULT 0,
        `read_at` datetime NULL,
        `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
        PRIMARY KEY (`id`),
        KEY `patient_id` (`patient_id`),
        KEY `is_read` (`is_read`)
    ) ENGINE=InnoDB DEFAULT CHARSET=' . $CI->db->char_set . ';');
}

if (!$CI->db->table_exists(db_prefix() . 'dpt_recipes')) {
    $CI->db->query('CREATE TABLE `' . db_prefix() . 'dpt_recipes` (
        `id` int(11) NOT NULL AUTO_INCREMENT,
        `name` varchar(255) NOT NULL,
        `category` varchar(100) NULL,
        `cuisine_type` varchar(100) NULL,
        `difficulty_level` enum("easy","medium","hard") DEFAULT "medium",
        `prep_time` int(11) NULL COMMENT "in minutes",
        `cook_time` int(11) NULL COMMENT "in minutes",
        `servings` int(11) DEFAULT 1,
        `ingredients` text NOT NULL COMMENT "JSON array",
        `instructions` text NOT NULL,
        `total_calories` decimal(6,2) NULL,
        `total_protein` decimal(6,2) NULL,
        `total_carbs` decimal(6,2) NULL,
        `total_fat` decimal(6,2) NULL,
        `image` varchar(255) NULL,
        `tags` text NULL COMMENT "JSON array",
        `is_public` tinyint(1) DEFAULT 1,
        `created_by` int(11) NOT NULL,
        `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
        `updated_at` datetime NULL ON UPDATE CURRENT_TIMESTAMP,
        PRIMARY KEY (`id`),
        KEY `category` (`category`)
    ) ENGINE=InnoDB DEFAULT CHARSET=' . $CI->db->char_set . ';');
}

if (!$CI->db->table_exists(db_prefix() . 'dpt_settings')) {
    $CI->db->query('CREATE TABLE `' . db_prefix() . 'dpt_settings` (
        `id` int(11) NOT NULL AUTO_INCREMENT,
        `setting_key` varchar(100) NOT NULL,
        `setting_value` text NULL,
        `setting_type` varchar(50) DEFAULT "string",
        `updated_at` datetime NULL ON UPDATE CURRENT_TIMESTAMP,
        PRIMARY KEY (`id`),
        UNIQUE KEY `setting_key` (`setting_key`)
    ) ENGINE=InnoDB DEFAULT CHARSET=' . $CI->db->char_set . ';');
}

// Insert default settings
$default_settings = [
    ['setting_key' => 'dpt_enable_gamification', 'setting_value' => '1', 'setting_type' => 'boolean'],
    ['setting_key' => 'dpt_enable_messaging', 'setting_value' => '1', 'setting_type' => 'boolean'],
    ['setting_key' => 'dpt_enable_food_diary', 'setting_value' => '1', 'setting_type' => 'boolean'],
    ['setting_key' => 'dpt_default_activity_level', 'setting_value' => 'moderately_active', 'setting_type' => 'string'],
    ['setting_key' => 'dpt_measurement_system', 'setting_value' => 'metric', 'setting_type' => 'string'],
    ['setting_key' => 'dpt_notification_email', 'setting_value' => '1', 'setting_type' => 'boolean'],
    ['setting_key' => 'dpt_consultation_reminder_days', 'setting_value' => '3', 'setting_type' => 'integer'],
];

foreach ($default_settings as $setting) {
    if (!$CI->db->get_where(db_prefix() . 'dpt_settings', ['setting_key' => $setting['setting_key']])->row()) {
        $CI->db->insert(db_prefix() . 'dpt_settings', $setting);
    }
}

// Insert sample food items
$sample_foods = [
    ['name' => 'Pomme', 'category' => 'Fruits', 'serving_size' => 100, 'calories' => 52, 'protein' => 0.3, 'carbohydrates' => 14, 'fat' => 0.2, 'fiber' => 2.4],
    ['name' => 'Banane', 'category' => 'Fruits', 'serving_size' => 100, 'calories' => 89, 'protein' => 1.1, 'carbohydrates' => 23, 'fat' => 0.3, 'fiber' => 2.6],
    ['name' => 'Poulet (blanc)', 'category' => 'Viandes', 'serving_size' => 100, 'calories' => 165, 'protein' => 31, 'carbohydrates' => 0, 'fat' => 3.6, 'fiber' => 0],
    ['name' => 'Riz blanc cuit', 'category' => 'Céréales', 'serving_size' => 100, 'calories' => 130, 'protein' => 2.7, 'carbohydrates' => 28, 'fat' => 0.3, 'fiber' => 0.4],
    ['name' => 'Brocoli', 'category' => 'Légumes', 'serving_size' => 100, 'calories' => 34, 'protein' => 2.8, 'carbohydrates' => 7, 'fat' => 0.4, 'fiber' => 2.6],
    ['name' => 'Saumon', 'category' => 'Poissons', 'serving_size' => 100, 'calories' => 208, 'protein' => 20, 'carbohydrates' => 0, 'fat' => 13, 'fiber' => 0],
    ['name' => 'Œuf entier', 'category' => 'Protéines', 'serving_size' => 50, 'calories' => 72, 'protein' => 6.3, 'carbohydrates' => 0.4, 'fat' => 4.8, 'fiber' => 0],
    ['name' => 'Pain complet', 'category' => 'Céréales', 'serving_size' => 100, 'calories' => 247, 'protein' => 13, 'carbohydrates' => 41, 'fat' => 3.4, 'fiber' => 7],
    ['name' => 'Yaourt nature', 'category' => 'Produits laitiers', 'serving_size' => 100, 'calories' => 59, 'protein' => 10, 'carbohydrates' => 3.6, 'fat' => 0.4, 'fiber' => 0],
    ['name' => 'Amandes', 'category' => 'Noix et graines', 'serving_size' => 100, 'calories' => 579, 'protein' => 21, 'carbohydrates' => 22, 'fat' => 50, 'fiber' => 12.5],
];

foreach ($sample_foods as $food) {
    if (!$CI->db->get_where(db_prefix() . 'dpt_food_library', ['name' => $food['name']])->row()) {
        $CI->db->insert(db_prefix() . 'dpt_food_library', $food);
    }
}
