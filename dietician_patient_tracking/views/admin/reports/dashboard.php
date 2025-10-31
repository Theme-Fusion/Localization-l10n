<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head(); ?>

<div id="wrapper">
    <div class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="panel_s">
                    <div class="panel-body">
                        <h4 class="no-margin">
                            <i class="fa fa-bar-chart"></i> <?php echo _l('dpt_reports'); ?>
                        </h4>
                        <hr class="hr-panel-heading" />

                        <!-- Filter -->
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="patient_select"><?php echo _l('dpt_select_patient'); ?></label>
                                    <select name="patient_id" id="patient_select" class="selectpicker" data-live-search="true" data-width="100%"
                                        onchange="if(this.value) window.location.href='<?php echo admin_url('dietician_patient_tracking/reports?patient_id='); ?>'+this.value;">
                                        <option value=""><?php echo _l('select'); ?></option>
                                        <?php foreach ($patients as $p) : ?>
                                            <option value="<?php echo $p->id; ?>" <?php echo isset($selected_patient) && $selected_patient->id == $p->id ? 'selected' : ''; ?>>
                                                <?php echo $p->firstname . ' ' . $p->lastname; ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <?php if (isset($selected_patient)) : ?>
                            <hr />

                            <!-- Patient Statistics -->
                            <h4><?php echo $selected_patient->firstname . ' ' . $selected_patient->lastname; ?></h4>

                            <div class="row mtop20">
                                <div class="col-md-3">
                                    <div class="dpt-stat-card">
                                        <h3><?php echo _l('dpt_total_consultations'); ?></h3>
                                        <div class="stat-value"><?php echo $statistics['total_consultations']; ?></div>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="dpt-stat-card">
                                        <h3><?php echo _l('dpt_active_goals'); ?></h3>
                                        <div class="stat-value"><?php echo $statistics['active_goals']; ?></div>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="dpt-stat-card">
                                        <h3><?php echo _l('dpt_completed_goals'); ?></h3>
                                        <div class="stat-value"><?php echo $statistics['completed_goals']; ?></div>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="dpt-stat-card" style="border-left-color: <?php echo $statistics['weight_change'] < 0 ? '#28a745' : '#dc3545'; ?>">
                                        <h3><?php echo _l('dpt_weight_change'); ?></h3>
                                        <div class="stat-value"><?php echo $statistics['weight_change']; ?> kg</div>
                                    </div>
                                </div>
                            </div>

                            <!-- Weight Chart -->
                            <?php if (!empty($measurements)) : ?>
                                <div class="row mtop30">
                                    <div class="col-md-12">
                                        <h4><?php echo _l('dpt_weight_progress'); ?></h4>
                                        <div class="dpt-chart-container mtop15">
                                            <?php
                                            $chart_labels = [];
                                            $chart_values = [];
                                            foreach (array_reverse($measurements) as $m) {
                                                $chart_labels[] = date('d/m/Y', strtotime($m->measurement_date));
                                                $chart_values[] = (float)$m->weight;
                                            }
                                            ?>
                                            <canvas id="weight-chart" data-chart='<?php echo json_encode(['labels' => $chart_labels, 'values' => $chart_values]); ?>' height="80"></canvas>
                                        </div>
                                    </div>
                                </div>
                            <?php endif; ?>

                            <!-- Recent Activity -->
                            <div class="row mtop30">
                                <div class="col-md-6">
                                    <h4><?php echo _l('dpt_recent_consultations'); ?></h4>
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th><?php echo _l('dpt_date'); ?></th>
                                                <th><?php echo _l('dpt_type'); ?></th>
                                                <th><?php echo _l('dpt_status'); ?></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if (!empty($consultations)) : ?>
                                                <?php foreach (array_slice($consultations, 0, 10) as $c) : ?>
                                                    <tr>
                                                        <td><?php echo date('d/m/Y', strtotime($c->consultation_date)); ?></td>
                                                        <td><?php echo _l('dpt_consultation_' . $c->consultation_type); ?></td>
                                                        <td><span class="label label-<?php echo $c->status == 'completed' ? 'success' : 'default'; ?>"><?php echo _l('dpt_' . $c->status); ?></span></td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            <?php else : ?>
                                                <tr>
                                                    <td colspan="3" class="text-center"><?php echo _l('dpt_no_consultations'); ?></td>
                                                </tr>
                                            <?php endif; ?>
                                        </tbody>
                                    </table>
                                </div>

                                <div class="col-md-6">
                                    <h4><?php echo _l('dpt_goals'); ?></h4>
                                    <?php if (!empty($goals)) : ?>
                                        <?php foreach (array_slice($goals, 0, 5) as $goal) : ?>
                                            <div class="dpt-goal-card">
                                                <div class="dpt-goal-header">
                                                    <div class="dpt-goal-title"><?php echo $goal->title; ?></div>
                                                    <span class="dpt-goal-priority <?php echo $goal->priority; ?>"><?php echo _l('dpt_' . $goal->priority); ?></span>
                                                </div>
                                                <div class="dpt-goal-progress-bar">
                                                    <div class="dpt-goal-progress-fill" style="width: <?php echo $goal->completion_percentage; ?>%">
                                                        <?php echo $goal->completion_percentage; ?>%
                                                    </div>
                                                </div>
                                            </div>
                                        <?php endforeach; ?>
                                    <?php else : ?>
                                        <p><?php echo _l('dpt_no_goals'); ?></p>
                                    <?php endif; ?>
                                </div>
                            </div>

                        <?php else : ?>
                            <div class="text-center mtop40 mbottom40">
                                <i class="fa fa-user fa-5x" style="opacity: 0.3;"></i>
                                <h4 class="mtop20"><?php echo _l('dpt_select_patient_to_view_report'); ?></h4>
                            </div>
                        <?php endif; ?>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php init_tail(); ?>
