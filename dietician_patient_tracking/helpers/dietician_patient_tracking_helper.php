<?php

defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Helper functions for Dietician Patient Tracking module
 */

/**
 * Calculate BMI (Body Mass Index)
 * @param float $weight Weight in kg
 * @param float $height Height in cm
 * @return float BMI value
 */
function dpt_calculate_bmi($weight, $height)
{
    if ($height <= 0 || $weight <= 0) {
        return 0;
    }

    $height_m = $height / 100;
    return round($weight / ($height_m * $height_m), 2);
}

/**
 * Get BMI category
 * @param float $bmi BMI value
 * @return string Category name
 */
function dpt_get_bmi_category($bmi)
{
    if ($bmi < 18.5) {
        return _l('dpt_bmi_underweight');
    } elseif ($bmi < 25) {
        return _l('dpt_bmi_normal');
    } elseif ($bmi < 30) {
        return _l('dpt_bmi_overweight');
    } else {
        return _l('dpt_bmi_obese');
    }
}

/**
 * Get BMI category color
 * @param float $bmi BMI value
 * @return string Color code
 */
function dpt_get_bmi_color($bmi)
{
    if ($bmi < 18.5) {
        return '#FFA500'; // Orange
    } elseif ($bmi < 25) {
        return '#28a745'; // Green
    } elseif ($bmi < 30) {
        return '#FFA500'; // Orange
    } else {
        return '#dc3545'; // Red
    }
}

/**
 * Calculate BMR (Basal Metabolic Rate) using Mifflin-St Jeor Equation
 * @param float $weight Weight in kg
 * @param float $height Height in cm
 * @param int $age Age in years
 * @param string $gender 'male' or 'female'
 * @return float BMR in calories
 */
function dpt_calculate_bmr($weight, $height, $age, $gender)
{
    if ($weight <= 0 || $height <= 0 || $age <= 0) {
        return 0;
    }

    if ($gender == 'male') {
        $bmr = (10 * $weight) + (6.25 * $height) - (5 * $age) + 5;
    } else {
        $bmr = (10 * $weight) + (6.25 * $height) - (5 * $age) - 161;
    }

    return round($bmr);
}

/**
 * Calculate TDEE (Total Daily Energy Expenditure)
 * @param float $bmr Basal Metabolic Rate
 * @param string $activity_level Activity level
 * @return float TDEE in calories
 */
function dpt_calculate_tdee($bmr, $activity_level)
{
    $multipliers = [
        'sedentary' => 1.2,
        'lightly_active' => 1.375,
        'moderately_active' => 1.55,
        'very_active' => 1.725,
        'extremely_active' => 1.9
    ];

    $multiplier = isset($multipliers[$activity_level]) ? $multipliers[$activity_level] : 1.2;
    return round($bmr * $multiplier);
}

/**
 * Calculate Body Fat Percentage (using US Navy method)
 * @param string $gender 'male' or 'female'
 * @param float $height Height in cm
 * @param float $waist Waist circumference in cm
 * @param float $neck Neck circumference in cm
 * @param float $hip Hip circumference in cm (for females)
 * @return float Body fat percentage
 */
function dpt_calculate_body_fat($gender, $height, $waist, $neck, $hip = 0)
{
    if ($height <= 0 || $waist <= 0 || $neck <= 0) {
        return 0;
    }

    if ($gender == 'male') {
        $body_fat = 495 / (1.0324 - 0.19077 * log10($waist - $neck) + 0.15456 * log10($height)) - 450;
    } else {
        if ($hip <= 0) {
            return 0;
        }
        $body_fat = 495 / (1.29579 - 0.35004 * log10($waist + $hip - $neck) + 0.22100 * log10($height)) - 450;
    }

    return round(max(0, $body_fat), 2);
}

/**
 * Calculate Waist-to-Hip Ratio
 * @param float $waist Waist circumference in cm
 * @param float $hip Hip circumference in cm
 * @return float Ratio
 */
function dpt_calculate_waist_to_hip_ratio($waist, $hip)
{
    if ($hip <= 0) {
        return 0;
    }

    return round($waist / $hip, 2);
}

/**
 * Get waist-to-hip ratio health risk
 * @param float $ratio Waist-to-hip ratio
 * @param string $gender Gender
 * @return string Risk level
 */
function dpt_get_whr_risk($ratio, $gender)
{
    if ($gender == 'male') {
        if ($ratio < 0.95) {
            return _l('dpt_risk_low');
        } elseif ($ratio < 1.0) {
            return _l('dpt_risk_moderate');
        } else {
            return _l('dpt_risk_high');
        }
    } else {
        if ($ratio < 0.80) {
            return _l('dpt_risk_low');
        } elseif ($ratio < 0.85) {
            return _l('dpt_risk_moderate');
        } else {
            return _l('dpt_risk_high');
        }
    }
}

