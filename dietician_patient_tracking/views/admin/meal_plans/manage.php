<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head(); ?>
<div id="wrapper">
    <div class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="panel_s">
                    <div class="panel-body">
                        <div class="_buttons">
                            <a href="<?php echo admin_url('dietician_patient_tracking/meal_plan'); ?>" class="btn btn-info pull-left">
                                <i class="fa fa-plus"></i> <?php echo _l('dpt_add_meal_plan'); ?>
                            </a>
                        </div>
                        <hr class="hr-panel-heading" />
                        <div class="table-responsive">
                            <table class="table table-striped dt-table" id="meal-plans-table" data-order-col="0" data-order-type="desc">
                                <thead>
                                    <tr>
                                        <th><?php echo _l('id'); ?></th>
                                        <th><?php echo _l('dpt_patient'); ?></th>
                                        <th><?php echo _l('dpt_meal_plan_name'); ?></th>
                                        <th><?php echo _l('dpt_start_date'); ?></th>
                                        <th><?php echo _l('dpt_status'); ?></th>
                                        <th><?php echo _l('options'); ?></th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php init_tail(); ?>
<script>
    $(function() {
        initDataTable('#meal-plans-table', '<?php echo admin_url('dietician_patient_tracking/meal_plans'); ?>', undefined, undefined, undefined, [0, 'desc']);
    });
</script>
