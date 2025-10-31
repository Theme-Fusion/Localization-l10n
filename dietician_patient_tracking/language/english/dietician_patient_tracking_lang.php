<?php

defined('BASEPATH') or exit('No direct script access allowed');

# Version 1.0.0

// Module
$lang['dietician_patient_tracking'] = 'Dietician Patient Tracking';
$lang['dpt_module_name'] = 'Nutritional Tracking';

// Menu
$lang['dpt_patients'] = 'Patients';
$lang['dpt_consultations'] = 'Consultations';
$lang['dpt_meal_plans'] = 'Meal Plans';
$lang['dpt_food_library'] = 'Food Library';
$lang['dpt_reports'] = 'Reports';
$lang['dpt_my_tracking'] = 'My Tracking';
$lang['dpt_my_profile'] = 'My Profile';
$lang['dpt_my_measurements'] = 'My Measurements';
$lang['dpt_my_meal_plans'] = 'My Meal Plans';
$lang['dpt_my_goals'] = 'My Goals';
$lang['dpt_my_consultations'] = 'My Consultations';
$lang['dpt_my_achievements'] = 'My Achievements';
$lang['dpt_messages'] = 'Messages';

// Patient Management
$lang['dpt_patient'] = 'Patient';
$lang['dpt_add_patient'] = 'Add Patient';
$lang['dpt_edit_patient'] = 'Edit Patient';
$lang['dpt_patient_profile'] = 'Patient Profile';
$lang['dpt_patient_info'] = 'Patient Information';
$lang['dpt_medical_info'] = 'Medical Information';
$lang['dpt_goals_objectives'] = 'Goals & Objectives';

// Patient Fields
$lang['dpt_contact'] = 'Contact';
$lang['dpt_dietician'] = 'Dietician';
$lang['dpt_date_of_birth'] = 'Date of Birth';
$lang['dpt_gender'] = 'Gender';
$lang['dpt_height'] = 'Height';
$lang['dpt_medical_history'] = 'Medical History';
$lang['dpt_allergies'] = 'Allergies';
$lang['dpt_dietary_restrictions'] = 'Dietary Restrictions';
$lang['dpt_activity_level'] = 'Activity Level';
$lang['dpt_goal_type'] = 'Goal Type';
$lang['dpt_target_weight'] = 'Target Weight';
$lang['dpt_weekly_goal'] = 'Weekly Goal';
$lang['dpt_profile_photo'] = 'Profile Photo';
$lang['dpt_notes'] = 'Notes';
$lang['dpt_status'] = 'Status';

// Gender
$lang['dpt_male'] = 'Male';
$lang['dpt_female'] = 'Female';
$lang['dpt_other'] = 'Other';

// Activity Levels
$lang['dpt_activity_sedentary'] = 'Sedentary (little or no exercise)';
$lang['dpt_activity_lightly_active'] = 'Lightly Active (light exercise 1-3 days/week)';
$lang['dpt_activity_moderately_active'] = 'Moderately Active (moderate exercise 3-5 days/week)';
$lang['dpt_activity_very_active'] = 'Very Active (hard exercise 6-7 days/week)';
$lang['dpt_activity_extremely_active'] = 'Extremely Active (very hard exercise daily)';

// Goal Types
$lang['dpt_goal_lose_weight'] = 'Lose Weight';
$lang['dpt_goal_gain_weight'] = 'Gain Weight';
$lang['dpt_goal_maintain'] = 'Maintain Weight';
$lang['dpt_goal_muscle_gain'] = 'Muscle Gain';
$lang['dpt_goal_health'] = 'Health Improvement';

// Status
$lang['dpt_active'] = 'Active';
$lang['dpt_inactive'] = 'Inactive';
$lang['dpt_completed'] = 'Completed';
$lang['dpt_archived'] = 'Archived';

// Measurements
$lang['dpt_measurement'] = 'Measurement';
$lang['dpt_measurements'] = 'Measurements';
$lang['dpt_add_measurement'] = 'Add Measurement';
$lang['dpt_measurement_date'] = 'Measurement Date';
$lang['dpt_weight'] = 'Weight';
$lang['dpt_body_fat_percentage'] = 'Body Fat Percentage';
$lang['dpt_muscle_mass'] = 'Muscle Mass';
$lang['dpt_waist_circumference'] = 'Waist Circumference';
$lang['dpt_hip_circumference'] = 'Hip Circumference';
$lang['dpt_chest_circumference'] = 'Chest Circumference';
$lang['dpt_arm_circumference'] = 'Arm Circumference';
$lang['dpt_thigh_circumference'] = 'Thigh Circumference';
$lang['dpt_blood_pressure'] = 'Blood Pressure';
$lang['dpt_blood_sugar'] = 'Blood Sugar';
$lang['dpt_photos'] = 'Photos';

