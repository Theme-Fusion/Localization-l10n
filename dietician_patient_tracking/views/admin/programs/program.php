<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head(); ?>

<div id="wrapper">
    <div class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="panel_s">
                    <div class="panel-body">
                        <h4 class="no-margin">
                            <?php echo isset($program) ? _l('dpt_edit') . ' ' . _l('dpt_program') : _l('dpt_add_program'); ?>
                        </h4>
                        <hr class="hr-panel-heading" />

                        <?php echo form_open(admin_url('dietician_patient_tracking/program/' . (isset($program) ? $program->id : '')), ['id' => 'program-form']); ?>

                        <div class="row">
                            <div class="col-md-6">
                                <?php echo render_input('name', 'dpt_program_name', isset($program) ? $program->name : '', 'text', ['required' => true]); ?>
                            </div>

                            <div class="col-md-6">
                                <?php
                                $selected = isset($program) ? $program->patient_id : '';
                                echo render_select('patient_id', $patients, ['id', ['firstname', 'lastname']], 'dpt_patient', $selected, ['required' => true]);
                                ?>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <?php
                                $program_types = [
                                    ['id' => 'weight_loss', 'name' => _l('dpt_program_weight_loss')],
                                    ['id' => 'weight_gain', 'name' => _l('dpt_program_weight_gain')],
                                    ['id' => 'muscle_building', 'name' => _l('dpt_program_muscle_building')],
                                    ['id' => 'health_improvement', 'name' => _l('dpt_program_health_improvement')],
                                    ['id' => 'sports_nutrition', 'name' => _l('dpt_program_sports_nutrition')],
                                    ['id' => 'therapeutic', 'name' => _l('dpt_program_therapeutic')],
                                ];
                                $selected = isset($program) ? $program->program_type : '';
                                echo render_select('program_type', $program_types, ['id', 'name'], 'dpt_program_type', $selected, ['required' => true]);
                                ?>
                            </div>

                            <div class="col-md-4">
                                <?php
                                $statuses = [
                                    ['id' => 'draft', 'name' => _l('draft')],
                                    ['id' => 'active', 'name' => _l('dpt_active')],
                                    ['id' => 'paused', 'name' => _l('dpt_paused')],
                                    ['id' => 'completed', 'name' => _l('dpt_completed')],
                                    ['id' => 'cancelled', 'name' => _l('dpt_cancelled')],
                                ];
                                $selected = isset($program) ? $program->status : 'draft';
                                echo render_select('status', $statuses, ['id', 'name'], 'dpt_status', $selected);
                                ?>
                            </div>

                            <div class="col-md-4">
                                <?php echo render_input('duration_weeks', 'dpt_duration_weeks', isset($program) ? $program->duration_weeks : '', 'number'); ?>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <?php echo render_date_input('start_date', 'dpt_start_date', isset($program) ? $program->start_date : date('Y-m-d'), ['required' => true]); ?>
                            </div>

                            <div class="col-md-6">
                                <?php echo render_date_input('end_date', 'dpt_end_date', isset($program) ? $program->end_date : ''); ?>
                            </div>
                        </div>

                        <h4 class="mtop25"><?php echo _l('dpt_goals_objectives'); ?></h4>
                        <hr />

                        <div class="row">
                            <div class="col-md-3">
                                <?php echo render_input('target_weight', 'dpt_target_weight', isset($program) ? $program->target_weight : '', 'number', ['step' => '0.1']); ?>
                                <small class="text-muted"><?php echo _l('dpt_kg'); ?></small>
                            </div>

                            <div class="col-md-3">
                                <?php echo render_input('target_body_fat', 'dpt_target_body_fat', isset($program) ? $program->target_body_fat : '', 'number', ['step' => '0.1']); ?>
                                <small class="text-muted">%</small>
                            </div>

                            <div class="col-md-3">
                                <?php echo render_input('daily_calories_target', 'dpt_target_calories', isset($program) ? $program->daily_calories_target : '', 'number'); ?>
                                <small class="text-muted"><?php echo _l('dpt_kcal'); ?></small>
                            </div>

                            <div class="col-md-3">
                                <?php echo render_input('training_frequency', 'dpt_training_frequency', isset($program) ? $program->training_frequency : '', 'number'); ?>
                                <small class="text-muted"><?php echo _l('dpt_weekly'); ?></small>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <?php echo render_input('daily_protein_target', 'dpt_target_protein', isset($program) ? $program->daily_protein_target : '', 'number', ['step' => '0.1']); ?>
                                <small class="text-muted"><?php echo _l('dpt_g'); ?></small>
                            </div>

                            <div class="col-md-4">
                                <?php echo render_input('daily_carbs_target', 'dpt_target_carbs', isset($program) ? $program->daily_carbs_target : '', 'number', ['step' => '0.1']); ?>
                                <small class="text-muted"><?php echo _l('dpt_g'); ?></small>
                            </div>

                            <div class="col-md-4">
                                <?php echo render_input('daily_fat_target', 'dpt_target_fat', isset($program) ? $program->daily_fat_target : '', 'number', ['step' => '0.1']); ?>
                                <small class="text-muted"><?php echo _l('dpt_g'); ?></small>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <?php echo render_textarea('description', 'dpt_description', isset($program) ? $program->description : ''); ?>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary mtop15">
                            <i class="fa fa-check"></i>
                            <?php echo _l('submit'); ?>
                        </button>
                        <a href="<?php echo admin_url('dietician_patient_tracking/programs'); ?>" class="btn btn-default mtop15">
                            <?php echo _l('dpt_back'); ?>
                        </a>

                        <?php echo form_close(); ?>

                        <?php if (isset($program)): ?>
                            <!-- Milestones Section -->
                            <h4 class="mtop35"><?php echo _l('dpt_milestones'); ?></h4>
                            <hr />

                            <div class="row">
                                <div class="col-md-12">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th><?php echo _l('dpt_milestone'); ?></th>
                                                <th><?php echo _l('dpt_target_date'); ?></th>
                                                <th><?php echo _l('dpt_target_value'); ?></th>
                                                <th><?php echo _l('dpt_status'); ?></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if (!empty($milestones)): ?>
                                                <?php foreach ($milestones as $milestone): ?>
                                                    <tr>
                                                        <td><?php echo $milestone->title; ?></td>
                                                        <td><?php echo _d($milestone->target_date); ?></td>
                                                        <td><?php echo $milestone->target_value; ?> <?php echo $milestone->metric_type; ?></td>
                                                        <td>
                                                            <?php if ($milestone->achieved): ?>
                                                                <span class="label label-success">
                                                                    <i class="fa fa-check"></i> <?php echo _l('dpt_achieved'); ?>
                                                                    (<?php echo _d($milestone->achieved_date); ?>)
                                                                </span>
                                                            <?php else: ?>
                                                                <span class="label label-warning"><?php echo _l('dpt_pending'); ?></span>
                                                            <?php endif; ?>
                                                        </td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            <?php else: ?>
                                                <tr>
                                                    <td colspan="4" class="text-center text-muted">
                                                        <?php echo _l('no_data_found'); ?>
                                                    </td>
                                                </tr>
                                            <?php endif; ?>
                                        </tbody>
                                    </table>

                                    <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#milestoneModal">
                                        <i class="fa fa-plus"></i> <?php echo _l('dpt_add_milestone'); ?>
                                    </button>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php if (isset($program)): ?>
    <!-- Milestone Modal -->
    <div class="modal fade" id="milestoneModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                    <h4 class="modal-title"><?php echo _l('dpt_add_milestone'); ?></h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="milestone_title"><?php echo _l('dpt_milestone'); ?></label>
                        <input type="text" class="form-control" id="milestone_title" required>
                    </div>
                    <div class="form-group">
                        <label for="milestone_target_date"><?php echo _l('dpt_target_date'); ?></label>
                        <input type="date" class="form-control" id="milestone_target_date" required>
                    </div>
                    <div class="form-group">
                        <label for="milestone_target_value"><?php echo _l('dpt_target_value'); ?></label>
                        <input type="number" step="0.1" class="form-control" id="milestone_target_value">
                    </div>
                    <div class="form-group">
                        <label for="milestone_metric_type"><?php echo _l('dpt_type'); ?></label>
                        <select class="form-control" id="milestone_metric_type">
                            <option value="weight"><?php echo _l('dpt_weight'); ?></option>
                            <option value="body_fat"><?php echo _l('dpt_body_fat_percentage'); ?></option>
                            <option value="measurements"><?php echo _l('dpt_measurements'); ?></option>
                            <option value="calories"><?php echo _l('dpt_calories'); ?></option>
                            <option value="other"><?php echo _l('dpt_other'); ?></option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo _l('close'); ?></button>
                    <button type="button" class="btn btn-primary" onclick="addMilestone()"><?php echo _l('submit'); ?></button>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>

<?php init_tail(); ?>

<script>
    function addMilestone() {
        var data = {
            title: $('#milestone_title').val(),
            target_date: $('#milestone_target_date').val(),
            target_value: $('#milestone_target_value').val(),
            metric_type: $('#milestone_metric_type').val()
        };

        $.post('<?php echo admin_url('dietician_patient_tracking/add_program_milestone/' . (isset($program) ? $program->id : '')); ?>', data, function(response) {
            response = JSON.parse(response);
            if (response.success) {
                alert_float('success', response.message);
                $('#milestoneModal').modal('hide');
                location.reload();
            } else {
                alert_float('danger', response.message);
            }
        });
    }
</script>

</body>
</html>
