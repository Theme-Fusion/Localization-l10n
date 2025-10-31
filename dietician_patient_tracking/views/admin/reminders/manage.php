<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head(); ?>

<div id="wrapper">
    <div class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="panel_s">
                    <div class="panel-body">
                        <div class="_buttons">
                            <a href="<?php echo admin_url('dietician_patient_tracking/reminder'); ?>" class="btn btn-primary pull-left">
                                <i class="fa fa-plus"></i>
                                <?php echo _l('dpt_add_reminder'); ?>
                            </a>
                            <div class="clearfix"></div>
                        </div>

                        <div class="clearfix"></div>
                        <hr class="hr-panel-heading" />

                        <div class="clearfix"></div>

                        <?php render_datatable([
                            '#',
                            _l('dpt_patient'),
                            _l('dpt_reminder_type'),
                            _l('dpt_title'),
                            _l('dpt_frequency'),
                            _l('dpt_next_trigger_date'),
                            _l('dpt_status'),
                            _l('channels'),
                            _l('options'),
                        ], 'reminders'); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php init_tail(); ?>

<script>
    $(function() {
        initDataTable('.table-reminders', window.location.href, [8], [8], {}, [5, 'asc']);
    });

    function delete_reminder(id) {
        if (confirm('<?php echo _l('confirm_delete'); ?>')) {
            $.post('<?php echo admin_url('dietician_patient_tracking/delete_reminder/'); ?>' + id, function(response) {
                response = JSON.parse(response);
                if (response.success) {
                    alert_float('success', response.message);
                    $('.table-reminders').DataTable().ajax.reload();
                } else {
                    alert_float('danger', response.message);
                }
            });
        }
    }
</script>

</body>
</html>
