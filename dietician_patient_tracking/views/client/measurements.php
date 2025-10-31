<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<div class="panel_s">
    <div class="panel-body">
        <h4><?php echo _l('dpt_my_measurements'); ?></h4>
        <hr />
        
        <button type="button" class="btn btn-info" data-modal-target="add-measurement-modal">
            <i class="fa fa-plus"></i> <?php echo _l('dpt_add_measurement'); ?>
        </button>

        <div class="table-responsive mtop20">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th><?php echo _l('dpt_date'); ?></th>
                        <th><?php echo _l('dpt_weight'); ?></th>
                        <th><?php echo _l('dpt_body_fat_percentage'); ?></th>
                        <th><?php echo _l('dpt_waist_circumference'); ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($measurements)) : ?>
                        <?php foreach ($measurements as $m) : ?>
                            <tr>
                                <td><?php echo date('d/m/Y', strtotime($m->measurement_date)); ?></td>
                                <td><?php echo $m->weight ? $m->weight . ' kg' : '-'; ?></td>
                                <td><?php echo $m->body_fat_percentage ? $m->body_fat_percentage . ' %' : '-'; ?></td>
                                <td><?php echo $m->waist_circumference ? $m->waist_circumference . ' cm' : '-'; ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else : ?>
                        <tr>
                            <td colspan="4" class="text-center"><?php echo _l('dpt_no_measurements'); ?></td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <?php if (isset($weight_chart_data) && !empty($weight_chart_data['labels'])) : ?>
            <div class="mtop30">
                <h4><?php echo _l('dpt_weight_progress'); ?></h4>
                <canvas id="client-weight-chart" data-chart='<?php echo json_encode($weight_chart_data); ?>' height="80"></canvas>
            </div>
        <?php endif; ?>
    </div>
</div>

<!-- Add Measurement Modal -->
<div class="dpt-modal-overlay" id="add-measurement-modal">
    <div class="dpt-modal">
        <div class="dpt-modal-header">
            <h4 class="dpt-modal-title"><?php echo _l('dpt_add_measurement'); ?></h4>
            <button class="dpt-modal-close">&times;</button>
        </div>
        <?php echo form_open(site_url('dietician_patient_tracking/client/add_measurement'), ['id' => 'add-measurement-form']); ?>
        <div class="form-group">
            <label><?php echo _l('dpt_weight'); ?> (kg) *</label>
            <input type="number" step="0.1" class="form-control" name="weight" id="measurement-weight" required>
        </div>
        <div class="form-group">
            <label><?php echo _l('dpt_body_fat_percentage'); ?> (%)</label>
            <input type="number" step="0.1" class="form-control" name="body_fat_percentage">
        </div>
        <div class="form-group">
            <label><?php echo _l('dpt_waist_circumference'); ?> (cm)</label>
            <input type="number" step="0.1" class="form-control" name="waist_circumference">
        </div>
        <div class="form-group">
            <label><?php echo _l('dpt_hip_circumference'); ?> (cm)</label>
            <input type="number" step="0.1" class="form-control" name="hip_circumference">
        </div>
        <button type="submit" class="btn btn-info"><?php echo _l('save'); ?></button>
        <?php echo form_close(); ?>
    </div>
</div>
