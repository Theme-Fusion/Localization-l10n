<?php

defined('BASEPATH') or exit('No direct script access allowed');

$aColumns = [
    db_prefix() . 'dpt_reminders.id as id',
    '(SELECT CONCAT(firstname, " ", lastname) FROM ' . db_prefix() . 'contacts WHERE id = (SELECT contact_id FROM ' . db_prefix() . 'dpt_patient_profiles WHERE id = ' . db_prefix() . 'dpt_reminders.patient_id)) as patient_name',
    db_prefix() . 'dpt_reminders.reminder_type as reminder_type',
    db_prefix() . 'dpt_reminders.title as title',
    db_prefix() . 'dpt_reminders.frequency as frequency',
    db_prefix() . 'dpt_reminders.next_trigger_date as next_trigger_date',
    db_prefix() . 'dpt_reminders.status as status',
];

$sIndexColumn = 'id';
$sTable = db_prefix() . 'dpt_reminders';

$result = data_tables_init($aColumns, $sIndexColumn, $sTable, [], [], [
    'patient_id',
    'send_via_sms',
    'send_via_email',
]);

$output = $result['output'];
$rResult = $result['rResult'];

foreach ($rResult as $aRow) {
    $row = [];

    $row[] = '<a href="' . admin_url('dietician_patient_tracking/reminder/' . $aRow['id']) . '">#' . $aRow['id'] . '</a>';

    $row[] = $aRow['patient_name'] ?? '-';

    // Reminder type
    $type_icon = '';
    switch ($aRow['reminder_type']) {
        case 'meal':
            $type_icon = 'fa-cutlery';
            break;
        case 'hydration':
            $type_icon = 'fa-tint';
            break;
        case 'medication':
            $type_icon = 'fa-medkit';
            break;
        case 'appointment':
            $type_icon = 'fa-calendar';
            break;
        case 'measurement':
            $type_icon = 'fa-balance-scale';
            break;
        case 'plan_renewal':
            $type_icon = 'fa-refresh';
            break;
        default:
            $type_icon = 'fa-bell';
    }
    $row[] = '<i class="fa ' . $type_icon . '"></i> ' . _l('dpt_reminder_' . $aRow['reminder_type']);

    $row[] = '<a href="' . admin_url('dietician_patient_tracking/reminder/' . $aRow['id']) . '"><strong>' . $aRow['title'] . '</strong></a>';

    $row[] = '<span class="label label-default">' . _l('dpt_frequency_' . $aRow['frequency']) . '</span>';

    $row[] = $aRow['next_trigger_date'] ? _dt($aRow['next_trigger_date']) : '-';

    // Status
    $status_class = '';
    switch ($aRow['status']) {
        case 'active':
            $status_class = 'success';
            break;
        case 'paused':
            $status_class = 'warning';
            break;
        case 'completed':
            $status_class = 'info';
            break;
        case 'cancelled':
            $status_class = 'danger';
            break;
    }
    $row[] = '<span class="label label-' . $status_class . '">' . _l('dpt_' . $aRow['status']) . '</span>';

    // Communication channels
    $channels = '';
    if ($aRow['send_via_email']) {
        $channels .= '<i class="fa fa-envelope text-info" title="Email"></i> ';
    }
    if ($aRow['send_via_sms']) {
        $channels .= '<i class="fa fa-mobile text-success" title="SMS"></i> ';
    }
    $row[] = $channels;

    // Options column
    $options = '<div class="btn-group">';
    $options .= '<a href="' . admin_url('dietician_patient_tracking/reminder/' . $aRow['id']) . '" class="btn btn-default btn-sm"><i class="fa fa-eye"></i></a>';

    if (has_permission('dietician_patient_tracking', '', 'delete')) {
        $options .= '<a href="#" class="btn btn-danger btn-sm" onclick="delete_reminder(' . $aRow['id'] . '); return false;"><i class="fa fa-trash"></i></a>';
    }

    $options .= '</div>';

    $row[] = $options;

    $output['aaData'][] = $row;
}
