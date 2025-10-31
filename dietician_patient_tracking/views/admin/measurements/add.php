<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head(); ?>

<div id="wrapper">
    <div class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="panel_s">
                    <div class="panel-body">
                        <h4 class="no-margin">
                            <a href="<?php echo admin_url('dietician_patient_tracking/patient/' . $patient->id); ?>" class="btn btn-default btn-sm pull-right">
                                <i class="fa fa-arrow-left"></i> <?php echo _l('back'); ?>
                            </a>
                            <?php echo _l('dpt_add_measurement'); ?> - <?php echo $patient->firstname . ' ' . $patient->lastname; ?>
                        </h4>
                        <hr class="hr-panel-heading" />

                        <?php echo form_open(admin_url('dietician_patient_tracking/add_measurement/' . $patient->id), ['id' => 'measurement-form']); ?>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="measurement_date"><?php echo _l('dpt_date'); ?> *</label>
                                    <input type="date" class="form-control" name="measurement_date" id="measurement_date"
                                        value="<?php echo date('Y-m-d'); ?>" required>
                                </div>

                                <div class="form-group">
                                    <label for="weight"><?php echo _l('dpt_weight'); ?> (kg) *</label>
                                    <input type="number" step="0.1" class="form-control" name="weight" id="weight" required>
                                    <small class="text-muted"><?php echo _l('dpt_weight_help'); ?></small>
                                </div>

                                <div class="form-group">
                                    <label for="body_fat_percentage"><?php echo _l('dpt_body_fat_percentage'); ?> (%)</label>
                                    <input type="number" step="0.1" class="form-control" name="body_fat_percentage" id="body_fat_percentage">
                                </div>

                                <div class="form-group">
                                    <label for="muscle_mass"><?php echo _l('dpt_muscle_mass'); ?> (kg)</label>
                                    <input type="number" step="0.1" class="form-control" name="muscle_mass" id="muscle_mass">
                                </div>

                                <div class="form-group">
                                    <label for="blood_pressure_systolic"><?php echo _l('dpt_blood_pressure'); ?> (mmHg)</label>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <input type="number" class="form-control" name="blood_pressure_systolic"
                                                id="blood_pressure_systolic" placeholder="<?php echo _l('dpt_systolic'); ?>">
                                        </div>
                                        <div class="col-md-6">
                                            <input type="number" class="form-control" name="blood_pressure_diastolic"
                                                placeholder="<?php echo _l('dpt_diastolic'); ?>">
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="blood_sugar"><?php echo _l('dpt_blood_sugar'); ?> (mg/dL)</label>
                                    <input type="number" step="0.1" class="form-control" name="blood_sugar" id="blood_sugar">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="waist_circumference"><?php echo _l('dpt_waist_circumference'); ?> (cm)</label>
                                    <input type="number" step="0.1" class="form-control" name="waist_circumference" id="waist_circumference">
                                </div>

                                <div class="form-group">
                                    <label for="hip_circumference"><?php echo _l('dpt_hip_circumference'); ?> (cm)</label>
                                    <input type="number" step="0.1" class="form-control" name="hip_circumference" id="hip_circumference">
                                </div>

                                <div class="form-group">
                                    <label for="chest_circumference"><?php echo _l('dpt_chest_circumference'); ?> (cm)</label>
                                    <input type="number" step="0.1" class="form-control" name="chest_circumference" id="chest_circumference">
                                </div>

                                <div class="form-group">
                                    <label for="arm_circumference"><?php echo _l('dpt_arm_circumference'); ?> (cm)</label>
                                    <input type="number" step="0.1" class="form-control" name="arm_circumference" id="arm_circumference">
                                </div>

                                <div class="form-group">
                                    <label for="thigh_circumference"><?php echo _l('dpt_thigh_circumference'); ?> (cm)</label>
                                    <input type="number" step="0.1" class="form-control" name="thigh_circumference" id="thigh_circumference">
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="notes"><?php echo _l('dpt_notes'); ?></label>
                            <textarea class="form-control" name="notes" id="notes" rows="3"></textarea>
                        </div>

                        <div class="btn-bottom-toolbar text-right">
                            <a href="<?php echo admin_url('dietician_patient_tracking/patient/' . $patient->id); ?>" class="btn btn-default">
                                <?php echo _l('cancel'); ?>
                            </a>
                            <button type="submit" class="btn btn-info">
                                <?php echo _l('save'); ?>
                            </button>
                        </div>

                        <?php echo form_close(); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php init_tail(); ?>
