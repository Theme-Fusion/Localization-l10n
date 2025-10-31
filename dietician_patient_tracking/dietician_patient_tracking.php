<?php

defined('BASEPATH') or exit('No direct script access allowed');

/*
Module Name: Dietician Patient Tracking
Description: Module complet de suivi diététicien-patient avec calculs biométriques, plans alimentaires et suivi évolutif
Version: 1.0.0
Requires at least: 2.3.*
Author: Perfex CRM
Author URI: https://www.perfexcrm.com
*/

define('DIETICIAN_PATIENT_TRACKING_MODULE_NAME', 'dietician_patient_tracking');
define('DIETICIAN_PATIENT_TRACKING_VERSION', '1.0.0');

// Register activation hook
hooks()->add_action('admin_init', 'dietician_patient_tracking_module_init_menu_items');
hooks()->add_action('admin_init', 'dietician_patient_tracking_permissions');
hooks()->add_action('app_admin_head', 'dietician_patient_tracking_add_head_components');
hooks()->add_action('app_admin_footer', 'dietician_patient_tracking_load_js');

// Client area hooks
hooks()->add_action('clients_init', 'dietician_patient_tracking_clients_area_menu');
hooks()->add_action('app_customers_head', 'dietician_patient_tracking_client_head_components');
hooks()->add_action('app_customers_footer', 'dietician_patient_tracking_client_footer_js');

// Project integration hooks
hooks()->add_action('after_project_added', 'dietician_patient_tracking_project_created');
hooks()->add_action('before_project_deleted', 'dietician_patient_tracking_project_deleted');

/**
 * Register activation module hook
 */
register_activation_hook(DIETICIAN_PATIENT_TRACKING_MODULE_NAME, 'dietician_patient_tracking_module_activation_hook');

function dietician_patient_tracking_module_activation_hook()
{
    $CI = &get_instance();
    require_once(__DIR__ . '/install.php');
}

/**
 * Register language files
 */
register_language_files(DIETICIAN_PATIENT_TRACKING_MODULE_NAME, [DIETICIAN_PATIENT_TRACKING_MODULE_NAME]);

/**
 * Initialize menu items
 */
function dietician_patient_tracking_module_init_menu_items()
{
    $CI = &get_instance();

    if (has_permission('dietician_patient_tracking', '', 'view')) {
        $CI->app_menu->add_sidebar_menu_item('dietician-patient-tracking', [
            'name'     => _l('dietician_patient_tracking'),
            'icon'     => 'fa fa-heartbeat',
            'position' => 10,
        ]);

        $CI->app_menu->add_sidebar_children_item('dietician-patient-tracking', [
            'slug'     => 'dietician-patients',
            'name'     => _l('dpt_patients'),
            'icon'     => 'fa fa-users',
            'href'     => admin_url('dietician_patient_tracking/patients'),
            'position' => 1,
        ]);

        $CI->app_menu->add_sidebar_children_item('dietician-patient-tracking', [
            'slug'     => 'dietician-consultations',
            'name'     => _l('dpt_consultations'),
            'icon'     => 'fa fa-calendar-check-o',
            'href'     => admin_url('dietician_patient_tracking/consultations'),
            'position' => 2,
        ]);

        $CI->app_menu->add_sidebar_children_item('dietician-patient-tracking', [
            'slug'     => 'dietician-meal-plans',
            'name'     => _l('dpt_meal_plans'),
            'icon'     => 'fa fa-cutlery',
            'href'     => admin_url('dietician_patient_tracking/meal_plans'),
            'position' => 3,
        ]);

        $CI->app_menu->add_sidebar_children_item('dietician-patient-tracking', [
            'slug'     => 'dietician-food-library',
            'name'     => _l('dpt_food_library'),
            'icon'     => 'fa fa-book',
            'href'     => admin_url('dietician_patient_tracking/food_library'),
            'position' => 4,
        ]);

        $CI->app_menu->add_sidebar_children_item('dietician-patient-tracking', [
            'slug'     => 'dietician-reports',
            'name'     => _l('dpt_reports'),
            'icon'     => 'fa fa-bar-chart',
            'href'     => admin_url('dietician_patient_tracking/reports'),
            'position' => 5,
        ]);

        $CI->app_menu->add_sidebar_children_item('dietician-patient-tracking', [
            'slug'     => 'dietician-settings',
            'name'     => _l('settings'),
            'icon'     => 'fa fa-cog',
            'href'     => admin_url('dietician_patient_tracking/settings'),
            'position' => 6,
        ]);
    }
}

