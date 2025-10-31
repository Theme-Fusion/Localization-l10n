<?php

defined('BASEPATH') or exit('No direct script access allowed');

$aColumns = [
    'id',
    'name',
    '(SELECT CONCAT(firstname, " ", lastname) FROM ' . db_prefix() . 'contacts WHERE id = (SELECT contact_id FROM ' . db_prefix() . 'dpt_patient_profiles WHERE id = ' . db_prefix() . 'dpt_programs.patient_id)) as patient_name',
    'program_type',
    'start_date',
    'end_date',
    'status',
    'completion_percentage',
];

$sIndexColumn = 'id';
$sTable = db_prefix() . 'dpt_programs';

$result = data_tables_init($aColumns, $sIndexColumn, $sTable, [], [], [
    'patient_id',
    'dietician_id',
    'daily_calories_target',
]);

$output = $result['output'];
$rResult = $result['rResult'];

foreach ($rResult as $aRow) {
    $row = [];

    for ($i = 0; $i < count($aColumns); $i++) {
        if (strpos($aColumns[$i], 'as') !== false && !isset($aRow[$aColumns[$i]])) {
            $_data = $aRow[$sIndexColumn];
        } else {
            $_data = $aRow[$aColumns[$i]];
        }

        if ($aColumns[$i] == 'id') {
            $_data = '<a href="' . admin_url('dietician_patient_tracking/program/' . $aRow['id']) . '">' . $aRow['id'] . '</a>';
        } elseif ($aColumns[$i] == 'name') {
            $_data = '<a href="' . admin_url('dietician_patient_tracking/program/' . $aRow['id']) . '"><strong>' . $aRow['name'] . '</strong></a>';
        } elseif ($aColumns[$i] == 'program_type') {
            $_data = _l('dpt_program_' . $aRow['program_type']);
        } elseif ($aColumns[$i] == 'start_date') {
            $_data = _d($aRow['start_date']);
        } elseif ($aColumns[$i] == 'end_date') {
            $_data = $aRow['end_date'] ? _d($aRow['end_date']) : '-';
        } elseif ($aColumns[$i] == 'status') {
            $status_class = '';
            switch ($aRow['status']) {
                case 'active':
                    $status_class = 'success';
                    break;
                case 'completed':
                    $status_class = 'info';
                    break;
                case 'paused':
                    $status_class = 'warning';
                    break;
                case 'draft':
                    $status_class = 'default';
                    break;
                case 'cancelled':
                    $status_class = 'danger';
                    break;
            }
            $_data = '<span class="label label-' . $status_class . '">' . _l('dpt_' . $aRow['status']) . '</span>';
        } elseif ($aColumns[$i] == 'completion_percentage') {
            $percentage = (int)$aRow['completion_percentage'];
            $progress_class = $percentage >= 75 ? 'success' : ($percentage >= 50 ? 'info' : ($percentage >= 25 ? 'warning' : 'danger'));
            $_data = '<div class="progress" style="margin-bottom:0;">
                        <div class="progress-bar progress-bar-' . $progress_class . '" role="progressbar" aria-valuenow="' . $percentage . '" aria-valuemin="0" aria-valuemax="100" style="width: ' . $percentage . '%;">
                            ' . $percentage . '%
                        </div>
                    </div>';
        }

        $row[] = $_data;
    }

    // Options column
    $options = '<div class="btn-group">';
    $options .= '<a href="' . admin_url('dietician_patient_tracking/program/' . $aRow['id']) . '" class="btn btn-default btn-sm"><i class="fa fa-eye"></i></a>';

    if (has_permission('dietician_patient_tracking', '', 'delete')) {
        $options .= '<a href="#" class="btn btn-danger btn-sm" onclick="delete_program(' . $aRow['id'] . '); return false;"><i class="fa fa-trash"></i></a>';
    }

    $options .= '</div>';

    $row[] = $options;

    $output['aaData'][] = $row;
}
