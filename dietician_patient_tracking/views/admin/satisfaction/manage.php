<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head(); ?>

<div id="wrapper">
    <div class="content">
        <div class="row">
            <!-- NPS Statistics -->
            <div class="col-md-12">
                <div class="panel_s">
                    <div class="panel-body">
                        <h4><?php echo _l('dpt_nps') . ' & ' . _l('dpt_satisfaction'); ?></h4>
                        <hr class="hr-panel-heading" />

                        <div class="row">
                            <div class="col-md-3 col-sm-6">
                                <div class="text-center">
                                    <h1 class="text-<?php echo $nps_score >= 50 ? 'success' : ($nps_score >= 0 ? 'warning' : 'danger'); ?>">
                                        <?php echo $nps_score; ?>
                                    </h1>
                                    <p class="text-muted"><strong><?php echo _l('dpt_nps'); ?></strong></p>
                                    <p class="text-muted">
                                        <small>
                                            <?php
                                            if ($nps_score >= 70) {
                                                echo 'Excellent';
                                            } elseif ($nps_score >= 50) {
                                                echo 'Très bon';
                                            } elseif ($nps_score >= 30) {
                                                echo 'Bon';
                                            } elseif ($nps_score >= 0) {
                                                echo 'Moyen';
                                            } else {
                                                echo 'Faible';
                                            }
                                            ?>
                                        </small>
                                    </p>
                                </div>
                            </div>

                            <div class="col-md-3 col-sm-6">
                                <div class="text-center">
                                    <h1 class="text-info"><?php echo $stats->total_surveys ?? 0; ?></h1>
                                    <p class="text-muted"><strong><?php echo _l('dpt_total'); ?> <?php echo _l('dpt_satisfaction_survey'); ?></strong></p>
                                    <p class="text-muted"><small><?php echo _l('all_time'); ?></small></p>
                                </div>
                            </div>

                            <div class="col-md-3 col-sm-6">
                                <div class="text-center">
                                    <h1 class="text-success">
                                        <?php echo $stats->promoters ?? 0; ?>
                                        <small>(<?php echo $stats->total_surveys > 0 ? round(($stats->promoters / $stats->total_surveys) * 100) : 0; ?>%)</small>
                                    </h1>
                                    <p class="text-muted"><strong>Promoteurs</strong></p>
                                    <p class="text-muted"><small>Score 9-10</small></p>
                                </div>
                            </div>

                            <div class="col-md-3 col-sm-6">
                                <div class="text-center">
                                    <h1 class="text-danger">
                                        <?php echo $stats->detractors ?? 0; ?>
                                        <small>(<?php echo $stats->total_surveys > 0 ? round(($stats->detractors / $stats->total_surveys) * 100) : 0; ?>%)</small>
                                    </h1>
                                    <p class="text-muted"><strong>Détracteurs</strong></p>
                                    <p class="text-muted"><small>Score 0-6</small></p>
                                </div>
                            </div>
                        </div>

                        <div class="row mtop25">
                            <div class="col-md-12">
                                <div class="alert alert-info">
                                    <i class="fa fa-info-circle"></i>
                                    <strong><?php echo _l('dpt_help'); ?>:</strong>
                                    Le Net Promoter Score (NPS) mesure la satisfaction et la fidélité des patients.
                                    <ul class="mtop10">
                                        <li><strong>NPS = % Promoteurs - % Détracteurs</strong></li>
                                        <li>Promoteurs (9-10): Patients très satisfaits qui recommandent vos services</li>
                                        <li>Passifs (7-8): Patients satisfaits mais non enthousiastes</li>
                                        <li>Détracteurs (0-6): Patients insatisfaits qui peuvent nuire à votre réputation</li>
                                        <li>Un NPS > 50 est considéré comme excellent</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Surveys List -->
            <div class="col-md-12">
                <div class="panel_s">
                    <div class="panel-body">
                        <h4><?php echo _l('dpt_satisfaction_survey'); ?></h4>
                        <hr class="hr-panel-heading" />

                        <?php render_datatable([
                            '#',
                            _l('dpt_patient'),
                            _l('dpt_consultation'),
                            _l('dpt_consultation_date'),
                            _l('dpt_nps'),
                            _l('dpt_overall_satisfaction'),
                            _l('dpt_survey_sent_at'),
                            _l('dpt_status'),
                            _l('options'),
                        ], 'satisfaction-surveys'); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php init_tail(); ?>

<script>
    $(function() {
        initDataTable('.table-satisfaction-surveys', window.location.href, [8], [8], {}, [0, 'desc']);
    });
</script>

</body>
</html>
