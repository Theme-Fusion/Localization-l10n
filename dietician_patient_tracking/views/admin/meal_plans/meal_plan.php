<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head(); ?>
<div id="wrapper">
    <div class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="panel_s">
                    <div class="panel-body">
                        <h4><?php echo isset($meal_plan) ? _l('dpt_edit_meal_plan') : _l('dpt_add_meal_plan'); ?></h4>
                        <hr />
                        <?php echo form_open(admin_url('dietician_patient_tracking/meal_plan' . (isset($meal_plan) ? '/' . $meal_plan->id : '')), ['id' => 'meal-plan-form']); ?>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label><?php echo _l('dpt_patient'); ?> *</label>
                                    <select name="patient_id" class="selectpicker" data-live-search="true" data-width="100%" required>
                                        <?php foreach ($patients as $p) : ?>
                                            <option value="<?php echo $p->id; ?>" <?php echo (isset($meal_plan) && $meal_plan->patient_id == $p->id) ? 'selected' : ''; ?>>
                                                <?php echo $p->firstname . ' ' . $p->lastname; ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label><?php echo _l('dpt_meal_plan_name'); ?> *</label>
                                    <input type="text" class="form-control" name="name" value="<?php echo isset($meal_plan) ? $meal_plan->name : ''; ?>" required>
                                </div>
                                <div class="form-group">
                                    <label><?php echo _l('dpt_start_date'); ?></label>
                                    <input type="date" class="form-control" name="start_date" value="<?php echo isset($meal_plan) ? $meal_plan->start_date : ''; ?>">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label><?php echo _l('dpt_target_calories'); ?></label>
                                    <input type="number" class="form-control" name="target_calories" value="<?php echo isset($meal_plan) ? $meal_plan->target_calories : ''; ?>">
                                </div>
                                <div class="form-group">
                                    <label><?php echo _l('dpt_status'); ?></label>
                                    <select name="status" class="selectpicker" data-width="100%">
                                        <option value="draft" <?php echo (isset($meal_plan) && $meal_plan->status == 'draft') ? 'selected' : ''; ?>><?php echo _l('draft'); ?></option>
                                        <option value="active" <?php echo (isset($meal_plan) && $meal_plan->status == 'active') ? 'selected' : ''; ?>><?php echo _l('dpt_active'); ?></option>
                                        <option value="completed" <?php echo (isset($meal_plan) && $meal_plan->status == 'completed') ? 'selected' : ''; ?>><?php echo _l('dpt_completed'); ?></option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label><?php echo _l('dpt_description'); ?></label>
                            <textarea class="form-control" name="description" rows="3"><?php echo isset($meal_plan) ? $meal_plan->description : ''; ?></textarea>
                        </div>
                        <div class="btn-bottom-toolbar text-right">
                            <a href="<?php echo admin_url('dietician_patient_tracking/meal_plans'); ?>" class="btn btn-default"><?php echo _l('cancel'); ?></a>
                            <button type="submit" class="btn btn-info"><?php echo _l('save'); ?></button>
                        </div>
                        <?php echo form_close(); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php init_tail(); ?>
