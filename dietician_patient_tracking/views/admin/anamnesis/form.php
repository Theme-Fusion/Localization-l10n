<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head(); ?>

<div id="wrapper">
    <div class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="panel_s">
                    <div class="panel-body">
                        <h4 class="no-margin">
                            <?php echo $title; ?> - <?php echo $patient->firstname . ' ' . $patient->lastname; ?>
                        </h4>
                        <hr class="hr-panel-heading" />

                        <?php echo form_open_multipart(admin_url('dietician_patient_tracking/anamnesis_form/' . $patient->id . '/' . (isset($anamnesis) ? $anamnesis->id : '')), ['id' => 'anamnesis-form']); ?>

                        <!-- Consultation Link -->
                        <div class="row">
                            <div class="col-md-12">
                                <?php
                                $consultation_options = [];
                                foreach ($consultations as $cons) {
                                    $consultation_options[] = ['id' => $cons->id, 'name' => $cons->subject . ' (' . _d($cons->consultation_date) . ')'];
                                }
                                $selected = isset($anamnesis) ? $anamnesis->consultation_id : '';
                                echo render_select('consultation_id', $consultation_options, ['id', 'name'], 'dpt_consultation', $selected);
                                ?>
                            </div>
                        </div>

                        <!-- Medical History -->
                        <h4 class="mtop25"><i class="fa fa-heartbeat"></i> <?php echo _l('dpt_medical_history'); ?></h4>
                        <hr />

                        <div class="row">
                            <div class="col-md-6">
                                <?php echo render_textarea('medical_history', 'dpt_medical_history', isset($anamnesis) ? $anamnesis->medical_history : '', ['rows' => 4]); ?>
                            </div>
                            <div class="col-md-6">
                                <?php echo render_textarea('current_medications', 'dpt_current_medications', isset($anamnesis) ? $anamnesis->current_medications : '', ['rows' => 4]); ?>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <?php echo render_textarea('allergies', 'dpt_allergies', isset($anamnesis) ? $anamnesis->allergies : '', ['rows' => 3]); ?>
                            </div>
                            <div class="col-md-6">
                                <?php echo render_textarea('food_intolerances', 'dpt_food_intolerances', isset($anamnesis) ? $anamnesis->food_intolerances : '', ['rows' => 3]); ?>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <?php echo render_textarea('chronic_conditions', 'dpt_chronic_conditions', isset($anamnesis) ? $anamnesis->chronic_conditions : '', ['rows' => 3]); ?>
                            </div>
                            <div class="col-md-6">
                                <?php echo render_textarea('family_history', 'dpt_family_history', isset($anamnesis) ? $anamnesis->family_history : '', ['rows' => 3]); ?>
                            </div>
                        </div>

                        <!-- Lifestyle -->
                        <h4 class="mtop25"><i class="fa fa-home"></i> <?php echo _l('dpt_lifestyle_habits'); ?></h4>
                        <hr />

                        <div class="row">
                            <div class="col-md-4">
                                <?php echo render_textarea('lifestyle_habits', 'dpt_lifestyle_habits', isset($anamnesis) ? $anamnesis->lifestyle_habits : '', ['rows' => 4, 'placeholder' => 'Tabac, alcool, drogues...']); ?>
                            </div>
                            <div class="col-md-4">
                                <?php echo render_textarea('eating_habits', 'dpt_eating_habits', isset($anamnesis) ? $anamnesis->eating_habits : '', ['rows' => 4]); ?>
                            </div>
                            <div class="col-md-4">
                                <?php echo render_textarea('physical_activity', 'dpt_physical_activity', isset($anamnesis) ? $anamnesis->physical_activity : '', ['rows' => 4]); ?>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <?php
                                $stress_levels = [
                                    ['id' => 'low', 'name' => _l('dpt_stress_low')],
                                    ['id' => 'moderate', 'name' => _l('dpt_stress_moderate')],
                                    ['id' => 'high', 'name' => _l('dpt_stress_high')],
                                    ['id' => 'very_high', 'name' => _l('dpt_stress_very_high')],
                                ];
                                $selected = isset($anamnesis) ? $anamnesis->stress_level : 'moderate';
                                echo render_select('stress_level', $stress_levels, ['id', 'name'], 'dpt_stress_level', $selected);
                                ?>
                            </div>

                            <div class="col-md-4">
                                <?php
                                $sleep_qualities = [
                                    ['id' => 'poor', 'name' => _l('dpt_sleep_poor')],
                                    ['id' => 'fair', 'name' => _l('dpt_sleep_fair')],
                                    ['id' => 'good', 'name' => _l('dpt_sleep_good')],
                                    ['id' => 'excellent', 'name' => _l('dpt_sleep_excellent')],
                                ];
                                $selected = isset($anamnesis) ? $anamnesis->sleep_quality : 'fair';
                                echo render_select('sleep_quality', $sleep_qualities, ['id', 'name'], 'dpt_sleep_quality', $selected);
                                ?>
                            </div>

                            <div class="col-md-4">
                                <?php echo render_input('motivation_level', 'dpt_motivation_level', isset($anamnesis) ? $anamnesis->motivation_level : 5, 'number', ['min' => 1, 'max' => 10]); ?>
                                <small class="text-muted">1-10 (1 = très faible, 10 = très élevé)</small>
                            </div>
                        </div>

                        <!-- Objectives -->
                        <h4 class="mtop25"><i class="fa fa-bullseye"></i> <?php echo _l('dpt_goals_objectives'); ?></h4>
                        <hr />

                        <div class="row">
                            <div class="col-md-6">
                                <?php echo render_textarea('main_objective', 'dpt_main_objective', isset($anamnesis) ? $anamnesis->main_objective : '', ['rows' => 4]); ?>
                            </div>
                            <div class="col-md-6">
                                <?php echo render_textarea('secondary_objectives', 'dpt_secondary_objectives', isset($anamnesis) ? $anamnesis->secondary_objectives : '', ['rows' => 4]); ?>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <?php echo render_textarea('obstacles', 'dpt_obstacles', isset($anamnesis) ? $anamnesis->obstacles : '', ['rows' => 4]); ?>
                            </div>
                            <div class="col-md-6">
                                <?php echo render_textarea('support_system', 'dpt_support_system', isset($anamnesis) ? $anamnesis->support_system : '', ['rows' => 4]); ?>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <?php echo render_textarea('previous_diets', 'dpt_previous_diets', isset($anamnesis) ? $anamnesis->previous_diets : '', ['rows' => 3]); ?>
                            </div>
                        </div>

                        <!-- Preferences & Constraints -->
                        <h4 class="mtop25"><i class="fa fa-cog"></i> <?php echo _l('dpt_preferences'); ?> & <?php echo _l('dpt_budget_constraints'); ?></h4>
                        <hr />

                        <div class="row">
                            <div class="col-md-12">
                                <?php echo render_textarea('preferences', 'dpt_preferences', isset($anamnesis) ? $anamnesis->preferences : '', ['rows' => 3, 'placeholder' => 'Aliments aimés, détestés, préférences culturelles...']); ?>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <?php
                                $budgets = [
                                    ['id' => 'low', 'name' => _l('dpt_budget_low')],
                                    ['id' => 'medium', 'name' => _l('dpt_medium')],
                                    ['id' => 'high', 'name' => _l('dpt_high')],
                                    ['id' => 'unlimited', 'name' => _l('dpt_budget_unlimited')],
                                ];
                                $selected = isset($anamnesis) ? $anamnesis->budget_constraints : 'medium';
                                echo render_select('budget_constraints', $budgets, ['id', 'name'], 'dpt_budget_constraints', $selected);
                                ?>
                            </div>

                            <div class="col-md-4">
                                <?php
                                $skills = [
                                    ['id' => 'beginner', 'name' => _l('dpt_cooking_beginner')],
                                    ['id' => 'intermediate', 'name' => _l('dpt_cooking_intermediate')],
                                    ['id' => 'advanced', 'name' => _l('dpt_cooking_advanced')],
                                    ['id' => 'expert', 'name' => _l('dpt_cooking_expert')],
                                ];
                                $selected = isset($anamnesis) ? $anamnesis->cooking_skills : 'intermediate';
                                echo render_select('cooking_skills', $skills, ['id', 'name'], 'dpt_cooking_skills', $selected);
                                ?>
                            </div>

                            <div class="col-md-4">
                                <?php echo render_input('meal_prep_time', 'dpt_meal_prep_time', isset($anamnesis) ? $anamnesis->meal_prep_time : '', 'number'); ?>
                                <small class="text-muted"><?php echo _l('dpt_minutes'); ?> par jour</small>
                            </div>
                        </div>

                        <!-- Notes & Attachments -->
                        <h4 class="mtop25"><i class="fa fa-file-text-o"></i> <?php echo _l('dpt_notes'); ?> & <?php echo _l('dpt_attachments'); ?></h4>
                        <hr />

                        <div class="row">
                            <div class="col-md-12">
                                <?php echo render_textarea('notes', 'dpt_notes', isset($anamnesis) ? $anamnesis->notes : '', ['rows' => 5]); ?>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="pdf_attachment"><?php echo _l('dpt_anamnesis_file'); ?> (PDF, DOC, DOCX)</label>
                                    <input type="file" name="pdf_attachment" id="pdf_attachment" class="form-control" accept=".pdf,.doc,.docx">
                                    <?php if (isset($anamnesis) && $anamnesis->pdf_attachment): ?>
                                        <p class="mtop10">
                                            <i class="fa fa-file-pdf-o"></i>
                                            <a href="<?php echo site_url($anamnesis->pdf_attachment); ?>" target="_blank">
                                                <?php echo basename($anamnesis->pdf_attachment); ?>
                                            </a>
                                        </p>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary mtop15">
                            <i class="fa fa-check"></i>
                            <?php echo _l('submit'); ?>
                        </button>
                        <a href="<?php echo admin_url('dietician_patient_tracking/anamnesis/' . $patient->id); ?>" class="btn btn-default mtop15">
                            <?php echo _l('dpt_back'); ?>
                        </a>

                        <?php echo form_close(); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php init_tail(); ?>

</body>
</html>