// Biometric Calculations
$lang['dpt_bmi'] = 'BMI (Body Mass Index)';
$lang['dpt_bmi_underweight'] = 'Underweight';
$lang['dpt_bmi_normal'] = 'Normal Weight';
$lang['dpt_bmi_overweight'] = 'Overweight';
$lang['dpt_bmi_obese'] = 'Obese';
$lang['dpt_bmr'] = 'BMR (Basal Metabolic Rate)';
$lang['dpt_tdee'] = 'TDEE (Total Daily Energy Expenditure)';
$lang['dpt_whr'] = 'Waist-to-Hip Ratio';
$lang['dpt_ideal_weight_range'] = 'Ideal Weight Range';
$lang['dpt_current_weight'] = 'Current Weight';
$lang['dpt_weight_progress'] = 'Weight Progress';
$lang['dpt_weight_change'] = 'Weight Change';

// Risk Levels
$lang['dpt_risk_low'] = 'Low Risk';
$lang['dpt_risk_moderate'] = 'Moderate Risk';
$lang['dpt_risk_high'] = 'High Risk';

// Consultations
$lang['dpt_consultation'] = 'Consultation';
$lang['dpt_add_consultation'] = 'Add Consultation';
$lang['dpt_edit_consultation'] = 'Edit Consultation';
$lang['dpt_consultation_date'] = 'Consultation Date';
$lang['dpt_consultation_type'] = 'Consultation Type';
$lang['dpt_duration'] = 'Duration (minutes)';
$lang['dpt_subject'] = 'Subject';
$lang['dpt_anamnesis'] = 'Anamnesis';
$lang['dpt_diagnosis'] = 'Diagnosis';
$lang['dpt_recommendations'] = 'Recommendations';
$lang['dpt_next_consultation'] = 'Next Consultation';
$lang['dpt_attachments'] = 'Attachments';

// Consultation Types
$lang['dpt_consultation_initial'] = 'Initial Consultation';
$lang['dpt_consultation_followup'] = 'Follow-up Consultation';
$lang['dpt_consultation_emergency'] = 'Emergency Consultation';
$lang['dpt_consultation_final'] = 'Final Consultation';

// Consultation Status
$lang['dpt_scheduled'] = 'Scheduled';
$lang['dpt_cancelled'] = 'Cancelled';
$lang['dpt_no_show'] = 'No Show';

// Food Library
$lang['dpt_food_item'] = 'Food Item';
$lang['dpt_add_food_item'] = 'Add Food Item';
$lang['dpt_edit_food_item'] = 'Edit Food Item';
$lang['dpt_food_name'] = 'Food Name';
$lang['dpt_category'] = 'Category';
$lang['dpt_serving_size'] = 'Serving Size (g)';
$lang['dpt_calories'] = 'Calories';
$lang['dpt_protein'] = 'Protein';
$lang['dpt_carbs'] = 'Carbohydrates';
$lang['dpt_fat'] = 'Fat';
$lang['dpt_fiber'] = 'Fiber';
$lang['dpt_sugar'] = 'Sugar';
$lang['dpt_sodium'] = 'Sodium';
$lang['dpt_cholesterol'] = 'Cholesterol';
$lang['dpt_vitamins'] = 'Vitamins';
$lang['dpt_minerals'] = 'Minerals';
$lang['dpt_allergens'] = 'Allergens';
$lang['dpt_description'] = 'Description';
$lang['dpt_nutritional_info'] = 'Nutritional Information';

// Meal Plans
$lang['dpt_meal_plan'] = 'Meal Plan';
$lang['dpt_add_meal_plan'] = 'Add Meal Plan';
$lang['dpt_edit_meal_plan'] = 'Edit Meal Plan';
$lang['dpt_meal_plan_name'] = 'Plan Name';
$lang['dpt_start_date'] = 'Start Date';
$lang['dpt_end_date'] = 'End Date';
$lang['dpt_target_calories'] = 'Target Calories';
$lang['dpt_target_protein'] = 'Target Protein';
$lang['dpt_target_carbs'] = 'Target Carbs';
$lang['dpt_target_fat'] = 'Target Fat';
$lang['dpt_meal_item'] = 'Meal Item';
$lang['dpt_add_meal_item'] = 'Add Meal Item';
$lang['dpt_day_number'] = 'Day';
$lang['dpt_meal_type'] = 'Meal Type';
$lang['dpt_meal_time'] = 'Meal Time';
$lang['dpt_quantity'] = 'Quantity';
$lang['dpt_unit'] = 'Unit';
$lang['dpt_instructions'] = 'Instructions';

