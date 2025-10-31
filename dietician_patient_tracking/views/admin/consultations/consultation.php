<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head(); ?>
<div id="wrapper">
    <div class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="panel_s">
                    <div class="panel-body">
                        <h4><?php echo isset($consultation) ? _l('dpt_edit_consultation') : _l('dpt_add_consultation'); ?></h4>
                        <hr />
                        <?php echo form_open(admin_url('dietician_patient_tracking/consultation' . (isset($consultation) ? '/' . $consultation->id : '')), ['id' => 'consultation-form']); ?>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label><?php echo _l('dpt_patient'); ?> *</label>
                                    <select name="patient_id" class="selectpicker" data-live-search="true" data-width="100%" required>
                                        <?php foreach ($patients as $p) : ?>
                                            <option value="<?php echo $p->id; ?>" <?php echo (isset($consultation) && $consultation->patient_id == $p->id) ? 'selected' : ''; ?>>
                                                <?php echo $p->firstname . ' ' . $p->lastname; ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label><?php echo _l('dpt_consultation_date'); ?> *</label>
                                    <input type="datetime-local" class="form-control" name="consultation_date" 
                                        value="<?php echo isset($consultation) ? date('Y-m-d\TH:i', strtotime($consultation->consultation_date)) : ''; ?>" required>
                                </div>
                                <div class="form-group">
                                    <label><?php echo _l('dpt_consultation_type'); ?></label>
                                    <select name="consultation_type" class="selectpicker" data-width="100%">
                                        <?php foreach ($consultation_types as $key => $label) : ?>
                                            <option value="<?php echo $key; ?>" <?php echo (isset($consultation) && $consultation->consultation_type == $key) ? 'selected' : ''; ?>><?php echo $label; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label><?php echo _l('dpt_subject'); ?></label>
                                    <input type="text" class="form-control" name="subject" value="<?php echo isset($consultation) ? $consultation->subject : ''; ?>">
                                </div>
                                <div class="form-group">
                                    <label><?php echo _l('dpt_duration'); ?> (min)</label>
                                    <input type="number" class="form-control" name="duration" value="<?php echo isset($consultation) ? $consultation->duration : '60'; ?>">
                                </div>
                                <div class="form-group">
                                    <label><?php echo _l('dpt_status'); ?></label>
                                    <select name="status" class="selectpicker" data-width="100%">
                                        <option value="scheduled" <?php echo (isset($consultation) && $consultation->status == 'scheduled') ? 'selected' : ''; ?>><?php echo _l('dpt_scheduled'); ?></option>
                                        <option value="completed" <?php echo (isset($consultation) && $consultation->status == 'completed') ? 'selected' : ''; ?>><?php echo _l('dpt_completed'); ?></option>
                                        <option value="cancelled" <?php echo (isset($consultation) && $consultation->status == 'cancelled') ? 'selected' : ''; ?>><?php echo _l('dpt_cancelled'); ?></option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label><?php echo _l('dpt_anamnesis'); ?></label>
                            <textarea class="form-control" name="anamnesis" rows="4"><?php echo isset($consultation) ? $consultation->anamnesis : ''; ?></textarea>
                        </div>
                        <div class="form-group">
                            <label><?php echo _l('dpt_diagnosis'); ?></label>
                            <textarea class="form-control" name="diagnosis" rows="3"><?php echo isset($consultation) ? $consultation->diagnosis : ''; ?></textarea>
                        </div>
                        <div class="form-group">
                            <label><?php echo _l('dpt_recommendations'); ?></label>
                            <textarea class="form-control" name="recommendations" rows="3"><?php echo isset($consultation) ? $consultation->recommendations : ''; ?></textarea>
                        </div>
                        <div class="btn-bottom-toolbar text-right">
                            <a href="<?php echo admin_url('dietician_patient_tracking/consultations'); ?>" class="btn btn-default"><?php echo _l('cancel'); ?></a>
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
