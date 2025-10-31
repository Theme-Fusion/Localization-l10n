<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head(); ?>

<div id="wrapper">
    <div class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="panel_s">
                    <div class="panel-body">
                        <div class="_buttons">
                            <a href="<?php echo admin_url('dietician_patient_tracking/patient'); ?>" class="btn btn-info pull-left">
                                <i class="fa fa-plus"></i> <?php echo _l('dpt_add_patient'); ?>
                            </a>
                            <div class="clearfix"></div>
                        </div>
                        <hr class="hr-panel-heading" />

                        <div class="clearfix"></div>

                        <div class="table-responsive">
                            <table class="table table-striped table-hover dpt-datatable" id="patients-table">
                                <thead>
                                    <tr>
                                        <th><?php echo _l('id'); ?></th>
                                        <th><?php echo _l('dpt_patient'); ?></th>
                                        <th><?php echo _l('dpt_contact'); ?></th>
                                        <th><?php echo _l('dpt_dietician'); ?></th>
                                        <th><?php echo _l('dpt_status'); ?></th>
                                        <th><?php echo _l('dpt_created_at'); ?></th>
                                        <th><?php echo _l('options'); ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- Data loaded via AJAX -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php init_tail(); ?>
