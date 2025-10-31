<?php

defined('BASEPATH') or exit('No direct script access allowed');

$aColumns = [
    db_prefix() . 'dpt_patient_profiles.id',
    db_prefix() . 'contacts.firstname',
    db_prefix() . 'contacts.lastname',
    db_prefix() . 'contacts.email',
    db_prefix() . 'staff.firstname',
    db_prefix() . 'dpt_patient_profiles.status',
    db_prefix() . 'dpt_patient_profiles.created_at'
];

$sIndexColumn = 'id';
$sTable       = db_prefix() . 'dpt_patient_profiles';

$join = [
    'LEFT JOIN ' . db_prefix() . 'contacts ON ' . db_prefix() . 'contacts.id = ' . db_prefix() . 'dpt_patient_profiles.contact_id',
    'LEFT JOIN ' . db_prefix() . 'staff ON ' . db_prefix() . 'staff.staffid = ' . db_prefix() . 'dpt_patient_profiles.dietician_id'
];

$additionalSelect = [
    db_prefix() . 'staff.lastname as staff_lastname'
];

$result = data_tables_init($aColumns, $sIndexColumn, $sTable, $join, [], $additionalSelect);

$output  = $result['output'];
$rResult = $result['rResult'];

foreach ($rResult as $aRow) {
    $row = [];

    $row[] = $aRow[db_prefix() . 'dpt_patient_profiles.id'];

    $name = $aRow[db_prefix() . 'contacts.firstname'] . ' ' . $aRow[db_prefix() . 'contacts.lastname'];
    $row[] = '<a href="' . admin_url('dietician_patient_tracking/patient/' . $aRow[db_prefix() . 'dpt_patient_profiles.id']) . '">' . $name . '</a>';

    $row[] = $aRow[db_prefix() . 'contacts.email'];

    $dietician_name = '-';
    if (!empty($aRow[db_prefix() . 'staff.firstname'])) {
        $dietician_name = $aRow[db_prefix() . 'staff.firstname'] . ' ' . $aRow['staff_lastname'];
    }
    $row[] = $dietician_name;

    $status = $aRow[db_prefix() . 'dpt_patient_profiles.status'];
    $status_class = '';
    switch ($status) {
        case 'active':
            $status_class = 'success';
            break;
        case 'inactive':
            $status_class = 'default';
            break;
        case 'completed':
            $status_class = 'info';
            break;
        case 'archived':
            $status_class = 'warning';
            break;
    }
    $row[] = '<span class="label label-' . $status_class . '">' . _l('dpt_' . $status) . '</span>';

    $row[] = _dt($aRow[db_prefix() . 'dpt_patient_profiles.created_at']);

    $options = '<div class="btn-group">';
    $options .= '<a href="' . admin_url('dietician_patient_tracking/patient/' . $aRow[db_prefix() . 'dpt_patient_profiles.id']) . '" class="btn btn-default btn-icon"><i class="fa fa-eye"></i></a>';
    if (has_permission('dietician_patient_tracking', '', 'delete')) {
        $options .= '<a href="' . admin_url('dietician_patient_tracking/delete_patient/' . $aRow[db_prefix() . 'dpt_patient_profiles.id']) . '" class="btn btn-danger btn-icon dpt-delete-btn" data-type="patient"><i class="fa fa-trash"></i></a>';
    }
    $options .= '</div>';

    $row[] = $options;

    $output['aaData'][] = $row;
}

echo json_encode($output);