/**
 * Initialize client area menu
 */
function dietician_patient_tracking_clients_area_menu()
{
    if (is_client_logged_in()) {
        add_theme_menu_item('dietician-tracking', [
            'name'     => _l('dpt_my_tracking'),
            'href'     => site_url('dietician_patient_tracking/client/dashboard'),
            'position' => 15,
            'icon'     => 'fa fa-heartbeat',
        ]);
    }
}

/**
 * Register module permissions
 */
function dietician_patient_tracking_permissions()
{
    $capabilities = [];

    $capabilities['capabilities'] = [
        'view'   => _l('permission_view') . ' (' . _l('permission_global') . ')',
        'create' => _l('permission_create'),
        'edit'   => _l('permission_edit'),
        'delete' => _l('permission_delete'),
    ];

    register_staff_capabilities('dietician_patient_tracking', $capabilities, _l('dietician_patient_tracking'));
}

/**
 * Add CSS and JS in admin head
 */
function dietician_patient_tracking_add_head_components()
{
    $CI = &get_instance();
    $viewuri = $_SERVER['REQUEST_URI'];

    if (!(strpos($viewuri, 'dietician_patient_tracking') === false)) {
        echo '<link href="' . module_dir_url(DIETICIAN_PATIENT_TRACKING_MODULE_NAME, 'assets/css/dietician_patient_tracking.css') . '?v=' . DIETICIAN_PATIENT_TRACKING_VERSION . '"  rel="stylesheet" type="text/css" />';
        echo '<link href="' . module_dir_url(DIETICIAN_PATIENT_TRACKING_MODULE_NAME, 'assets/css/chart.css') . '?v=' . DIETICIAN_PATIENT_TRACKING_VERSION . '"  rel="stylesheet" type="text/css" />';
    }
}

/**
 * Load JS scripts in admin footer
 */
function dietician_patient_tracking_load_js()
{
    $CI = &get_instance();
    $viewuri = $_SERVER['REQUEST_URI'];

    if (!(strpos($viewuri, 'dietician_patient_tracking') === false)) {
        echo '<script src="' . module_dir_url(DIETICIAN_PATIENT_TRACKING_MODULE_NAME, 'assets/js/dietician_patient_tracking.js') . '?v=' . DIETICIAN_PATIENT_TRACKING_VERSION . '"></script>';
        echo '<script src="' . module_dir_url(DIETICIAN_PATIENT_TRACKING_MODULE_NAME, 'assets/js/calculations.js') . '?v=' . DIETICIAN_PATIENT_TRACKING_VERSION . '"></script>';
    }
}

/**
 * Add CSS in client area head
 */
function dietician_patient_tracking_client_head_components()
{
    echo '<link href="' . module_dir_url(DIETICIAN_PATIENT_TRACKING_MODULE_NAME, 'assets/css/client_tracking.css') . '?v=' . DIETICIAN_PATIENT_TRACKING_VERSION . '"  rel="stylesheet" type="text/css" />';
}

/**
 * Load JS in client area footer
 */
function dietician_patient_tracking_client_footer_js()
{
    echo '<script src="' . module_dir_url(DIETICIAN_PATIENT_TRACKING_MODULE_NAME, 'assets/js/client_tracking.js') . '?v=' . DIETICIAN_PATIENT_TRACKING_VERSION . '"></script>';
}

/**
 * Hook when project is created
 */
function dietician_patient_tracking_project_created($project_id)
{
    $CI = &get_instance();
    $CI->load->model('dietician_patient_tracking/dietician_patient_tracking_model');

    // Auto-create tracking if project has specific tags or custom fields
    $project = $CI->projects_model->get($project_id);
    if ($project && isset($project->rel_type) && $project->rel_type == 'dietician_tracking') {
        $CI->dietician_patient_tracking_model->create_tracking_from_project($project_id);
    }
}

/**
 * Hook before project is deleted
 */
function dietician_patient_tracking_project_deleted($project_id)
{
    $CI = &get_instance();
    $CI->load->model('dietician_patient_tracking/dietician_patient_tracking_model');
    $CI->dietician_patient_tracking_model->handle_project_deletion($project_id);
}
