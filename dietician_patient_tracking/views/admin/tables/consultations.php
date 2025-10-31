<?php

defined('BASEPATH') or exit('No direct script access allowed');

$aColumns = [
    db_prefix() . 'dpt_consultations.id',
    db_prefix() . 'contacts.firstname',
    db_prefix() . 'dpt_consultations.consultation_date',
    db_prefix() . 'dpt_consultations.consultation_type',
    db_prefix() . 'dpt_consultations.status'
];

$sIndexColumn = 'id';
$sTable       = db_prefix() . 'dpt_consultations';

$join = [
    'LEFT JOIN ' . db_prefix() . 'dpt_patient_profiles ON ' . db_prefix() . 'dpt_patient_profiles.id = ' . db_prefix() . 'dpt_consultations.patient_id',
    'LEFT JOIN ' . db_prefix() . 'contacts ON ' . db_prefix() . 'contacts.id = ' . db_prefix() . 'dpt_patient_profiles.contact_id'
];

$additionalSelect = [
    db_prefix() . 'contacts.lastname as contact_lastname',
    db_prefix() . 'dpt_consultations.subject'
];

$result = data_tables_init($aColumns, $sIndexColumn, $sTable, $join, [], $additionalSelect);

$output  = $result['output'];
$rResult = $result['rResult'];

foreach ($rResult as $aRow) {
    $row = [];

    $id = $aRow[db_prefix() . 'dpt_consultations.id'];
    $row[] = $id;

    $patient_name = $aRow[db_prefix() . 'contacts.firstname'] . ' ' . $aRow['contact_lastname'];
    $row[] = '<a href="' . admin_url('dietician_patient_tracking/consultation/' . $id) . '">' . $patient_name . '</a>';

    $row[] = _dt($aRow[db_prefix() . 'dpt_consultations.consultation_date']);

    $row[] = '<span class="label label-info">' . _l('dpt_consultation_' . $aRow[db_prefix() . 'dpt_consultations.consultation_type']) . '</span>';

    $status = $aRow[db_prefix() . 'dpt_consultations.status'];
    $status_class = '';
    switch ($status) {
        case 'scheduled':
            $status_class = 'warning';
            break;
        case 'completed':
            $status_class = 'success';
            break;
        case 'cancelled':
            $status_class = 'danger';
            break;
        case 'no_show':
            $status_class = 'default';
            break;
    }
    $row[] = '<span class="label label-' . $status_class . '">' . _l('dpt_' . $status) . '</span>';

    $options = '<div class="btn-group">';
    $options .= '<a href="' . admin_url('dietician_patient_tracking/consultation/' . $id) . '" class="btn btn-default btn-icon"><i class="fa fa-eye"></i></a>';
    if (has_permission('dietician_patient_tracking', '', 'delete')) {
        $options .= '<a href="' . admin_url('dietician_patient_tracking/delete_consultation/' . $id) . '" class="btn btn-danger btn-icon dpt-delete-btn" data-type="consultation"><i class="fa fa-trash"></i></a>';
    }
    $options .= '</div>';

    $row[] = $options;

    $output['aaData'][] = $row;
}

echo json_encode($output);
