<?php

defined('BASEPATH') or exit('No direct script access allowed');

$aColumns = [
    db_prefix() . 'dpt_food_library.id',
    db_prefix() . 'dpt_food_library.name',
    db_prefix() . 'dpt_food_library.category',
    db_prefix() . 'dpt_food_library.calories',
    db_prefix() . 'dpt_food_library.protein',
    db_prefix() . 'dpt_food_library.carbohydrates',
    db_prefix() . 'dpt_food_library.fat'
];

$sIndexColumn = 'id';
$sTable       = db_prefix() . 'dpt_food_library';

$result = data_tables_init($aColumns, $sIndexColumn, $sTable, [], [], []);

$output  = $result['output'];
$rResult = $result['rResult'];

foreach ($rResult as $aRow) {
    $row = [];

    $id = $aRow[db_prefix() . 'dpt_food_library.id'];
    $row[] = $id;

    $row[] = '<a href="' . admin_url('dietician_patient_tracking/food_item/' . $id) . '">' .
             $aRow[db_prefix() . 'dpt_food_library.name'] . '</a>';

    $row[] = $aRow[db_prefix() . 'dpt_food_library.category'] ?: '-';

    $row[] = number_format($aRow[db_prefix() . 'dpt_food_library.calories'], 1) . ' kcal';

    $row[] = number_format($aRow[db_prefix() . 'dpt_food_library.protein'], 1) . ' g';

    $row[] = number_format($aRow[db_prefix() . 'dpt_food_library.carbohydrates'], 1) . ' g';

    $row[] = number_format($aRow[db_prefix() . 'dpt_food_library.fat'], 1) . ' g';

    $options = '<div class="btn-group">';
    $options .= '<a href="' . admin_url('dietician_patient_tracking/food_item/' . $id) . '" class="btn btn-default btn-icon"><i class="fa fa-eye"></i></a>';
    if (has_permission('dietician_patient_tracking', '', 'delete')) {
        $options .= '<a href="' . admin_url('dietician_patient_tracking/delete_food_item/' . $id) . '" class="btn btn-danger btn-icon dpt-delete-btn" data-type="food_item"><i class="fa fa-trash"></i></a>';
    }
    $options .= '</div>';

    $row[] = $options;

    $output['aaData'][] = $row;
}

echo json_encode($output);
