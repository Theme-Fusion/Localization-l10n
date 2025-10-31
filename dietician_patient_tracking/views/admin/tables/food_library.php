<?php

defined('BASEPATH') or exit('No direct script access allowed');

$aColumns = [
    'id',
    'name',
    'category',
    'calories',
    'protein',
    'carbohydrates',
    'fat'
];

$sIndexColumn = 'id';
$sTable       = db_prefix() . 'dpt_food_library';

$result = data_tables_init($aColumns, $sIndexColumn, $sTable, [], [], [
    'id',
    'name',
    'category',
    'calories',
    'protein',
    'carbohydrates',
    'fat'
]);

$output  = $result['output'];
$rResult = $result['rResult'];

foreach ($rResult as $aRow) {
    $row = [];

    $row[] = $aRow['id'];

    $row[] = '<a href="' . admin_url('dietician_patient_tracking/food_item/' . $aRow['id']) . '">' .
             $aRow['name'] . '</a>';

    $row[] = $aRow['category'];

    $row[] = number_format($aRow['calories'], 1) . ' kcal';

    $row[] = number_format($aRow['protein'], 1) . ' g';

    $row[] = number_format($aRow['carbohydrates'], 1) . ' g';

    $row[] = number_format($aRow['fat'], 1) . ' g';

    $options = '<div class="btn-group">';
    $options .= '<a href="' . admin_url('dietician_patient_tracking/food_item/' . $aRow['id']) . '" class="btn btn-default btn-icon"><i class="fa fa-eye"></i></a>';
    if (has_permission('dietician_patient_tracking', '', 'delete')) {
        $options .= '<a href="' . admin_url('dietician_patient_tracking/delete_food_item/' . $aRow['id']) . '" class="btn btn-danger btn-icon dpt-delete-btn" data-type="food_item"><i class="fa fa-trash"></i></a>';
    }
    $options .= '</div>';

    $row[] = $options;

    $output['aaData'][] = $row;
}

echo json_encode($output);