// Meal Types
$lang['dpt_meal_breakfast'] = 'Breakfast';
$lang['dpt_meal_morning_snack'] = 'Morning Snack';
$lang['dpt_meal_lunch'] = 'Lunch';
$lang['dpt_meal_afternoon_snack'] = 'Afternoon Snack';
$lang['dpt_meal_dinner'] = 'Dinner';
$lang['dpt_meal_evening_snack'] = 'Evening Snack';

// Days
$lang['dpt_monday'] = 'Monday';
$lang['dpt_tuesday'] = 'Tuesday';
$lang['dpt_wednesday'] = 'Wednesday';
$lang['dpt_thursday'] = 'Thursday';
$lang['dpt_friday'] = 'Friday';
$lang['dpt_saturday'] = 'Saturday';
$lang['dpt_sunday'] = 'Sunday';

// Food Diary
$lang['dpt_food_diary'] = 'Food Diary';
$lang['dpt_food_entry'] = 'Food Entry';
$lang['dpt_add_food_entry'] = 'Add Food Entry';
$lang['dpt_diary_date'] = 'Date';
$lang['dpt_daily_totals'] = 'Daily Totals';
$lang['dpt_weekly_average'] = 'Weekly Average';

// Goals
$lang['dpt_goal'] = 'Goal';
$lang['dpt_goals'] = 'Goals';
$lang['dpt_add_goal'] = 'Add Goal';
$lang['dpt_goal_title'] = 'Goal Title';
$lang['dpt_target_value'] = 'Target Value';
$lang['dpt_current_value'] = 'Current Value';
$lang['dpt_target_date'] = 'Target Date';
$lang['dpt_frequency'] = 'Frequency';
$lang['dpt_priority'] = 'Priority';
$lang['dpt_completion_percentage'] = 'Completion Percentage';
$lang['dpt_goal_progress'] = 'Goal Progress';

// Frequency
$lang['dpt_daily'] = 'Daily';
$lang['dpt_weekly'] = 'Weekly';
$lang['dpt_monthly'] = 'Monthly';

// Priority
$lang['dpt_low'] = 'Low';
$lang['dpt_medium'] = 'Medium';
$lang['dpt_high'] = 'High';

// Goal Types (detailed)
$lang['dpt_goal_type_weight'] = 'Weight';
$lang['dpt_goal_type_body_fat'] = 'Body Fat';
$lang['dpt_goal_type_measurements'] = 'Measurements';
$lang['dpt_goal_type_nutrition'] = 'Nutrition';
$lang['dpt_goal_type_habit'] = 'Habit';
$lang['dpt_goal_type_other'] = 'Other';

// Achievements
$lang['dpt_achievement'] = 'Achievement';
$lang['dpt_achievements'] = 'Achievements';
$lang['dpt_achievement_earned'] = 'Achievement Unlocked!';
$lang['dpt_points'] = 'Points';
$lang['dpt_total_points'] = 'Total Points';
$lang['dpt_earned_date'] = 'Earned Date';

// Achievement Types
$lang['dpt_achievement_first_measurement'] = 'First Measurement Recorded';
$lang['dpt_achievement_first_week'] = 'One Week of Tracking Completed';
$lang['dpt_achievement_weight_loss_5kg'] = '5 kg Weight Loss';
$lang['dpt_achievement_weight_loss_10kg'] = '10 kg Weight Loss';
$lang['dpt_achievement_goal_completed'] = 'Goal Achieved';
$lang['dpt_achievement_consistent_logging'] = '7 Days Consecutive Logging';

// Messages
$lang['dpt_message'] = 'Message';
$lang['dpt_send_message'] = 'Send Message';
$lang['dpt_message_sent'] = 'Message sent successfully';
$lang['dpt_unread_messages'] = 'Unread Messages';
$lang['dpt_from'] = 'From';
$lang['dpt_to'] = 'To';
$lang['dpt_sent_at'] = 'Sent At';

// Recipes
$lang['dpt_recipe'] = 'Recipe';
$lang['dpt_recipes'] = 'Recipes';
$lang['dpt_add_recipe'] = 'Add Recipe';
$lang['dpt_recipe_name'] = 'Recipe Name';
$lang['dpt_cuisine_type'] = 'Cuisine Type';
$lang['dpt_difficulty_level'] = 'Difficulty Level';
$lang['dpt_prep_time'] = 'Preparation Time';
$lang['dpt_cook_time'] = 'Cooking Time';
$lang['dpt_servings'] = 'Servings';
$lang['dpt_ingredients'] = 'Ingredients';
$lang['dpt_image'] = 'Image';
$lang['dpt_tags'] = 'Tags';

// Difficulty Levels
$lang['dpt_easy'] = 'Easy';
$lang['dpt_hard'] = 'Hard';

