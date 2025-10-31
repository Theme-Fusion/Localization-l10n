<?php

defined('BASEPATH') or exit('No direct script access allowed');

$aColumns = [
    db_prefix() . 'dpt_satisfaction_surveys.id as id',
    '(SELECT CONCAT(firstname, " ", lastname) FROM ' . db_prefix() . 'contacts WHERE id = (SELECT contact_id FROM ' . db_prefix() . 'dpt_patient_profiles WHERE id = ' . db_prefix() . 'dpt_satisfaction_surveys.patient_id)) as patient_name',
    db_prefix() . 'dpt_consultations.subject as consultation_subject',
    db_prefix() . 'dpt_consultations.consultation_date as consultation_date',
    db_prefix() . 'dpt_satisfaction_surveys.nps_score as nps_score',
    db_prefix() . 'dpt_satisfaction_surveys.overall_satisfaction as overall_satisfaction',
    db_prefix() . 'dpt_satisfaction_surveys.survey_sent_at as survey_sent_at',
    db_prefix() . 'dpt_satisfaction_surveys.completed_at as completed_at',
];

$sIndexColumn = 'id';
$sTable = db_prefix() . 'dpt_satisfaction_surveys';

$join = [
    'LEFT JOIN ' . db_prefix() . 'dpt_consultations ON ' . db_prefix() . 'dpt_consultations.id = ' . db_prefix() . 'dpt_satisfaction_surveys.consultation_id',
];

$result = data_tables_init($aColumns, $sIndexColumn, $sTable, $join, [], [
    db_prefix() . 'dpt_satisfaction_surveys.patient_id',
    db_prefix() . 'dpt_satisfaction_surveys.consultation_id',
]);

$output = $result['output'];
$rResult = $result['rResult'];

foreach ($rResult as $aRow) {
    $row = [];

    $row[] = '#' . $aRow['id'];

    $row[] = $aRow['patient_name'] ?? '-';

    $row[] = '<a href="' . admin_url('dietician_patient_tracking/consultation/' . $aRow['consultation_id']) . '">' . ($aRow['consultation_subject'] ?? 'Consultation') . '</a>';

    $row[] = $aRow['consultation_date'] ? _dt($aRow['consultation_date']) : '-';

    // NPS Score with color coding
    if ($aRow['nps_score'] !== null) {
        $nps = (int)$aRow['nps_score'];
        $nps_class = $nps >= 9 ? 'success' : ($nps >= 7 ? 'warning' : 'danger');
        $nps_label = $nps >= 9 ? 'Promoteur' : ($nps >= 7 ? 'Passif' : 'Détracteur');
        $row[] = '<span class="label label-' . $nps_class . '" title="' . $nps_label . '">' . $nps . '/10</span>';
    } else {
        $row[] = '-';
    }

    // Overall satisfaction (stars)
    if ($aRow['overall_satisfaction']) {
        $stars = '';
        for ($i = 1; $i <= 5; $i++) {
            $stars .= $i <= $aRow['overall_satisfaction'] ? '<i class="fa fa-star text-warning"></i>' : '<i class="fa fa-star-o text-muted"></i>';
        }
        $row[] = $stars;
    } else {
        $row[] = '-';
    }

    $row[] = $aRow['survey_sent_at'] ? _dt($aRow['survey_sent_at']) : '-';

    // Completion status
    if ($aRow['completed_at']) {
        $row[] = '<span class="label label-success"><i class="fa fa-check"></i> ' . _dt($aRow['completed_at']) . '</span>';
    } else {
        $row[] = '<span class="label label-warning"><i class="fa fa-clock-o"></i> ' . _l('dpt_survey_pending') . '</span>';
    }

    // Options column
    $options = '<div class="btn-group">';
    $options .= '<a href="' . admin_url('dietician_patient_tracking/consultation/' . $aRow['consultation_id']) . '" class="btn btn-default btn-sm" title="' . _l('dpt_consultation') . '"><i class="fa fa-eye"></i></a>';
    $options .= '</div>';

    $row[] = $options;

    $output['aaData'][] = $row;
}
