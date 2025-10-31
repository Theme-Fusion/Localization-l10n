<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Dietician_patient_tracking_model extends App_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * PATIENT PROFILES
     */

    public function get_patient_profile($id = null, $contact_id = null)
    {
        if ($id) {
            return $this->db->get_where(db_prefix() . 'dpt_patient_profiles', ['id' => $id])->row();
        } elseif ($contact_id) {
            return $this->db->get_where(db_prefix() . 'dpt_patient_profiles', ['contact_id' => $contact_id])->row();
        }
        return false;
    }

    public function get_all_patients($filters = [])
    {
        $this->db->select('p.*, c.firstname, c.lastname, c.email, s.firstname as dietician_firstname, s.lastname as dietician_lastname');
        $this->db->from(db_prefix() . 'dpt_patient_profiles p');
        $this->db->join(db_prefix() . 'contacts c', 'c.id = p.contact_id');
        $this->db->join(db_prefix() . 'staff s', 's.staffid = p.dietician_id', 'left');

        if (isset($filters['status'])) {
            $this->db->where('p.status', $filters['status']);
        }
        if (isset($filters['dietician_id'])) {
            $this->db->where('p.dietician_id', $filters['dietician_id']);
        }

        $this->db->order_by('p.created_at', 'DESC');
        return $this->db->get()->result();
    }

    public function add_patient_profile($data)
    {
        // Clean data - remove empty strings for optional fields
        foreach ($data as $key => $value) {
            if ($value === '' && !in_array($key, ['contact_id', 'client_id', 'dietician_id'])) {
                $data[$key] = null;
            }
        }

        // Ensure required fields are present
        if (empty($data['contact_id']) || empty($data['client_id']) || empty($data['dietician_id'])) {
            log_activity('Patient Profile Creation Failed: Missing required fields');
            return false;
        }

        $this->db->insert(db_prefix() . 'dpt_patient_profiles', $data);

        // Check for database errors
        $error = $this->db->error();
        if ($error['code'] != 0) {
            log_activity('Patient Profile Creation Failed: ' . $error['message']);
            return false;
        }

        $insert_id = $this->db->insert_id();

        if ($insert_id) {
            log_activity('New Patient Profile Created [ID: ' . $insert_id . ']');
        }

        return $insert_id;
    }

    public function update_patient_profile($id, $data)
    {
        $this->db->where('id', $id);
        $this->db->update(db_prefix() . 'dpt_patient_profiles', $data);

        if ($this->db->affected_rows() > 0) {
            log_activity('Patient Profile Updated [ID: ' . $id . ']');
            return true;
        }

        return false;
    }

    public function delete_patient_profile($id)
    {
        $this->db->where('id', $id);
        $this->db->delete(db_prefix() . 'dpt_patient_profiles');

        if ($this->db->affected_rows() > 0) {
            // Delete related data
            $this->db->where('patient_id', $id);
            $this->db->delete(db_prefix() . 'dpt_measurements');

            $this->db->where('patient_id', $id);
            $this->db->delete(db_prefix() . 'dpt_consultations');

            log_activity('Patient Profile Deleted [ID: ' . $id . ']');
            return true;
        }

        return false;
    }

    /**
     * MEASUREMENTS
     */

    public function add_measurement($data)
    {
        // Clean data - remove empty strings for optional fields
        foreach ($data as $key => $value) {
            if ($value === '' && !in_array($key, ['patient_id', 'measurement_date', 'weight', 'created_by'])) {
                $data[$key] = null;
            }
        }

        // Ensure required fields are present
        if (empty($data['patient_id']) || empty($data['measurement_date']) || empty($data['weight'])) {
            log_activity('Measurement Creation Failed: Missing required fields');
            return false;
        }

        $this->db->insert(db_prefix() . 'dpt_measurements', $data);

        // Check for database errors
        $error = $this->db->error();
        if ($error['code'] != 0) {
            log_activity('Measurement Creation Failed: ' . $error['message']);
            return false;
        }

        $insert_id = $this->db->insert_id();

        if ($insert_id) {
            log_activity('New Measurement Added [Patient ID: ' . $data['patient_id'] . ']');
        }

        return $insert_id;
    }

    public function get_measurements($patient_id, $limit = null)
    {
        $this->db->where('patient_id', $patient_id);
        $this->db->order_by('measurement_date', 'DESC');

        if ($limit) {
            $this->db->limit($limit);
        }

        return $this->db->get(db_prefix() . 'dpt_measurements')->result();
    }

    public function get_measurement($id)
    {
        return $this->db->get_where(db_prefix() . 'dpt_measurements', ['id' => $id])->row();
    }

    public function update_measurement($id, $data)
    {
        $this->db->where('id', $id);
        $this->db->update(db_prefix() . 'dpt_measurements', $data);
        return $this->db->affected_rows() > 0;
    }

    public function delete_measurement($id)
    {
        $this->db->where('id', $id);
        $this->db->delete(db_prefix() . 'dpt_measurements');
        return $this->db->affected_rows() > 0;
    }

    public function get_latest_measurement($patient_id)
    {
        $this->db->where('patient_id', $patient_id);
        $this->db->order_by('measurement_date', 'DESC');
        $this->db->limit(1);
        return $this->db->get(db_prefix() . 'dpt_measurements')->row();
    }

    /**
     * CONSULTATIONS
     */

    public function add_consultation($data)
    {
        $this->db->insert(db_prefix() . 'dpt_consultations', $data);
        $insert_id = $this->db->insert_id();

        if ($insert_id) {
            log_activity('New Consultation Created [ID: ' . $insert_id . ']');
        }

        return $insert_id;
    }

    public function get_consultations($patient_id = null, $filters = [])
    {
        $this->db->select('c.*, p.contact_id, co.firstname, co.lastname, s.firstname as dietician_firstname, s.lastname as dietician_lastname');
        $this->db->from(db_prefix() . 'dpt_consultations c');
        $this->db->join(db_prefix() . 'dpt_patient_profiles p', 'p.id = c.patient_id');
        $this->db->join(db_prefix() . 'contacts co', 'co.id = p.contact_id');
        $this->db->join(db_prefix() . 'staff s', 's.staffid = c.dietician_id', 'left');

        if ($patient_id) {
            $this->db->where('c.patient_id', $patient_id);
        }

        if (isset($filters['status'])) {
            $this->db->where('c.status', $filters['status']);
        }

        if (isset($filters['dietician_id'])) {
            $this->db->where('c.dietician_id', $filters['dietician_id']);
        }

        if (isset($filters['from_date'])) {
            $this->db->where('c.consultation_date >=', $filters['from_date']);
        }

        if (isset($filters['to_date'])) {
            $this->db->where('c.consultation_date <=', $filters['to_date']);
        }

        $this->db->order_by('c.consultation_date', 'DESC');
        return $this->db->get()->result();
    }

    public function get_consultation($id)
    {
        $this->db->select('c.*, p.contact_id, co.firstname, co.lastname, co.email');
        $this->db->from(db_prefix() . 'dpt_consultations c');
        $this->db->join(db_prefix() . 'dpt_patient_profiles p', 'p.id = c.patient_id');
        $this->db->join(db_prefix() . 'contacts co', 'co.id = p.contact_id');
        $this->db->where('c.id', $id);
        return $this->db->get()->row();
    }

    public function update_consultation($id, $data)
    {
        $this->db->where('id', $id);
        $this->db->update(db_prefix() . 'dpt_consultations', $data);

        if ($this->db->affected_rows() > 0) {
            log_activity('Consultation Updated [ID: ' . $id . ']');
            return true;
        }

        return false;
    }

    public function delete_consultation($id)
    {
        $this->db->where('id', $id);
        $this->db->delete(db_prefix() . 'dpt_consultations');

        if ($this->db->affected_rows() > 0) {
            log_activity('Consultation Deleted [ID: ' . $id . ']');
            return true;
        }

        return false;
    }

    /**
     * FOOD LIBRARY
     */

    public function get_food_items($category = null, $search = null)
    {
        if ($category) {
            $this->db->where('category', $category);
        }

        if ($search) {
            $this->db->like('name', $search);
        }

        $this->db->order_by('name', 'ASC');
        return $this->db->get(db_prefix() . 'dpt_food_library')->result();
    }

    public function get_food_item($id)
    {
        return $this->db->get_where(db_prefix() . 'dpt_food_library', ['id' => $id])->row();
    }

    public function add_food_item($data)
    {
        $this->db->insert(db_prefix() . 'dpt_food_library', $data);
        return $this->db->insert_id();
    }

    public function update_food_item($id, $data)
    {
        $this->db->where('id', $id);
        $this->db->update(db_prefix() . 'dpt_food_library', $data);
        return $this->db->affected_rows() > 0;
    }

    public function delete_food_item($id)
    {
        $this->db->where('id', $id);
        $this->db->delete(db_prefix() . 'dpt_food_library');
        return $this->db->affected_rows() > 0;
    }

    public function get_food_categories()
    {
        $this->db->select('DISTINCT category');
        $this->db->where('category IS NOT NULL');
        $this->db->order_by('category', 'ASC');
        return $this->db->get(db_prefix() . 'dpt_food_library')->result();
    }

    /**
     * MEAL PLANS
     */

    public function add_meal_plan($data)
    {
        $this->db->insert(db_prefix() . 'dpt_meal_plans', $data);
        $insert_id = $this->db->insert_id();

        if ($insert_id) {
            log_activity('New Meal Plan Created [ID: ' . $insert_id . ']');
        }

        return $insert_id;
    }

    public function get_meal_plans($patient_id = null, $filters = [])
    {
        $this->db->select('m.*, p.contact_id, c.firstname, c.lastname');
        $this->db->from(db_prefix() . 'dpt_meal_plans m');
        $this->db->join(db_prefix() . 'dpt_patient_profiles p', 'p.id = m.patient_id');
        $this->db->join(db_prefix() . 'contacts c', 'c.id = p.contact_id');

        if ($patient_id) {
            $this->db->where('m.patient_id', $patient_id);
        }

        if (isset($filters['status'])) {
            $this->db->where('m.status', $filters['status']);
        }

        $this->db->order_by('m.start_date', 'DESC');
        return $this->db->get()->result();
    }

    public function get_meal_plan($id)
    {
        return $this->db->get_where(db_prefix() . 'dpt_meal_plans', ['id' => $id])->row();
    }

    public function update_meal_plan($id, $data)
    {
        $this->db->where('id', $id);
        $this->db->update(db_prefix() . 'dpt_meal_plans', $data);
        return $this->db->affected_rows() > 0;
    }

    public function delete_meal_plan($id)
    {
        // Delete meal plan items first
        $this->db->where('meal_plan_id', $id);
        $this->db->delete(db_prefix() . 'dpt_meal_plan_items');

        // Delete meal plan
        $this->db->where('id', $id);
        $this->db->delete(db_prefix() . 'dpt_meal_plans');

        return $this->db->affected_rows() > 0;
    }

    public function add_meal_plan_item($data)
    {
        $this->db->insert(db_prefix() . 'dpt_meal_plan_items', $data);
        return $this->db->insert_id();
    }

    public function get_meal_plan_items($meal_plan_id)
    {
        $this->db->where('meal_plan_id', $meal_plan_id);
        $this->db->order_by('day_number', 'ASC');
        $this->db->order_by('sort_order', 'ASC');
        return $this->db->get(db_prefix() . 'dpt_meal_plan_items')->result();
    }

    public function delete_meal_plan_item($id)
    {
        $this->db->where('id', $id);
        $this->db->delete(db_prefix() . 'dpt_meal_plan_items');
        return $this->db->affected_rows() > 0;
    }

    /**
     * FOOD DIARY
     */

    public function add_food_diary_entry($data)
    {
        $this->db->insert(db_prefix() . 'dpt_food_diary', $data);
        return $this->db->insert_id();
    }

    public function get_food_diary($patient_id, $from_date = null, $to_date = null)
    {
        $this->db->where('patient_id', $patient_id);

        if ($from_date) {
            $this->db->where('diary_date >=', $from_date);
        }

        if ($to_date) {
            $this->db->where('diary_date <=', $to_date);
        }

        $this->db->order_by('diary_date', 'DESC');
        $this->db->order_by('meal_time', 'ASC');
        return $this->db->get(db_prefix() . 'dpt_food_diary')->result();
    }

    public function delete_food_diary_entry($id)
    {
        $this->db->where('id', $id);
        $this->db->delete(db_prefix() . 'dpt_food_diary');
        return $this->db->affected_rows() > 0;
    }

    /**
     * GOALS
     */

    public function add_goal($data)
    {
        $this->db->insert(db_prefix() . 'dpt_goals', $data);
        return $this->db->insert_id();
    }

    public function get_goals($patient_id, $status = null)
    {
        $this->db->where('patient_id', $patient_id);

        if ($status) {
            $this->db->where('status', $status);
        }

        $this->db->order_by('priority', 'DESC');
        $this->db->order_by('target_date', 'ASC');
        return $this->db->get(db_prefix() . 'dpt_goals')->result();
    }

    public function get_goal($id)
    {
        return $this->db->get_where(db_prefix() . 'dpt_goals', ['id' => $id])->row();
    }

    public function update_goal($id, $data)
    {
        $this->db->where('id', $id);
        $this->db->update(db_prefix() . 'dpt_goals', $data);
        return $this->db->affected_rows() > 0;
    }

    public function delete_goal($id)
    {
        $this->db->where('goal_id', $id);
        $this->db->delete(db_prefix() . 'dpt_goal_progress');

        $this->db->where('id', $id);
        $this->db->delete(db_prefix() . 'dpt_goals');
        return $this->db->affected_rows() > 0;
    }

    public function add_goal_progress($data)
    {
        $this->db->insert(db_prefix() . 'dpt_goal_progress', $data);

        // Update goal completion percentage
        $goal = $this->get_goal($data['goal_id']);
        if ($goal && $goal->target_value > 0) {
            $percentage = min(100, ($data['value'] / $goal->target_value) * 100);
            $this->update_goal($data['goal_id'], [
                'current_value' => $data['value'],
                'completion_percentage' => round($percentage)
            ]);

            // Check if goal is completed
            if ($percentage >= 100) {
                $this->update_goal($data['goal_id'], ['status' => 'completed']);
            }
        }

        return $this->db->insert_id();
    }

    public function get_goal_progress($goal_id)
    {
        $this->db->where('goal_id', $goal_id);
        $this->db->order_by('progress_date', 'ASC');
        return $this->db->get(db_prefix() . 'dpt_goal_progress')->result();
    }

    /**
     * ACHIEVEMENTS
     */

    public function add_achievement($data)
    {
        $this->db->insert(db_prefix() . 'dpt_achievements', $data);
        return $this->db->insert_id();
    }

    public function get_achievements($patient_id)
    {
        $this->db->where('patient_id', $patient_id);
        $this->db->order_by('earned_date', 'DESC');
        return $this->db->get(db_prefix() . 'dpt_achievements')->result();
    }

    /**
     * MESSAGES
     */

    public function add_message($data)
    {
        $this->db->insert(db_prefix() . 'dpt_messages', $data);
        return $this->db->insert_id();
    }

    public function get_messages($patient_id)
    {
        $this->db->where('patient_id', $patient_id);
        $this->db->order_by('created_at', 'DESC');
        return $this->db->get(db_prefix() . 'dpt_messages')->result();
    }

    public function mark_message_as_read($id)
    {
        $this->db->where('id', $id);
        $this->db->update(db_prefix() . 'dpt_messages', [
            'is_read' => 1,
            'read_at' => date('Y-m-d H:i:s')
        ]);
        return $this->db->affected_rows() > 0;
    }

    public function get_unread_messages_count($patient_id, $recipient_type)
    {
        $this->db->where('patient_id', $patient_id);
        $this->db->where('sender_type !=', $recipient_type);
        $this->db->where('is_read', 0);
        return $this->db->count_all_results(db_prefix() . 'dpt_messages');
    }

    /**
     * RECIPES
     */

    public function add_recipe($data)
    {
        $this->db->insert(db_prefix() . 'dpt_recipes', $data);
        return $this->db->insert_id();
    }

    public function get_recipes($filters = [])
    {
        if (isset($filters['category'])) {
            $this->db->where('category', $filters['category']);
        }

        if (isset($filters['search'])) {
            $this->db->like('name', $filters['search']);
        }

        if (isset($filters['is_public'])) {
            $this->db->where('is_public', $filters['is_public']);
        }

        $this->db->order_by('created_at', 'DESC');
        return $this->db->get(db_prefix() . 'dpt_recipes')->result();
    }

    public function get_recipe($id)
    {
        return $this->db->get_where(db_prefix() . 'dpt_recipes', ['id' => $id])->row();
    }

    public function update_recipe($id, $data)
    {
        $this->db->where('id', $id);
        $this->db->update(db_prefix() . 'dpt_recipes', $data);
        return $this->db->affected_rows() > 0;
    }

    public function delete_recipe($id)
    {
        $this->db->where('id', $id);
        $this->db->delete(db_prefix() . 'dpt_recipes');
        return $this->db->affected_rows() > 0;
    }

    /**
     * SETTINGS
     */

    public function get_setting($key)
    {
        $setting = $this->db->get_where(db_prefix() . 'dpt_settings', ['setting_key' => $key])->row();
        return $setting ? $setting->setting_value : null;
    }

    public function update_setting($key, $value)
    {
        $exists = $this->db->get_where(db_prefix() . 'dpt_settings', ['setting_key' => $key])->row();

        if ($exists) {
            $this->db->where('setting_key', $key);
            $this->db->update(db_prefix() . 'dpt_settings', ['setting_value' => $value]);
        } else {
            $this->db->insert(db_prefix() . 'dpt_settings', [
                'setting_key' => $key,
                'setting_value' => $value
            ]);
        }

        return true;
    }

    /**
     * CALCULATIONS
     */

    public function calculate_bmi($weight, $height)
    {
        // Weight in kg, height in cm
        if ($height <= 0 || $weight <= 0) {
            return 0;
        }

        $height_m = $height / 100;
        return round($weight / ($height_m * $height_m), 2);
    }

    public function get_bmi_category($bmi)
    {
        if ($bmi < 18.5) {
            return 'underweight';
        } elseif ($bmi < 25) {
            return 'normal';
        } elseif ($bmi < 30) {
            return 'overweight';
        } else {
            return 'obese';
        }
    }

    public function calculate_bmr($weight, $height, $age, $gender)
    {
        // Mifflin-St Jeor Equation
        if ($gender == 'male') {
            return (10 * $weight) + (6.25 * $height) - (5 * $age) + 5;
        } else {
            return (10 * $weight) + (6.25 * $height) - (5 * $age) - 161;
        }
    }

    public function calculate_tdee($bmr, $activity_level)
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

    public function calculate_waist_to_hip_ratio($waist, $hip)
    {
        if ($hip <= 0) {
            return 0;
        }

        return round($waist / $hip, 2);
    }

    /**
     * STATISTICS AND REPORTS
     */

    public function get_patient_statistics($patient_id)
    {
        $stats = [];

        // Total consultations
        $this->db->where('patient_id', $patient_id);
        $stats['total_consultations'] = $this->db->count_all_results(db_prefix() . 'dpt_consultations');

        // Active goals
        $this->db->where('patient_id', $patient_id);
        $this->db->where('status', 'active');
        $stats['active_goals'] = $this->db->count_all_results(db_prefix() . 'dpt_goals');

        // Completed goals
        $this->db->where('patient_id', $patient_id);
        $this->db->where('status', 'completed');
        $stats['completed_goals'] = $this->db->count_all_results(db_prefix() . 'dpt_goals');

        // Achievements
        $this->db->where('patient_id', $patient_id);
        $stats['total_achievements'] = $this->db->count_all_results(db_prefix() . 'dpt_achievements');

        // Weight progress
        $first_measurement = $this->db->select('weight')
            ->where('patient_id', $patient_id)
            ->order_by('measurement_date', 'ASC')
            ->limit(1)
            ->get(db_prefix() . 'dpt_measurements')
            ->row();

        $latest_measurement = $this->get_latest_measurement($patient_id);

        if ($first_measurement && $latest_measurement) {
            $stats['weight_change'] = round($latest_measurement->weight - $first_measurement->weight, 2);
        } else {
            $stats['weight_change'] = 0;
        }

        return $stats;
    }

    /**
     * PROJECT INTEGRATION
     */

    public function create_tracking_from_project($project_id)
    {
        // Implementation for automatic tracking creation from project
        $project = $this->projects_model->get($project_id);

        if ($project && $project->clientid) {
            // Check if tracking already exists
            $exists = $this->db->get_where(db_prefix() . 'dpt_patient_profiles', [
                'client_id' => $project->clientid
            ])->row();

            if (!$exists) {
                // Create patient profile
                $data = [
                    'client_id' => $project->clientid,
                    'contact_id' => $project->assigned, // Assuming contact is assigned
                    'dietician_id' => $project->addedfrom,
                    'status' => 'active'
                ];

                return $this->add_patient_profile($data);
            }
        }

        return false;
    }

    public function handle_project_deletion($project_id)
    {
        // Handle cleanup when project is deleted
        // This is optional - you may want to keep the tracking data
        $this->db->select('id');
        $this->db->where('project_id', $project_id);
        $consultations = $this->db->get(db_prefix() . 'dpt_consultations')->result();

        foreach ($consultations as $consultation) {
            $this->db->where('id', $consultation->id);
            $this->db->update(db_prefix() . 'dpt_consultations', ['project_id' => null]);
        }
    }

    /**
     * DIETITIANS MANAGEMENT
     */

    public function get_dietitian($id = null, $staff_id = null)
    {
        if ($id) {
            return $this->db->get_where(db_prefix() . 'dpt_dietitians', ['id' => $id])->row();
        } elseif ($staff_id) {
            return $this->db->get_where(db_prefix() . 'dpt_dietitians', ['staff_id' => $staff_id])->row();
        }
        return false;
    }

    public function get_all_dietitians($filters = [])
    {
        $this->db->select('d.*, s.firstname, s.lastname, s.email');
        $this->db->from(db_prefix() . 'dpt_dietitians d');
        $this->db->join(db_prefix() . 'staff s', 's.staffid = d.staff_id');

        if (isset($filters['status'])) {
            $this->db->where('d.status', $filters['status']);
        }

        return $this->db->get()->result();
    }

    public function add_dietitian($data)
    {
        $this->db->insert(db_prefix() . 'dpt_dietitians', $data);
        return $this->db->insert_id();
    }

    public function update_dietitian($id, $data)
    {
        $this->db->where('id', $id);
        $this->db->update(db_prefix() . 'dpt_dietitians', $data);
        return $this->db->affected_rows() > 0;
    }

    /**
     * ANAMNESIS MANAGEMENT
     */

    public function get_anamnesis($id)
    {
        return $this->db->get_where(db_prefix() . 'dpt_anamnesis', ['id' => $id])->row();
    }

    public function get_patient_anamnesis($patient_id)
    {
        $this->db->where('patient_id', $patient_id);
        $this->db->order_by('created_at', 'DESC');
        return $this->db->get(db_prefix() . 'dpt_anamnesis')->result();
    }

    public function get_latest_anamnesis($patient_id)
    {
        $this->db->where('patient_id', $patient_id);
        $this->db->order_by('created_at', 'DESC');
        $this->db->limit(1);
        return $this->db->get(db_prefix() . 'dpt_anamnesis')->row();
    }

    public function add_anamnesis($data)
    {
        $this->db->insert(db_prefix() . 'dpt_anamnesis', $data);
        $insert_id = $this->db->insert_id();

        if ($insert_id) {
            $this->log_audit('create', 'anamnesis', $insert_id, $data['patient_id']);
            log_activity('New Anamnesis Created [Patient ID: ' . $data['patient_id'] . ']');
        }

        return $insert_id;
    }

    public function update_anamnesis($id, $data)
    {
        $old = $this->get_anamnesis($id);
        $this->db->where('id', $id);
        $this->db->update(db_prefix() . 'dpt_anamnesis', $data);

        if ($this->db->affected_rows() > 0 && $old) {
            $this->log_audit('update', 'anamnesis', $id, $old->patient_id, $old, $data);
        }

        return $this->db->affected_rows() > 0;
    }

    /**
     * PROGRAMS MANAGEMENT
     */

    public function get_program($id)
    {
        return $this->db->get_where(db_prefix() . 'dpt_programs', ['id' => $id])->row();
    }

    public function get_programs($patient_id = null, $filters = [])
    {
        $this->db->select('p.*, pat.contact_id, c.firstname, c.lastname');
        $this->db->from(db_prefix() . 'dpt_programs p');
        $this->db->join(db_prefix() . 'dpt_patient_profiles pat', 'pat.id = p.patient_id');
        $this->db->join(db_prefix() . 'contacts c', 'c.id = pat.contact_id');

        if ($patient_id) {
            $this->db->where('p.patient_id', $patient_id);
        }

        if (isset($filters['status'])) {
            $this->db->where('p.status', $filters['status']);
        }

        $this->db->order_by('p.start_date', 'DESC');
        return $this->db->get()->result();
    }

    public function add_program($data)
    {
        $this->db->insert(db_prefix() . 'dpt_programs', $data);
        $insert_id = $this->db->insert_id();

        if ($insert_id) {
            log_activity('New Program Created [ID: ' . $insert_id . ']');
        }

        return $insert_id;
    }

    public function update_program($id, $data)
    {
        $this->db->where('id', $id);
        $this->db->update(db_prefix() . 'dpt_programs', $data);
        return $this->db->affected_rows() > 0;
    }

    public function delete_program($id)
    {
        // Delete milestones first
        $this->db->where('program_id', $id);
        $this->db->delete(db_prefix() . 'dpt_program_milestones');

        // Delete program
        $this->db->where('id', $id);
        $this->db->delete(db_prefix() . 'dpt_programs');

        return $this->db->affected_rows() > 0;
    }

    public function add_program_milestone($data)
    {
        $this->db->insert(db_prefix() . 'dpt_program_milestones', $data);
        return $this->db->insert_id();
    }

    public function get_program_milestones($program_id)
    {
        $this->db->where('program_id', $program_id);
        $this->db->order_by('target_date', 'ASC');
        return $this->db->get(db_prefix() . 'dpt_program_milestones')->result();
    }

    public function update_program_milestone($id, $data)
    {
        $this->db->where('id', $id);
        $this->db->update(db_prefix() . 'dpt_program_milestones', $data);
        return $this->db->affected_rows() > 0;
    }

    /**
     * REMINDERS MANAGEMENT
     */

    public function get_reminder($id)
    {
        return $this->db->get_where(db_prefix() . 'dpt_reminders', ['id' => $id])->row();
    }

    public function get_reminders($patient_id = null, $filters = [])
    {
        if ($patient_id) {
            $this->db->where('patient_id', $patient_id);
        }

        if (isset($filters['status'])) {
            $this->db->where('status', $filters['status']);
        }

        if (isset($filters['type'])) {
            $this->db->where('reminder_type', $filters['type']);
        }

        $this->db->order_by('next_trigger_date', 'ASC');
        return $this->db->get(db_prefix() . 'dpt_reminders')->result();
    }

    public function get_due_reminders()
    {
        $this->db->where('status', 'active');
        $this->db->where('next_trigger_date <=', date('Y-m-d H:i:s'));
        return $this->db->get(db_prefix() . 'dpt_reminders')->result();
    }

    public function add_reminder($data)
    {
        $this->db->insert(db_prefix() . 'dpt_reminders', $data);
        return $this->db->insert_id();
    }

    public function update_reminder($id, $data)
    {
        $this->db->where('id', $id);
        $this->db->update(db_prefix() . 'dpt_reminders', $data);
        return $this->db->affected_rows() > 0;
    }

    public function delete_reminder($id)
    {
        $this->db->where('id', $id);
        $this->db->delete(db_prefix() . 'dpt_reminders');
        return $this->db->affected_rows() > 0;
    }

    public function log_reminder_sent($reminder_id, $sent_via, $status = 'sent', $error = null)
    {
        $data = [
            'reminder_id' => $reminder_id,
            'sent_via' => $sent_via,
            'status' => $status,
            'error_message' => $error
        ];

        $this->db->insert(db_prefix() . 'dpt_reminder_logs', $data);
        return $this->db->insert_id();
    }

    /**
     * SMS MANAGEMENT
     */

    public function send_sms($phone_number, $message, $patient_id = null, $type = 'notification')
    {
        $enabled = $this->get_setting('dpt_sms_enabled');
        if (!$enabled || $enabled == '0') {
            return false;
        }

        $api_key = $this->get_setting('dpt_sms_lam_api_key');
        $sender_id = $this->get_setting('dpt_sms_lam_sender_id');
        $api_url = $this->get_setting('dpt_sms_lam_api_url');

        if (empty($api_key) || empty($sender_id)) {
            log_activity('SMS API not configured');
            return false;
        }

        // Log SMS attempt
        $log_data = [
            'patient_id' => $patient_id,
            'phone_number' => $phone_number,
            'message' => $message,
            'message_type' => $type,
            'sender_id' => $sender_id,
            'status' => 'pending'
        ];

        $this->db->insert(db_prefix() . 'dpt_sms_logs', $log_data);
        $log_id = $this->db->insert_id();

        // Send via LAM API
        $curl = curl_init();
        curl_setopt_array($curl, [
            CURLOPT_URL => $api_url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => json_encode([
                'api_key' => $api_key,
                'sender_id' => $sender_id,
                'phone' => $phone_number,
                'message' => $message
            ]),
            CURLOPT_HTTPHEADER => [
                'Content-Type: application/json',
                'Accept: application/json'
            ]
        ]);

        $response = curl_exec($curl);
        $http_code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        $error = curl_error($curl);
        curl_close($curl);

        // Update log
        $update_data = [
            'api_response' => $response,
            'sent_at' => date('Y-m-d H:i:s')
        ];

        if ($http_code == 200 || $http_code == 201) {
            $update_data['status'] = 'sent';
            $result = true;
        } else {
            $update_data['status'] = 'failed';
            $result = false;
        }

        $this->db->where('id', $log_id);
        $this->db->update(db_prefix() . 'dpt_sms_logs', $update_data);

        return $result;
    }

    public function get_sms_logs($patient_id = null, $limit = 50)
    {
        if ($patient_id) {
            $this->db->where('patient_id', $patient_id);
        }

        $this->db->order_by('created_at', 'DESC');
        $this->db->limit($limit);
        return $this->db->get(db_prefix() . 'dpt_sms_logs')->result();
    }

    /**
     * GDPR CONSENT MANAGEMENT
     */

    public function add_consent($data)
    {
        $this->db->insert(db_prefix() . 'dpt_gdpr_consents', $data);
        return $this->db->insert_id();
    }

    public function get_patient_consents($patient_id)
    {
        $this->db->where('patient_id', $patient_id);
        $this->db->order_by('created_at', 'DESC');
        return $this->db->get(db_prefix() . 'dpt_gdpr_consents')->result();
    }

    public function get_active_consent($patient_id, $consent_type)
    {
        $this->db->where('patient_id', $patient_id);
        $this->db->where('consent_type', $consent_type);
        $this->db->where('consent_given', 1);
        $this->db->where('withdrawn_at IS NULL');
        $this->db->order_by('consented_at', 'DESC');
        $this->db->limit(1);
        return $this->db->get(db_prefix() . 'dpt_gdpr_consents')->row();
    }

    public function withdraw_consent($patient_id, $consent_type)
    {
        $this->db->where('patient_id', $patient_id);
        $this->db->where('consent_type', $consent_type);
        $this->db->where('consent_given', 1);
        $this->db->where('withdrawn_at IS NULL');
        $this->db->update(db_prefix() . 'dpt_gdpr_consents', [
            'withdrawn_at' => date('Y-m-d H:i:s')
        ]);

        return $this->db->affected_rows() > 0;
    }

    /**
     * AUDIT LOG
     */

    public function log_audit($action, $entity_type, $entity_id, $patient_id = null, $old_values = null, $new_values = null)
    {
        $enabled = $this->get_setting('dpt_enable_audit_log');
        if (!$enabled || $enabled == '0') {
            return false;
        }

        $user_id = is_staff_logged_in() ? get_staff_user_id() : (is_client_logged_in() ? get_contact_user_id() : 0);
        $user_type = is_staff_logged_in() ? 'staff' : 'client';

        $data = [
            'patient_id' => $patient_id,
            'user_id' => $user_id,
            'user_type' => $user_type,
            'action' => $action,
            'entity_type' => $entity_type,
            'entity_id' => $entity_id,
            'old_values' => $old_values ? json_encode($old_values) : null,
            'new_values' => $new_values ? json_encode($new_values) : null,
            'ip_address' => $this->input->ip_address(),
            'user_agent' => $this->input->user_agent()
        ];

        $this->db->insert(db_prefix() . 'dpt_audit_log', $data);
        return $this->db->insert_id();
    }

    public function get_audit_logs($filters = [], $limit = 100)
    {
        if (isset($filters['patient_id'])) {
            $this->db->where('patient_id', $filters['patient_id']);
        }

        if (isset($filters['entity_type'])) {
            $this->db->where('entity_type', $filters['entity_type']);
        }

        if (isset($filters['from_date'])) {
            $this->db->where('created_at >=', $filters['from_date']);
        }

        if (isset($filters['to_date'])) {
            $this->db->where('created_at <=', $filters['to_date']);
        }

        $this->db->order_by('created_at', 'DESC');
        $this->db->limit($limit);
        return $this->db->get(db_prefix() . 'dpt_audit_log')->result();
    }

    /**
     * SATISFACTION SURVEYS
     */

    public function get_satisfaction_survey($id)
    {
        return $this->db->get_where(db_prefix() . 'dpt_satisfaction_surveys', ['id' => $id])->row();
    }

    public function get_survey_by_consultation($consultation_id)
    {
        return $this->db->get_where(db_prefix() . 'dpt_satisfaction_surveys', ['consultation_id' => $consultation_id])->row();
    }

    public function add_satisfaction_survey($data)
    {
        $this->db->insert(db_prefix() . 'dpt_satisfaction_surveys', $data);
        return $this->db->insert_id();
    }

    public function update_satisfaction_survey($id, $data)
    {
        $this->db->where('id', $id);
        $this->db->update(db_prefix() . 'dpt_satisfaction_surveys', $data);
        return $this->db->affected_rows() > 0;
    }

    public function get_dietician_nps_score($dietician_id, $from_date = null)
    {
        $this->db->select('AVG(nps_score) as avg_nps');
        $this->db->where('dietician_id', $dietician_id);
        $this->db->where('nps_score IS NOT NULL');

        if ($from_date) {
            $this->db->where('completed_at >=', $from_date);
        }

        $result = $this->db->get(db_prefix() . 'dpt_satisfaction_surveys')->row();
        return $result ? round($result->avg_nps, 1) : null;
    }

    public function get_pending_surveys()
    {
        $this->db->where('completed_at IS NULL');
        $this->db->where('survey_sent_at IS NOT NULL');
        $this->db->where('reminder_sent_count <', 3); // Max 3 reminders
        return $this->db->get(db_prefix() . 'dpt_satisfaction_surveys')->result();
    }
}