/**
 * Calculate ideal weight range using BMI
 * @param float $height Height in cm
 * @return array Min and max ideal weight
 */
function dpt_calculate_ideal_weight_range($height)
{
    $height_m = $height / 100;

    return [
        'min' => round(18.5 * ($height_m * $height_m), 1),
        'max' => round(24.9 * ($height_m * $height_m), 1)
    ];
}

/**
 * Calculate macronutrient distribution
 * @param int $total_calories Total daily calories
 * @param string $goal_type Goal type (lose_weight, gain_weight, etc.)
 * @return array Protein, carbs, fat in grams
 */
function dpt_calculate_macros($total_calories, $goal_type = 'maintain')
{
    // Default balanced diet: 30% protein, 40% carbs, 30% fat
    $ratios = [
        'lose_weight' => ['protein' => 0.35, 'carbs' => 0.35, 'fat' => 0.30],
        'gain_weight' => ['protein' => 0.30, 'carbs' => 0.45, 'fat' => 0.25],
        'muscle_gain' => ['protein' => 0.40, 'carbs' => 0.40, 'fat' => 0.20],
        'maintain' => ['protein' => 0.30, 'carbs' => 0.40, 'fat' => 0.30],
        'health' => ['protein' => 0.25, 'carbs' => 0.45, 'fat' => 0.30]
    ];

    $ratio = isset($ratios[$goal_type]) ? $ratios[$goal_type] : $ratios['maintain'];

    return [
        'protein' => round(($total_calories * $ratio['protein']) / 4), // 4 cal per gram
        'carbs' => round(($total_calories * $ratio['carbs']) / 4),
        'fat' => round(($total_calories * $ratio['fat']) / 9) // 9 cal per gram
    ];
}

/**
 * Calculate daily water intake recommendation (in liters)
 * @param float $weight Weight in kg
 * @param string $activity_level Activity level
 * @return float Water in liters
 */
function dpt_calculate_water_intake($weight, $activity_level = 'moderately_active')
{
    // Base: 35ml per kg of body weight
    $base_ml = $weight * 35;

    // Adjust for activity
    $multipliers = [
        'sedentary' => 1.0,
        'lightly_active' => 1.1,
        'moderately_active' => 1.2,
        'very_active' => 1.3,
        'extremely_active' => 1.5
    ];

    $multiplier = isset($multipliers[$activity_level]) ? $multipliers[$activity_level] : 1.0;

    return round(($base_ml * $multiplier) / 1000, 1); // Convert to liters
}

/**
 * Format measurement value with unit
 * @param float $value Value
 * @param string $type Measurement type
 * @return string Formatted value
 */
function dpt_format_measurement($value, $type)
{
    if (empty($value)) {
        return '-';
    }

    $units = [
        'weight' => 'kg',
        'height' => 'cm',
        'circumference' => 'cm',
        'body_fat' => '%',
        'calories' => 'kcal',
        'protein' => 'g',
        'carbs' => 'g',
        'fat' => 'g',
        'water' => 'L'
    ];

    $unit = isset($units[$type]) ? $units[$type] : '';
    return number_format($value, 1) . ' ' . $unit;
}

/**
 * Get activity level options
 * @return array Activity levels
 */
function dpt_get_activity_levels()
{
    return [
        'sedentary' => _l('dpt_activity_sedentary'),
        'lightly_active' => _l('dpt_activity_lightly_active'),
        'moderately_active' => _l('dpt_activity_moderately_active'),
        'very_active' => _l('dpt_activity_very_active'),
        'extremely_active' => _l('dpt_activity_extremely_active')
    ];
}

/**
 * Get goal types
 * @return array Goal types
 */
function dpt_get_goal_types()
{
    return [
        'lose_weight' => _l('dpt_goal_lose_weight'),
        'gain_weight' => _l('dpt_goal_gain_weight'),
        'maintain' => _l('dpt_goal_maintain'),
        'muscle_gain' => _l('dpt_goal_muscle_gain'),
        'health' => _l('dpt_goal_health')
    ];
}

/**
 * Get meal types
 * @return array Meal types
 */
function dpt_get_meal_types()
{
    return [
        'breakfast' => _l('dpt_meal_breakfast'),
        'morning_snack' => _l('dpt_meal_morning_snack'),
        'lunch' => _l('dpt_meal_lunch'),
        'afternoon_snack' => _l('dpt_meal_afternoon_snack'),
        'dinner' => _l('dpt_meal_dinner'),
        'evening_snack' => _l('dpt_meal_evening_snack')
    ];
}

