<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head(); ?>
<div id="wrapper">
    <div class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="panel_s">
                    <div class="panel-body">
                        <div class="_buttons">
                            <a href="<?php echo admin_url('dietician_patient_tracking/consultation'); ?>" class="btn btn-info pull-left">
                                <i class="fa fa-plus"></i> <?php echo _l('dpt_add_consultation'); ?>
                            </a>
                        </div>
                        <hr class="hr-panel-heading" />
                        <div class="table-responsive">
                            <table class="table table-striped dpt-datatable">
                                <thead>
                                    <tr>
                                        <th><?php echo _l('id'); ?></th>
                                        <th><?php echo _l('dpt_patient'); ?></th>
                                        <th><?php echo _l('dpt_consultation_date'); ?></th>
                                        <th><?php echo _l('dpt_type'); ?></th>
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
