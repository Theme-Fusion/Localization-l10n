<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head(); ?>

<div id="wrapper">
    <div class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="panel_s">
                    <div class="panel-body">
                        <h4>
                            <?php echo _l('dpt_anamnesis'); ?> - <?php echo $patient->firstname . ' ' . $patient->lastname; ?>
                        </h4>
                        <hr class="hr-panel-heading" />

                        <div class="_buttons">
                            <a href="<?php echo admin_url('dietician_patient_tracking/anamnesis_form/' . $patient->id); ?>" class="btn btn-primary">
                                <i class="fa fa-plus"></i>
                                <?php echo _l('dpt_create_anamnesis'); ?>
                            </a>
                            <a href="<?php echo admin_url('dietician_patient_tracking/patient/' . $patient->id); ?>" class="btn btn-default">
                                <i class="fa fa-arrow-left"></i>
                                <?php echo _l('dpt_back'); ?>
                            </a>
                        </div>

                        <div class="clearfix mtop15"></div>

                        <?php if (!empty($anamnesis_list)): ?>
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th><?php echo _l('dpt_date'); ?></th>
                                            <th><?php echo _l('dpt_main_objective'); ?></th>
                                            <th><?php echo _l('dpt_chronic_conditions'); ?></th>
                                            <th><?php echo _l('dpt_allergies'); ?></th>
                                            <th><?php echo _l('dpt_motivation_level'); ?></th>
                                            <th><?php echo _l('options'); ?></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($anamnesis_list as $anam): ?>
                                            <tr>
                                                <td><?php echo _dt($anam->created_at); ?></td>
                                                <td><?php echo character_limiter($anam->main_objective ?? '-', 50); ?></td>
                                                <td><?php echo character_limiter($anam->chronic_conditions ?? '-', 50); ?></td>
                                                <td><?php echo character_limiter($anam->allergies ?? '-', 50); ?></td>
                                                <td>
                                                    <?php
                                                    $motivation = $anam->motivation_level ?? 5;
                                                    $color = $motivation >= 7 ? 'success' : ($motivation >= 4 ? 'warning' : 'danger');
                                                    ?>
                                                    <span class="label label-<?php echo $color; ?>"><?php echo $motivation; ?>/10</span>
                                                </td>
                                                <td>
                                                    <a href="<?php echo admin_url('dietician_patient_tracking/anamnesis_form/' . $patient->id . '/' . $anam->id); ?>" class="btn btn-default btn-sm">
                                                        <i class="fa fa-edit"></i>
                                                    </a>
                                                    <?php if ($anam->pdf_attachment): ?>
                                                        <a href="<?php echo site_url($anam->pdf_attachment); ?>" target="_blank" class="btn btn-info btn-sm">
                                                            <i class="fa fa-file-pdf-o"></i>
                                                        </a>
                                                    <?php endif; ?>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php else: ?>
                            <div class="alert alert-info">
                                <i class="fa fa-info-circle"></i>
                                <?php echo _l('no_data_found'); ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php init_tail(); ?>

</body>
</html>
