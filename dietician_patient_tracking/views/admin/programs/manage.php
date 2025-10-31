<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head(); ?>

<div id="wrapper">
    <div class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="panel_s">
                    <div class="panel-body">
                        <div class="_buttons">
                            <a href="<?php echo admin_url('dietician_patient_tracking/program'); ?>" class="btn btn-primary pull-left">
                                <i class="fa fa-plus"></i>
                                <?php echo _l('dpt_add_program'); ?>
                            </a>
                            <div class="clearfix"></div>
                        </div>

                        <div class="clearfix"></div>
                        <hr class="hr-panel-heading" />

                        <div class="clearfix"></div>

                        <?php render_datatable([
                            _l('dpt_program') . ' #',
                            _l('dpt_program_name'),
                            _l('dpt_patient'),
                            _l('dpt_program_type'),
                            _l('dpt_start_date'),
                            _l('dpt_end_date'),
                            _l('dpt_status'),
                            _l('dpt_completion_percentage'),
                            _l('options'),
                        ], 'programs'); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php init_tail(); ?>

<script>
    $(function() {
        initDataTable('.table-programs', window.location.href, [7], [7], {}, [0, 'desc']);
    });

    function delete_program(id) {
        if (confirm('<?php echo _l('confirm_delete'); ?>')) {
            $.post('<?php echo admin_url('dietician_patient_tracking/delete_program/'); ?>' + id, function(response) {
                response = JSON.parse(response);
                if (response.success) {
                    alert_float('success', response.message);
                    $('.table-programs').DataTable().ajax.reload();
                } else {
                    alert_float('danger', response.message);
                }
            });
        }
    }
</script>

</body>
</html>
