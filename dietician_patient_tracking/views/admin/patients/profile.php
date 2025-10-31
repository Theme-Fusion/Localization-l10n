<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head(); ?>

<div id="wrapper">
    <div class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="panel_s">
                    <div class="panel-body">
                        <h4 class="no-margin">
                            <?php echo isset($patient) ? _l('dpt_edit_patient') : _l('dpt_add_patient'); ?>
                        </h4>
                        <hr class="hr-panel-heading" />

                        <?php echo form_open(admin_url('dietician_patient_tracking/patient' . (isset($patient) ? '/' . $patient->id : '')), ['id' => 'patient-form']); ?>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="contact_id"><?php echo _l('dpt_contact'); ?> *</label>
                                    <select name="contact_id" id="contact_id" class="selectpicker" data-live-search="true" data-width="100%" required>
                                        <option value=""><?php echo _l('select'); ?></option>
                                        <?php foreach ($contacts as $contact) : ?>
                                            <option value="<?php echo $contact['id']; ?>"
                                                <?php echo (isset($patient) && $patient->contact_id == $contact['id']) ? 'selected' : ''; ?>>
                                                <?php echo $contact['firstname'] . ' ' . $contact['lastname'] . ' - ' . $contact['email']; ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="dietician_id"><?php echo _l('dpt_dietician'); ?> *</label>
                                    <select name="dietician_id" id="dietician_id" class="selectpicker" data-width="100%" required>
                                        <?php foreach ($staff_members as $staff) : ?>
                                            <option value="<?php echo $staff['staffid']; ?>"
                                                <?php echo (isset($patient) && $patient->dietician_id == $staff['staffid']) ? 'selected' : ''; ?>>
                                                <?php echo $staff['firstname'] . ' ' . $staff['lastname']; ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="date_of_birth"><?php echo _l('dpt_date_of_birth'); ?></label>
                                    <input type="date" class="form-control" name="date_of_birth" id="date_of_birth"
                                        value="<?php echo isset($patient) ? $patient->date_of_birth : ''; ?>">
                                </div>

                                <div class="form-group">
                                    <label for="gender"><?php echo _l('dpt_gender'); ?></label>
                                    <select name="gender" id="gender" class="selectpicker" data-width="100%">
                                        <option value="male" <?php echo (isset($patient) && $patient->gender == 'male') ? 'selected' : ''; ?>>
                                            <?php echo _l('dpt_male'); ?>
                                        </option>
                                        <option value="female" <?php echo (isset($patient) && $patient->gender == 'female') ? 'selected' : ''; ?>>
                                            <?php echo _l('dpt_female'); ?>
                                        </option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="height"><?php echo _l('dpt_height'); ?> (cm)</label>
                                    <input type="number" step="0.01" class="form-control" name="height" id="height"
                                        value="<?php echo isset($patient) ? $patient->height : ''; ?>">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="activity_level"><?php echo _l('dpt_activity_level'); ?></label>
                                    <select name="activity_level" id="activity_level" class="selectpicker" data-width="100%">
                                        <?php foreach ($activity_levels as $key => $label) : ?>
                                            <option value="<?php echo $key; ?>"
                                                <?php echo (isset($patient) && $patient->activity_level == $key) ? 'selected' : ''; ?>>
                                                <?php echo $label; ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="goal_type"><?php echo _l('dpt_goal_type'); ?></label>
                                    <select name="goal_type" id="goal_type" class="selectpicker" data-width="100%">
                                        <?php foreach ($goal_types as $key => $label) : ?>
                                            <option value="<?php echo $key; ?>"
                                                <?php echo (isset($patient) && $patient->goal_type == $key) ? 'selected' : ''; ?>>
                                                <?php echo $label; ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="target_weight"><?php echo _l('dpt_target_weight'); ?> (kg)</label>
                                    <input type="number" step="0.1" class="form-control" name="target_weight" id="target_weight"
                                        value="<?php echo isset($patient) ? $patient->target_weight : ''; ?>">
                                </div>

                                <div class="form-group">
                                    <label for="status"><?php echo _l('dpt_status'); ?></label>
                                    <select name="status" id="status" class="selectpicker" data-width="100%">
                                        <option value="active" <?php echo (isset($patient) && $patient->status == 'active') ? 'selected' : ''; ?>>
                                            <?php echo _l('dpt_active'); ?>
                                        </option>
                                        <option value="inactive" <?php echo (isset($patient) && $patient->status == 'inactive') ? 'selected' : ''; ?>>
                                            <?php echo _l('dpt_inactive'); ?>
                                        </option>
                                        <option value="completed" <?php echo (isset($patient) && $patient->status == 'completed') ? 'selected' : ''; ?>>
                                            <?php echo _l('dpt_completed'); ?>
                                        </option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="medical_history"><?php echo _l('dpt_medical_history'); ?></label>
                            <textarea class="form-control" name="medical_history" id="medical_history" rows="3"><?php echo isset($patient) ? $patient->medical_history : ''; ?></textarea>
                        </div>

                        <div class="form-group">
                            <label for="allergies"><?php echo _l('dpt_allergies'); ?></label>
                            <textarea class="form-control" name="allergies" id="allergies" rows="2"><?php echo isset($patient) ? $patient->allergies : ''; ?></textarea>
                        </div>

                        <div class="form-group">
                            <label for="dietary_restrictions"><?php echo _l('dpt_dietary_restrictions'); ?></label>
                            <textarea class="form-control" name="dietary_restrictions" id="dietary_restrictions" rows="2"><?php echo isset($patient) ? $patient->dietary_restrictions : ''; ?></textarea>
                        </div>

                        <div class="form-group">
                            <label for="notes"><?php echo _l('dpt_notes'); ?></label>
                            <textarea class="form-control" name="notes" id="notes" rows="3"><?php echo isset($patient) ? $patient->notes : ''; ?></textarea>
                        </div>

                        <div class="btn-bottom-toolbar text-right">
                            <a href="<?php echo admin_url('dietician_patient_tracking/patients'); ?>" class="btn btn-default">
                                <?php echo _l('cancel'); ?>
                            </a>
                            <button type="submit" class="btn btn-info">
                                <?php echo _l('save'); ?>
                            </button>
                        </div>

                        <?php echo form_close(); ?>

                        <?php if (isset($patient)) : ?>
                            <hr class="mtop40" />

                            <!-- Biometric Data -->
                            <?php if (isset($bmi)) : ?>
                                <h4 class="mtop20"><?php echo _l('dpt_biometric_data'); ?></h4>
                                <div class="dpt-biometric-grid mtop15">
                                    <div class="dpt-biometric-card bmi-<?php echo $this->dietician_patient_tracking_model->get_bmi_category($bmi); ?>">
                                        <div class="dpt-biometric-label"><?php echo _l('dpt_bmi'); ?></div>
                                        <div class="dpt-biometric-value"><?php echo number_format($bmi, 2); ?></div>
                                        <div class="dpt-biometric-category"><?php echo $bmi_category; ?></div>
                                    </div>

                                    <?php if (isset($bmr)) : ?>
                                        <div class="dpt-biometric-card">
                                            <div class="dpt-biometric-label"><?php echo _l('dpt_bmr'); ?></div>
                                            <div class="dpt-biometric-value"><?php echo $bmr; ?></div>
                                            <small>kcal/day</small>
                                        </div>

                                        <div class="dpt-biometric-card">
                                            <div class="dpt-biometric-label"><?php echo _l('dpt_tdee'); ?></div>
                                            <div class="dpt-biometric-value"><?php echo $tdee; ?></div>
                                            <small>kcal/day</small>
                                        </div>
                                    <?php endif; ?>

                                    <?php if (isset($whr)) : ?>
                                        <div class="dpt-biometric-card">
                                            <div class="dpt-biometric-label"><?php echo _l('dpt_whr'); ?></div>
                                            <div class="dpt-biometric-value"><?php echo number_format($whr, 2); ?></div>
                                            <small><?php echo $whr_risk; ?></small>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            <?php endif; ?>

                            <!-- Weight Chart -->
                            <?php if (isset($weight_chart_data) && !empty($weight_chart_data['labels'])) : ?>
                                <h4 class="mtop40"><?php echo _l('dpt_weight_progress'); ?></h4>
                                <div class="dpt-chart-container mtop15">
                                    <canvas id="weight-chart" data-chart='<?php echo json_encode($weight_chart_data); ?>' height="80"></canvas>
                                </div>
                            <?php endif; ?>

                            <!-- Measurements Table -->
                            <h4 class="mtop40"><?php echo _l('dpt_measurements'); ?></h4>
                            <button type="button" class="btn btn-success btn-sm mtop10" id="add-measurement-btn">
                                <i class="fa fa-plus"></i> <?php echo _l('dpt_add_measurement'); ?>
                            </button>
                            <div class="table-responsive mtop15">
                                <table class="table table-striped dpt-measurements-table">
                                    <thead>
                                        <tr>
                                            <th><?php echo _l('dpt_date'); ?></th>
                                            <th><?php echo _l('dpt_weight'); ?></th>
                                            <th><?php echo _l('dpt_body_fat_percentage'); ?></th>
                                            <th><?php echo _l('dpt_waist_circumference'); ?></th>
                                            <th><?php echo _l('dpt_hip_circumference'); ?></th>
                                            <th><?php echo _l('options'); ?></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if (!empty($measurements)) : ?>
                                            <?php foreach ($measurements as $measurement) : ?>
                                                <tr>
                                                    <td><?php echo date('d/m/Y', strtotime($measurement->measurement_date)); ?></td>
                                                    <td><?php echo $measurement->weight ? $measurement->weight . ' kg' : '-'; ?></td>
                                                    <td><?php echo $measurement->body_fat_percentage ? $measurement->body_fat_percentage . ' %' : '-'; ?></td>
                                                    <td><?php echo $measurement->waist_circumference ? $measurement->waist_circumference . ' cm' : '-'; ?></td>
                                                    <td><?php echo $measurement->hip_circumference ? $measurement->hip_circumference . ' cm' : '-'; ?></td>
                                                    <td>
                                                        <a href="<?php echo admin_url('dietician_patient_tracking/delete_measurement/' . $measurement->id); ?>"
                                                           class="btn btn-danger btn-xs dpt-delete-btn" data-type="measurement">
                                                            <i class="fa fa-trash"></i>
                                                        </a>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        <?php else : ?>
                                            <tr>
                                                <td colspan="6" class="text-center"><?php echo _l('dpt_no_measurements'); ?></td>
                                            </tr>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>

                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Add Measurement Modal -->
<?php if (isset($patient)) : ?>
<div id="measurement-modal" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title"><?php echo _l('dpt_add_measurement'); ?></h4>
            </div>
            <?php echo form_open(admin_url('dietician_patient_tracking/add_measurement/' . $patient->id), ['id' => 'measurement-form']); ?>
            <div class="modal-body">
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
                        </div>
                        <div class="form-group">
                            <label for="body_fat_percentage"><?php echo _l('dpt_body_fat_percentage'); ?> (%)</label>
                            <input type="number" step="0.1" class="form-control" name="body_fat_percentage" id="body_fat_percentage">
                        </div>
                        <div class="form-group">
                            <label for="muscle_mass"><?php echo _l('dpt_muscle_mass'); ?> (kg)</label>
                            <input type="number" step="0.1" class="form-control" name="muscle_mass" id="muscle_mass">
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
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="notes"><?php echo _l('dpt_notes'); ?></label>
                            <textarea class="form-control" name="notes" id="notes" rows="2"></textarea>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo _l('close'); ?></button>
                <button type="submit" class="btn btn-info"><?php echo _l('save'); ?></button>
            </div>
            <?php echo form_close(); ?>
        </div>
    </div>
</div>
<?php endif; ?>

<?php init_tail(); ?>
