<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Dietician_patient_tracking extends AdminController
{
    public function __construct()
    {
        parent::__construct();

        if (!has_permission('dietician_patient_tracking', '', 'view')) {
            access_denied('dietician_patient_tracking');
        }

        $this->load->model('dietician_patient_tracking/dietician_patient_tracking_model');
        $this->load->helper('dietician_patient_tracking/dietician_patient_tracking');
    }

    /**
     * Dashboard/Index
     */
    public function index()
    {
        $data['title'] = _l('dietician_patient_tracking');

        // Statistics
        $data['total_patients'] = count($this->dietician_patient_tracking_model->get_all_patients(['status' => 'active']));
        $data['total_consultations'] = count($this->dietician_patient_tracking_model->get_consultations());
        $data['upcoming_consultations'] = count($this->dietician_patient_tracking_model->get_consultations(null, [
            'status' => 'scheduled',
            'from_date' => date('Y-m-d'),
            'to_date' => date('Y-m-d', strtotime('+7 days'))
        ]));

        // Recent patients
        $data['recent_patients'] = array_slice($this->dietician_patient_tracking_model->get_all_patients(['status' => 'active']), 0, 10);

        // Upcoming consultations
        $data['consultations'] = $this->dietician_patient_tracking_model->get_consultations(null, [
            'status' => 'scheduled',
            'from_date' => date('Y-m-d'),
            'to_date' => date('Y-m-d', strtotime('+30 days'))
        ]);

        $this->load->view('admin/dashboard', $data);
    }

    /**
     * PATIENTS MANAGEMENT
     */

    public function patients()
    {
        if ($this->input->is_ajax_request()) {
            $this->app->get_table_data(module_views_path('dietician_patient_tracking', 'admin/tables/patients'));
        }

        $data['title'] = _l('dpt_patients');
        $data['staff_members'] = $this->staff_model->get('', ['active' => 1]);

        $this->load->view('admin/patients/manage', $data);
    }

    public function patient($id = null)
    {
        if ($this->input->post()) {
            $data = $this->input->post();

            if ($id) {
                $success = $this->dietician_patient_tracking_model->update_patient_profile($id, $data);
                if ($success) {
                    set_alert('success', _l('updated_successfully', _l('dpt_patient')));
                } else {
                    set_alert('danger', _l('updated_fail', _l('dpt_patient')));
                }
                redirect(admin_url('dietician_patient_tracking/patient/' . $id));
            } else {
                $id = $this->dietician_patient_tracking_model->add_patient_profile($data);
                if ($id) {
                    set_alert('success', _l('added_successfully', _l('dpt_patient')));
                    redirect(admin_url('dietician_patient_tracking/patient/' . $id));
                } else {
                    set_alert('danger', _l('added_fail', _l('dpt_patient')));
                    redirect(admin_url('dietician_patient_tracking/patients'));
                }
            }
        }

        if ($id) {
            $data['patient'] = $this->dietician_patient_tracking_model->get_patient_profile($id);

            if (!$data['patient']) {
                show_404();
            }

            // Get measurements
            $measurements = $this->dietician_patient_tracking_model->get_measurements($id);
            $data['measurements'] = $measurements;
            $data['latest_measurement'] = !empty($measurements) ? $measurements[0] : null;

            // Get consultations
            $data['consultations'] = $this->dietician_patient_tracking_model->get_consultations($id);

            // Get meal plans
            $data['meal_plans'] = $this->dietician_patient_tracking_model->get_meal_plans($id);

            // Get goals
            $data['goals'] = $this->dietician_patient_tracking_model->get_goals($id);

            // Get achievements
            $data['achievements'] = $this->dietician_patient_tracking_model->get_achievements($id);

            // Statistics
            $data['statistics'] = $this->dietician_patient_tracking_model->get_patient_statistics($id);

            // Calculate biometric data if we have measurements
            if ($data['latest_measurement']) {
                $patient = $data['patient'];
                $measurement = $data['latest_measurement'];

                $age = dpt_calculate_age($patient->date_of_birth);

                $data['bmi'] = dpt_calculate_bmi($measurement->weight, $patient->height);
                $data['bmi_category'] = dpt_get_bmi_category($data['bmi']);

                if ($age > 0) {
                    $data['bmr'] = dpt_calculate_bmr($measurement->weight, $patient->height, $age, $patient->gender);
                    $data['tdee'] = dpt_calculate_tdee($data['bmr'], $patient->activity_level);
                    $data['recommended_water'] = dpt_calculate_water_intake($measurement->weight, $patient->activity_level);
                }

                if ($measurement->waist_circumference && $measurement->hip_circumference) {
                    $data['whr'] = dpt_calculate_waist_to_hip_ratio(
                        $measurement->waist_circumference,
                        $measurement->hip_circumference
                    );
                    $data['whr_risk'] = dpt_get_whr_risk($data['whr'], $patient->gender);
                }

                // Weight chart data
                $data['weight_chart_data'] = dpt_generate_weight_chart_data(array_reverse($measurements));
            }

            // Ideal weight range
            if ($data['patient']->height) {
                $data['ideal_weight_range'] = dpt_calculate_ideal_weight_range($data['patient']->height);
            }

            $data['title'] = $data['patient']->firstname . ' ' . $data['patient']->lastname;
        }

        $data['contacts'] = $this->clients_model->get_contacts();
        $data['staff_members'] = $this->staff_model->get('', ['active' => 1]);
        $data['activity_levels'] = dpt_get_activity_levels();
        $data['goal_types'] = dpt_get_goal_types();

        $this->load->view('admin/patients/profile', $data);
    }

    public function delete_patient($id)
    {
        if (!has_permission('dietician_patient_tracking', '', 'delete')) {
            access_denied('dietician_patient_tracking');
        }

        $success = $this->dietician_patient_tracking_model->delete_patient_profile($id);
        $message = $success ? _l('deleted', _l('dpt_patient')) : _l('problem_deleting', _l('dpt_patient'));

        echo json_encode(['success' => $success, 'message' => $message]);
    }

    /**
     * MEASUREMENTS
     */

    public function add_measurement($patient_id)
    {
        if ($this->input->post()) {
            $data = $this->input->post();
            $data['patient_id'] = $patient_id;
            $data['created_by'] = get_staff_user_id();

            $id = $this->dietician_patient_tracking_model->add_measurement($data);
            $success = $id ? true : false;

            // Check for achievements
            if ($success) {
                dpt_check_achievement($patient_id, 'first_measurement');

                // Check weight loss achievements
                $measurements = $this->dietician_patient_tracking_model->get_measurements($patient_id);
                if (count($measurements) >= 2) {
                    $latest = $measurements[0];
                    $first = end($measurements);
                    $weight_loss = $first->weight - $latest->weight;

                    if ($weight_loss >= 5) {
                        dpt_check_achievement($patient_id, 'weight_loss_5kg');
                    }
                    if ($weight_loss >= 10) {
                        dpt_check_achievement($patient_id, 'weight_loss_10kg');
                    }
                }
            }

            if ($success) {
                set_alert('success', _l('added_successfully', _l('dpt_measurement')));
            } else {
                set_alert('danger', _l('added_fail', _l('dpt_measurement')));
            }
            redirect(admin_url('dietician_patient_tracking/patient/' . $patient_id));
        }
    }

    public function delete_measurement($id)
    {
        $success = $this->dietician_patient_tracking_model->delete_measurement($id);
        echo json_encode([
            'success' => $success,
            'message' => $success ? _l('deleted', _l('dpt_measurement')) : _l('problem_deleting', _l('dpt_measurement'))
        ]);
    }

    /**
     * CONSULTATIONS
     */

    public function consultations()
    {
        if ($this->input->is_ajax_request()) {
            $this->app->get_table_data(module_views_path('dietician_patient_tracking', 'admin/tables/consultations'));
        }

        $data['title'] = _l('dpt_consultations');
        $data['patients'] = $this->dietician_patient_tracking_model->get_all_patients(['status' => 'active']);
        $data['consultation_types'] = dpt_get_consultation_types();

        $this->load->view('admin/consultations/manage', $data);
    }

    public function consultation($id = null)
    {
        if ($this->input->post()) {
            $data = $this->input->post();

            if (!$id) {
                $data['dietician_id'] = get_staff_user_id();
            }

            if ($id) {
                $success = $this->dietician_patient_tracking_model->update_consultation($id, $data);
                if ($success) {
                    set_alert('success', _l('updated_successfully', _l('dpt_consultation')));
                } else {
                    set_alert('danger', _l('updated_fail', _l('dpt_consultation')));
                }
                redirect(admin_url('dietician_patient_tracking/consultations'));
            } else {
                $id = $this->dietician_patient_tracking_model->add_consultation($data);
                if ($id) {
                    set_alert('success', _l('added_successfully', _l('dpt_consultation')));
                } else {
                    set_alert('danger', _l('added_fail', _l('dpt_consultation')));
                }
                redirect(admin_url('dietician_patient_tracking/consultations'));
            }
        }

        if ($id) {
            $data['consultation'] = $this->dietician_patient_tracking_model->get_consultation($id);

            if (!$data['consultation']) {
                show_404();
            }

            $data['title'] = _l('dpt_consultation') . ' #' . $id;
        }

        $data['patients'] = $this->dietician_patient_tracking_model->get_all_patients(['status' => 'active']);
        $data['consultation_types'] = dpt_get_consultation_types();
        $data['projects'] = $this->projects_model->get();

        $this->load->view('admin/consultations/consultation', $data);
    }

    public function delete_consultation($id)
    {
        if (!has_permission('dietician_patient_tracking', '', 'delete')) {
            access_denied('dietician_patient_tracking');
        }

        $success = $this->dietician_patient_tracking_model->delete_consultation($id);
        echo json_encode([
            'success' => $success,
            'message' => $success ? _l('deleted', _l('dpt_consultation')) : _l('problem_deleting', _l('dpt_consultation'))
        ]);
    }

    /**
     * MEAL PLANS
     */

    public function meal_plans()
    {
        if ($this->input->is_ajax_request()) {
            $this->app->get_table_data(module_views_path('dietician_patient_tracking', 'admin/tables/meal_plans'));
        }

        $data['title'] = _l('dpt_meal_plans');
        $data['patients'] = $this->dietician_patient_tracking_model->get_all_patients(['status' => 'active']);

        $this->load->view('admin/meal_plans/manage', $data);
    }

    public function meal_plan($id = null)
    {
        if ($this->input->post()) {
            $data = $this->input->post();

            if (!$id) {
                $data['dietician_id'] = get_staff_user_id();
            }

            if ($id) {
                $success = $this->dietician_patient_tracking_model->update_meal_plan($id, $data);
                if ($success) {
                    set_alert('success', _l('updated_successfully', _l('dpt_meal_plan')));
                } else {
                    set_alert('danger', _l('updated_fail', _l('dpt_meal_plan')));
                }
                redirect(admin_url('dietician_patient_tracking/meal_plans'));
            } else {
                $id = $this->dietician_patient_tracking_model->add_meal_plan($data);
                if ($id) {
                    set_alert('success', _l('added_successfully', _l('dpt_meal_plan')));
                } else {
                    set_alert('danger', _l('added_fail', _l('dpt_meal_plan')));
                }
                redirect(admin_url('dietician_patient_tracking/meal_plans'));
            }
        }

        if ($id) {
            $data['meal_plan'] = $this->dietician_patient_tracking_model->get_meal_plan($id);

            if (!$data['meal_plan']) {
                show_404();
            }

            $data['meal_plan_items'] = $this->dietician_patient_tracking_model->get_meal_plan_items($id);
            $data['title'] = $data['meal_plan']->name;
        }

        $data['patients'] = $this->dietician_patient_tracking_model->get_all_patients(['status' => 'active']);
        $data['food_items'] = $this->dietician_patient_tracking_model->get_food_items();
        $data['meal_types'] = dpt_get_meal_types();

        $this->load->view('admin/meal_plans/meal_plan', $data);
    }

    public function add_meal_plan_item($meal_plan_id)
    {
        if ($this->input->post()) {
            $data = $this->input->post();
            $data['meal_plan_id'] = $meal_plan_id;

            $id = $this->dietician_patient_tracking_model->add_meal_plan_item($data);
            $success = $id ? true : false;

            echo json_encode([
                'success' => $success,
                'message' => $success ? _l('added_successfully', _l('dpt_meal_item')) : _l('added_fail', _l('dpt_meal_item'))
            ]);
        }
    }

    public function delete_meal_plan($id)
    {
        $success = $this->dietician_patient_tracking_model->delete_meal_plan($id);
        echo json_encode([
            'success' => $success,
            'message' => $success ? _l('deleted', _l('dpt_meal_plan')) : _l('problem_deleting', _l('dpt_meal_plan'))
        ]);
    }

    /**
     * FOOD LIBRARY
     */

    public function food_library()
    {
        if ($this->input->is_ajax_request()) {
            $this->app->get_table_data(module_views_path('dietician_patient_tracking', 'admin/tables/food_library'));
        }

        $data['title'] = _l('dpt_food_library');
        $data['categories'] = $this->dietician_patient_tracking_model->get_food_categories();

        $this->load->view('admin/food_library/manage', $data);
    }

    public function food_item($id = null)
    {
        if ($this->input->post()) {
            $data = $this->input->post();

            if (!$id) {
                $data['created_by'] = get_staff_user_id();
                $data['is_custom'] = 1;
            }

            if ($id) {
                $success = $this->dietician_patient_tracking_model->update_food_item($id, $data);
                if ($success) {
                    set_alert('success', _l('updated_successfully', _l('dpt_food_item')));
                } else {
                    set_alert('danger', _l('updated_fail', _l('dpt_food_item')));
                }
                redirect(admin_url('dietician_patient_tracking/food_library'));
            } else {
                $id = $this->dietician_patient_tracking_model->add_food_item($data);
                if ($id) {
                    set_alert('success', _l('added_successfully', _l('dpt_food_item')));
                } else {
                    set_alert('danger', _l('added_fail', _l('dpt_food_item')));
                }
                redirect(admin_url('dietician_patient_tracking/food_library'));
            }
        }

        if ($id) {
            $data['food_item'] = $this->dietician_patient_tracking_model->get_food_item($id);

            if (!$data['food_item']) {
                show_404();
            }

            $data['title'] = $data['food_item']->name;
        }

        $data['categories'] = $this->dietician_patient_tracking_model->get_food_categories();

        $this->load->view('admin/food_library/food_item', $data);
    }

    public function delete_food_item($id)
    {
        $success = $this->dietician_patient_tracking_model->delete_food_item($id);
        echo json_encode([
            'success' => $success,
            'message' => $success ? _l('deleted', _l('dpt_food_item')) : _l('problem_deleting', _l('dpt_food_item'))
        ]);
    }

    /**
     * REPORTS
     */

    public function reports()
    {
        $data['title'] = _l('dpt_reports');
        $data['patients'] = $this->dietician_patient_tracking_model->get_all_patients();

        if ($this->input->get('patient_id')) {
            $patient_id = $this->input->get('patient_id');
            $data['selected_patient'] = $this->dietician_patient_tracking_model->get_patient_profile($patient_id);
            $data['statistics'] = $this->dietician_patient_tracking_model->get_patient_statistics($patient_id);
            $data['measurements'] = $this->dietician_patient_tracking_model->get_measurements($patient_id);
            $data['consultations'] = $this->dietician_patient_tracking_model->get_consultations($patient_id);
            $data['goals'] = $this->dietician_patient_tracking_model->get_goals($patient_id);
        }

        $this->load->view('admin/reports/dashboard', $data);
    }

    /**
     * SETTINGS
     */

    public function settings()
    {
        if ($this->input->post()) {
            $settings = $this->input->post();

            foreach ($settings as $key => $value) {
                $this->dietician_patient_tracking_model->update_setting($key, $value);
            }

            set_alert('success', _l('settings_updated'));
            redirect(admin_url('dietician_patient_tracking/settings'));
        }

        $data['title'] = _l('settings');
        $data['settings'] = [
            'dpt_enable_gamification' => $this->dietician_patient_tracking_model->get_setting('dpt_enable_gamification'),
            'dpt_enable_messaging' => $this->dietician_patient_tracking_model->get_setting('dpt_enable_messaging'),
            'dpt_enable_food_diary' => $this->dietician_patient_tracking_model->get_setting('dpt_enable_food_diary'),
            'dpt_default_activity_level' => $this->dietician_patient_tracking_model->get_setting('dpt_default_activity_level'),
            'dpt_measurement_system' => $this->dietician_patient_tracking_model->get_setting('dpt_measurement_system'),
            'dpt_notification_email' => $this->dietician_patient_tracking_model->get_setting('dpt_notification_email'),
            'dpt_consultation_reminder_days' => $this->dietician_patient_tracking_model->get_setting('dpt_consultation_reminder_days'),
        ];

        $this->load->view('admin/settings/settings', $data);
    }
}