// Statistics
$lang['dpt_statistics'] = 'Statistics';
$lang['dpt_total_patients'] = 'Total Patients';
$lang['dpt_total_consultations'] = 'Total Consultations';
$lang['dpt_upcoming_consultations'] = 'Upcoming Consultations';
$lang['dpt_active_goals'] = 'Active Goals';
$lang['dpt_completed_goals'] = 'Completed Goals';
$lang['dpt_total_achievements'] = 'Total Achievements';

// Reports
$lang['dpt_generate_report'] = 'Generate Report';
$lang['dpt_report_period'] = 'Report Period';
$lang['dpt_export_pdf'] = 'Export to PDF';
$lang['dpt_export_excel'] = 'Export to Excel';
$lang['dpt_progress_report'] = 'Progress Report';
$lang['dpt_monthly_report'] = 'Monthly Report';
$lang['dpt_quarterly_report'] = 'Quarterly Report';

// Settings
$lang['dpt_enable_gamification'] = 'Enable Gamification';
$lang['dpt_enable_messaging'] = 'Enable Messaging';
$lang['dpt_enable_food_diary'] = 'Enable Food Diary';
$lang['dpt_default_activity_level'] = 'Default Activity Level';
$lang['dpt_measurement_system'] = 'Measurement System';
$lang['dpt_notification_email'] = 'Email Notifications';
$lang['dpt_consultation_reminder_days'] = 'Consultation Reminder (days before)';

// Common Actions
$lang['dpt_view'] = 'View';
$lang['dpt_edit'] = 'Edit';
$lang['dpt_delete'] = 'Delete';
$lang['dpt_save'] = 'Save';
$lang['dpt_cancel'] = 'Cancel';
$lang['dpt_add'] = 'Add';
$lang['dpt_search'] = 'Search';
$lang['dpt_filter'] = 'Filter';
$lang['dpt_export'] = 'Export';
$lang['dpt_print'] = 'Print';
$lang['dpt_back'] = 'Back';

// Units
$lang['dpt_kg'] = 'kg';
$lang['dpt_cm'] = 'cm';
$lang['dpt_kcal'] = 'kcal';
$lang['dpt_g'] = 'g';
$lang['dpt_mg'] = 'mg';
$lang['dpt_l'] = 'L';
$lang['dpt_ml'] = 'mL';
$lang['dpt_minutes'] = 'minutes';

// Messages
$lang['dpt_no_patients'] = 'No patients found';
$lang['dpt_no_consultations'] = 'No consultations found';
$lang['dpt_no_measurements'] = 'No measurements recorded';
$lang['dpt_no_meal_plans'] = 'No meal plans';
$lang['dpt_no_goals'] = 'No goals defined';
$lang['dpt_no_achievements'] = 'No achievements unlocked';
$lang['dpt_no_messages'] = 'No messages';
$lang['dpt_patient_not_found'] = 'Patient not found';

// Dashboard
$lang['dpt_dashboard'] = 'Dashboard';
$lang['dpt_overview'] = 'Overview';
$lang['dpt_recent_activity'] = 'Recent Activity';
$lang['dpt_quick_stats'] = 'Quick Stats';
$lang['dpt_upcoming_events'] = 'Upcoming Events';

// Notifications
$lang['dpt_notification_new_measurement'] = 'New measurement recorded';
$lang['dpt_notification_consultation_reminder'] = 'Consultation reminder';
$lang['dpt_notification_goal_achieved'] = 'Goal achieved!';
$lang['dpt_notification_new_message'] = 'New message received';

// Help Text
$lang['dpt_help_bmi'] = 'BMI is calculated by dividing weight (kg) by the square of height (m)';
$lang['dpt_help_bmr'] = 'Basal metabolic rate represents calories burned at rest';
$lang['dpt_help_tdee'] = 'Total daily energy expenditure includes physical activity';
$lang['dpt_help_water_intake'] = 'Recommendation: 35ml per kg of body weight';

// Additional translations
$lang['dpt_all_time'] = 'All Time';
$lang['dpt_next_7_days'] = 'Next 7 Days';
$lang['dpt_active_meal_plans'] = 'Active Meal Plans';
$lang['dpt_recent_activity'] = 'Recent Activity';
$lang['dpt_upcoming_events'] = 'Upcoming Events';
$lang['dpt_date'] = 'Date';
$lang['dpt_type'] = 'Type';
$lang['dpt_created_at'] = 'Created At';
$lang['dpt_biometric_data'] = 'Biometric Data';
$lang['dpt_select_patient_to_view_report'] = 'Select a patient to view their report';
$lang['dpt_select_patient'] = 'Select Patient';
$lang['dpt_recent_consultations'] = 'Recent Consultations';
$lang['dpt_track_daily_meals'] = 'Track your daily meals';
$lang['you'] = 'You';
$lang['welcome'] = 'Welcome';
$lang['draft'] = 'Draft';
$lang['select'] = 'Select';
$lang['send'] = 'Send';
