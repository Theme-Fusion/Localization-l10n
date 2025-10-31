<?php

defined('BASEPATH') or exit('No direct script access allowed');

$aColumns = [
    'id',
    'firstname',
    'consultation_date',
    'consultation_type',
    'status'
];

$sIndexColumn = 'id';
$sTable       = db_prefix() . 'dpt_consultations';

$join = [
    'LEFT JOIN ' . db_prefix() . 'dpt_patient_profiles ON ' . db_prefix() . 'dpt_patient_profiles.id = ' . db_prefix() . 'dpt_consultations.patient_id',
    'LEFT JOIN ' . db_prefix() . 'contacts ON ' . db_prefix() . 'contacts.id = ' . db_prefix() . 'dpt_patient_profiles.contact_id'
];

$result = data_tables_init($aColumns, $sIndexColumn, $sTable, $join, [], [
    db_prefix() . 'dpt_consultations.id',
    'CONCAT(' . db_prefix() . 'contacts.firstname, " ", ' . db_prefix() . 'contacts.lastname) as patient_name',
    db_prefix() . 'dpt_consultations.consultation_date',
    db_prefix() . 'dpt_consultations.consultation_type',
    db_prefix() . 'dpt_consultations.subject',
    db_prefix() . 'dpt_consultations.status'
]);

$output  = $result['output'];
$rResult = $result['rResult'];

foreach ($rResult as $aRow) {
    $row = [];

    $row[] = $aRow['id'];

    $row[] = '<a href="' . admin_url('dietician_patient_tracking/consultation/' . $aRow['id']) . '">' .
             $aRow['patient_name'] . '</a>';

    $row[] = _dt($aRow['consultation_date']);

    $row[] = '<span class="label label-info">' . _l('dpt_consultation_' . $aRow['consultation_type']) . '</span>';

    $status_class = '';
    switch ($aRow['status']) {
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
    $row[] = '<span class="label label-' . $status_class . '">' . _l('dpt_' . $aRow['status']) . '</span>';

    $options = '<div class="btn-group">';
    $options .= '<a href="' . admin_url('dietician_patient_tracking/consultation/' . $aRow['id']) . '" class="btn btn-default btn-icon"><i class="fa fa-eye"></i></a>';
    if (has_permission('dietician_patient_tracking', '', 'delete')) {
        $options .= '<a href="' . admin_url('dietician_patient_tracking/delete_consultation/' . $aRow['id']) . '" class="btn btn-danger btn-icon dpt-delete-btn" data-type="consultation"><i class="fa fa-trash"></i></a>';
    }
    $options .= '</div>';

    $row[] = $options;

    $output['aaData'][] = $row;
}

echo json_encode($output);
