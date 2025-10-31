<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head(); ?>

<div id="wrapper">
    <div class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="panel_s">
                    <div class="panel-body">
                        <h4 class="no-margin">
                            <i class="fa fa-heartbeat"></i> <?php echo _l('dpt_dashboard'); ?>
                        </h4>
                        <hr class="hr-panel-heading" />

                        <!-- Statistics Cards -->
                        <div class="row">
                            <div class="col-md-3 col-sm-6">
                                <div class="dpt-stat-card" style="border-left-color: #28a745;">
                                    <h3><?php echo _l('dpt_total_patients'); ?></h3>
                                    <div class="stat-value"><?php echo $total_patients; ?></div>
                                    <div class="stat-label"><?php echo _l('dpt_active'); ?></div>
                                </div>
                            </div>

                            <div class="col-md-3 col-sm-6">
                                <div class="dpt-stat-card" style="border-left-color: #17a2b8;">
                                    <h3><?php echo _l('dpt_total_consultations'); ?></h3>
                                    <div class="stat-value"><?php echo $total_consultations; ?></div>
                                    <div class="stat-label"><?php echo _l('dpt_all_time'); ?></div>
                                </div>
                            </div>

                            <div class="col-md-3 col-sm-6">
                                <div class="dpt-stat-card" style="border-left-color: #ffc107;">
                                    <h3><?php echo _l('dpt_upcoming_consultations'); ?></h3>
                                    <div class="stat-value"><?php echo $upcoming_consultations; ?></div>
                                    <div class="stat-label"><?php echo _l('dpt_next_7_days'); ?></div>
                                </div>
                            </div>

                            <div class="col-md-3 col-sm-6">
                                <div class="dpt-stat-card" style="border-left-color: #667eea;">
                                    <h3><?php echo _l('dpt_active_meal_plans'); ?></h3>
                                    <div class="stat-value">0</div>
                                    <div class="stat-label"><?php echo _l('dpt_active'); ?></div>
                                </div>
                            </div>
                        </div>

                        <hr />

                        <!-- Recent Patients -->
                        <div class="row mtop20">
                            <div class="col-md-6">
                                <h4><?php echo _l('dpt_recent_activity'); ?></h4>
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th><?php echo _l('dpt_patient'); ?></th>
                                                <th><?php echo _l('dpt_dietician'); ?></th>
                                                <th><?php echo _l('dpt_status'); ?></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if (!empty($recent_patients)) : ?>
                                                <?php foreach ($recent_patients as $patient) : ?>
                                                    <tr>
                                                        <td>
                                                            <a href="<?php echo admin_url('dietician_patient_tracking/patient/' . $patient->id); ?>">
                                                                <?php echo $patient->firstname . ' ' . $patient->lastname; ?>
                                                            </a>
                                                        </td>
                                                        <td><?php echo $patient->dietician_firstname . ' ' . $patient->dietician_lastname; ?></td>
                                                        <td>
                                                            <span class="label label-<?php echo $patient->status == 'active' ? 'success' : 'default'; ?>">
                                                                <?php echo _l('dpt_' . $patient->status); ?>
                                                            </span>
                                                        </td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            <?php else : ?>
                                                <tr>
                                                    <td colspan="3" class="text-center"><?php echo _l('dpt_no_patients'); ?></td>
                                                </tr>
                                            <?php endif; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <!-- Upcoming Consultations -->
                            <div class="col-md-6">
                                <h4><?php echo _l('dpt_upcoming_events'); ?></h4>
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th><?php echo _l('dpt_date'); ?></th>
                                                <th><?php echo _l('dpt_patient'); ?></th>
                                                <th><?php echo _l('dpt_type'); ?></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if (!empty($consultations)) : ?>
                                                <?php foreach (array_slice($consultations, 0, 10) as $consultation) : ?>
                                                    <tr>
                                                        <td><?php echo date('d/m/Y H:i', strtotime($consultation->consultation_date)); ?></td>
                                                        <td>
                                                            <a href="<?php echo admin_url('dietician_patient_tracking/consultation/' . $consultation->id); ?>">
                                                                <?php echo $consultation->firstname . ' ' . $consultation->lastname; ?>
                                                            </a>
                                                        </td>
                                                        <td>
                                                            <span class="label label-info">
                                                                <?php echo _l('dpt_consultation_' . $consultation->consultation_type); ?>
                                                            </span>
                                                        </td>
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
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php init_tail(); ?>