/**
 * Calculate age from date of birth
 * @param string $date_of_birth Date of birth (Y-m-d)
 * @return int Age in years
 */
function dpt_calculate_age($date_of_birth)
{
    if (empty($date_of_birth)) {
        return 0;
    }

    $dob = new DateTime($date_of_birth);
    $now = new DateTime();
    $age = $now->diff($dob);

    return $age->y;
}

/**
 * Generate weight progress chart data
 * @param array $measurements Array of measurement objects
 * @return array Chart data
 */
function dpt_generate_weight_chart_data($measurements)
{
    $data = [
        'labels' => [],
        'values' => []
    ];

    foreach ($measurements as $measurement) {
        $data['labels'][] = date('d/m/Y', strtotime($measurement->measurement_date));
        $data['values'][] = (float)$measurement->weight;
    }

    return $data;
}

/**
 * Check if patient achieved a milestone
 * @param int $patient_id Patient ID
 * @param string $milestone_type Type of milestone
 * @return bool
 */
function dpt_check_achievement($patient_id, $milestone_type)
{
    $CI = &get_instance();
    $CI->load->model('dietician_patient_tracking/dietician_patient_tracking_model');

    $achievements = [
        'first_measurement' => ['title' => _l('dpt_achievement_first_measurement'), 'icon' => 'fa-trophy', 'points' => 10],
        'first_week' => ['title' => _l('dpt_achievement_first_week'), 'icon' => 'fa-calendar', 'points' => 20],
        'weight_loss_5kg' => ['title' => _l('dpt_achievement_weight_loss_5kg'), 'icon' => 'fa-star', 'points' => 50],
        'weight_loss_10kg' => ['title' => _l('dpt_achievement_weight_loss_10kg'), 'icon' => 'fa-star-o', 'points' => 100],
        'goal_completed' => ['title' => _l('dpt_achievement_goal_completed'), 'icon' => 'fa-check-circle', 'points' => 30],
        'consistent_logging' => ['title' => _l('dpt_achievement_consistent_logging'), 'icon' => 'fa-pencil', 'points' => 25]
    ];

    if (isset($achievements[$milestone_type])) {
        $achievement = $achievements[$milestone_type];

        // Check if already earned
        $existing = $CI->db->get_where(db_prefix() . 'dpt_achievements', [
            'patient_id' => $patient_id,
            'achievement_type' => $milestone_type
        ])->row();

        if (!$existing) {
            // Grant achievement
            $CI->dietician_patient_tracking_model->add_achievement([
                'patient_id' => $patient_id,
                'achievement_type' => $milestone_type,
                'title' => $achievement['title'],
                'icon' => $achievement['icon'],
                'points' => $achievement['points']
            ]);

            return true;
        }
    }

    return false;
}

/**
 * Get consultation types
 * @return array Consultation types
 */
function dpt_get_consultation_types()
{
    return [
        'initial' => _l('dpt_consultation_initial'),
        'followup' => _l('dpt_consultation_followup'),
        'emergency' => _l('dpt_consultation_emergency'),
        'final' => _l('dpt_consultation_final')
    ];
}

/**
 * Format nutritional value display
 * @param object $food Food item object
 * @return string HTML formatted nutrition facts
 */
function dpt_format_nutrition_facts($food)
{
    $html = '<div class="nutrition-facts">';
    $html .= '<div class="nf-row"><span>' . _l('dpt_calories') . ':</span> <strong>' . $food->calories . ' kcal</strong></div>';
    $html .= '<div class="nf-row"><span>' . _l('dpt_protein') . ':</span> <strong>' . $food->protein . ' g</strong></div>';
    $html .= '<div class="nf-row"><span>' . _l('dpt_carbs') . ':</span> <strong>' . $food->carbohydrates . ' g</strong></div>';
    $html .= '<div class="nf-row"><span>' . _l('dpt_fat') . ':</span> <strong>' . $food->fat . ' g</strong></div>';
    if (isset($food->fiber) && $food->fiber > 0) {
        $html .= '<div class="nf-row"><span>' . _l('dpt_fiber') . ':</span> <strong>' . $food->fiber . ' g</strong></div>';
    }
    $html .= '</div>';

    return $html;
}

/**
 * Send notification to patient
 * @param int $contact_id Contact ID
 * @param string $subject Subject
 * @param string $message Message
 * @return bool
 */
function dpt_send_patient_notification($contact_id, $subject, $message)
{
    $CI = &get_instance();
    $CI->load->model('emails_model');

    $contact = $CI->clients_model->get_contact($contact_id);

    if ($contact && !empty($contact->email)) {
        return $CI->emails_model->send_simple_email($contact->email, $subject, $message);
    }

    return false;
}
