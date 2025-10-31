<?php

defined('BASEPATH') or exit('No direct script access allowed');

$aColumns = [
    'id',
    'firstname',
    'lastname',
    'email',
    'dietician_firstname',
    'status',
    'created_at'
];

$sIndexColumn = 'id';
$sTable       = db_prefix() . 'dpt_patient_profiles';

$join = [
    'LEFT JOIN ' . db_prefix() . 'contacts ON ' . db_prefix() . 'contacts.id = ' . db_prefix() . 'dpt_patient_profiles.contact_id',
    'LEFT JOIN ' . db_prefix() . 'staff ON ' . db_prefix() . 'staff.staffid = ' . db_prefix() . 'dpt_patient_profiles.dietician_id'
];

$result = data_tables_init($aColumns, $sIndexColumn, $sTable, $join, [], [
    db_prefix() . 'dpt_patient_profiles.id',
    db_prefix() . 'contacts.firstname',
    db_prefix() . 'contacts.lastname',
    db_prefix() . 'contacts.email',
    'CONCAT(' . db_prefix() . 'staff.firstname, " ", ' . db_prefix() . 'staff.lastname) as dietician_name',
    db_prefix() . 'dpt_patient_profiles.status',
    db_prefix() . 'dpt_patient_profiles.created_at'
]);

$output  = $result['output'];
$rResult = $result['rResult'];

foreach ($rResult as $aRow) {
    $row = [];

    $row[] = $aRow['id'];

    $row[] = '<a href="' . admin_url('dietician_patient_tracking/patient/' . $aRow['id']) . '">' .
             $aRow['firstname'] . ' ' . $aRow['lastname'] . '</a>';

    $row[] = $aRow['email'];

    $row[] = $aRow['dietician_name'];

    $status_class = '';
    switch ($aRow['status']) {
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
    $row[] = '<span class="label label-' . $status_class . '">' . _l('dpt_' . $aRow['status']) . '</span>';

    $row[] = _dt($aRow['created_at']);

    $options = '<div class="btn-group">';
    $options .= '<a href="' . admin_url('dietician_patient_tracking/patient/' . $aRow['id']) . '" class="btn btn-default btn-icon"><i class="fa fa-eye"></i></a>';
    if (has_permission('dietician_patient_tracking', '', 'delete')) {
        $options .= '<a href="' . admin_url('dietician_patient_tracking/delete_patient/' . $aRow['id']) . '" class="btn btn-danger btn-icon dpt-delete-btn" data-type="patient"><i class="fa fa-trash"></i></a>';
    }
    $options .= '</div>';

    $row[] = $options;

    $output['aaData'][] = $row;
}

echo json_encode($output);
