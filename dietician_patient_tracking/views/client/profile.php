<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<div class="panel_s">
    <div class="panel-body">
        <h4><?php echo _l('dpt_my_profile'); ?></h4>
        <hr />
        <?php echo form_open(site_url('dietician_patient_tracking/client/profile')); ?>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label><?php echo _l('dpt_height'); ?> (cm)</label>
                    <input type="number" step="0.01" class="form-control" name="height" value="<?php echo $patient->height; ?>">
                </div>
                <div class="form-group">
                    <label><?php echo _l('dpt_activity_level'); ?></label>
                    <select name="activity_level" class="form-control">
                        <?php foreach ($activity_levels as $key => $label) : ?>
                            <option value="<?php echo $key; ?>" <?php echo ($patient->activity_level == $key) ? 'selected' : ''; ?>><?php echo $label; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label><?php echo _l('dpt_goal_type'); ?></label>
                    <select name="goal_type" class="form-control">
                        <?php foreach ($goal_types as $key => $label) : ?>
                            <option value="<?php echo $key; ?>" <?php echo ($patient->goal_type == $key) ? 'selected' : ''; ?>><?php echo $label; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label><?php echo _l('dpt_target_weight'); ?> (kg)</label>
                    <input type="number" step="0.1" class="form-control" name="target_weight" value="<?php echo $patient->target_weight; ?>">
                </div>
            </div>
        </div>
        <button type="submit" class="btn btn-info"><?php echo _l('save'); ?></button>
        <?php echo form_close(); ?>
    </div>
</div>
