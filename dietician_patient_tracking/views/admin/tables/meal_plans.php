<?php

defined('BASEPATH') or exit('No direct script access allowed');

$aColumns = [
    'id',
    'name',
    'firstname',
    'start_date',
    'status'
];

$sIndexColumn = 'id';
$sTable       = db_prefix() . 'dpt_meal_plans';

$join = [
    'LEFT JOIN ' . db_prefix() . 'dpt_patient_profiles ON ' . db_prefix() . 'dpt_patient_profiles.id = ' . db_prefix() . 'dpt_meal_plans.patient_id',
    'LEFT JOIN ' . db_prefix() . 'contacts ON ' . db_prefix() . 'contacts.id = ' . db_prefix() . 'dpt_patient_profiles.contact_id'
];

$additionalSelect = [
    db_prefix() . 'dpt_meal_plans.id',
    db_prefix() . 'dpt_meal_plans.name',
    db_prefix() . 'contacts.firstname',
    db_prefix() . 'contacts.lastname',
    db_prefix() . 'dpt_meal_plans.start_date',
    db_prefix() . 'dpt_meal_plans.status'
];

$result = data_tables_init($aColumns, $sIndexColumn, $sTable, $join, [], $additionalSelect);

$output  = $result['output'];
$rResult = $result['rResult'];

foreach ($rResult as $aRow) {
    $row = [];

    $row[] = $aRow['id'];

    $patient_name = $aRow['firstname'] . ' ' . $aRow['lastname'];
    $row[] = '<a href="' . admin_url('dietician_patient_tracking/meal_plan/' . $aRow['id']) . '">' . $patient_name . '</a>';

    $row[] = '<a href="' . admin_url('dietician_patient_tracking/meal_plan/' . $aRow['id']) . '">' .
             $aRow['name'] . '</a>';

    $row[] = _d($aRow['start_date']);

    $status_class = '';
    switch ($aRow['status']) {
        case 'draft':
            $status_class = 'default';
            break;
        case 'active':
            $status_class = 'success';
            break;
        case 'completed':
            $status_class = 'info';
            break;
        case 'archived':
            $status_class = 'warning';
            break;
    }
    $row[] = '<span class="label label-' . $status_class . '">' . _l('dpt_' . $aRow['status']) . '</span>';

    $options = '<div class="btn-group">';
    $options .= '<a href="' . admin_url('dietician_patient_tracking/meal_plan/' . $aRow['id']) . '" class="btn btn-default btn-icon"><i class="fa fa-eye"></i></a>';
    if (has_permission('dietician_patient_tracking', '', 'delete')) {
        $options .= '<a href="' . admin_url('dietician_patient_tracking/delete_meal_plan/' . $aRow['id']) . '" class="btn btn-danger btn-icon dpt-delete-btn" data-type="meal_plan"><i class="fa fa-trash"></i></a>';
    }
    $options .= '</div>';

    $row[] = $options;

    $output['aaData'][] = $row;
}

echo json_encode($output);

