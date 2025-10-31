<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<div class="dpt-client-dashboard">
    <div class="dpt-client-welcome">
        <h1><?php echo _l('welcome'); ?>, <?php echo get_contact_full_name(get_contact_user_id()); ?>!</h1>
        <p><?php echo _l('dpt_my_tracking'); ?></p>
    </div>

    <?php if (isset($latest_measurement)) : ?>
        <div class="dpt-current-status">
            <h3><?php echo _l('dpt_current_status'); ?></h3>
            <div class="dpt-status-grid">
                <div class="dpt-status-item">
                    <div class="dpt-status-value"><?php echo $latest_measurement->weight; ?></div>
                    <div class="dpt-status-label"><?php echo _l('dpt_weight'); ?> (kg)</div>
                </div>
                <?php if (isset($current_bmi)) : ?>
                    <div class="dpt-status-item">
                        <div class="dpt-status-value"><?php echo number_format($current_bmi, 2); ?></div>
                        <div class="dpt-status-label"><?php echo _l('dpt_bmi'); ?></div>
                        <div class="dpt-biometric-category"><?php echo $bmi_category; ?></div>
                    </div>
                <?php endif; ?>
                <?php if (isset($tdee)) : ?>
                    <div class="dpt-status-item">
                        <div class="dpt-status-value"><?php echo $tdee; ?></div>
                        <div class="dpt-status-label"><?php echo _l('dpt_tdee'); ?> (kcal)</div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    <?php endif; ?>

    <div class="row mtop20">
        <div class="col-md-3 col-sm-6">
            <a href="<?php echo site_url('dietician_patient_tracking/client/measurements'); ?>" class="dpt-quick-action-btn">
                <i class="fa fa-plus-circle dpt-quick-action-icon"></i>
                <div class="dpt-quick-action-label"><?php echo _l('dpt_add_measurement'); ?></div>
            </a>
        </div>
        <div class="col-md-3 col-sm-6">
            <a href="<?php echo site_url('dietician_patient_tracking/client/food_diary'); ?>" class="dpt-quick-action-btn">
                <i class="fa fa-book dpt-quick-action-icon"></i>
                <div class="dpt-quick-action-label"><?php echo _l('dpt_food_diary'); ?></div>
            </a>
        </div>
        <div class="col-md-3 col-sm-6">
            <a href="<?php echo site_url('dietician_patient_tracking/client/meal_plans'); ?>" class="dpt-quick-action-btn">
                <i class="fa fa-cutlery dpt-quick-action-icon"></i>
                <div class="dpt-quick-action-label"><?php echo _l('dpt_my_meal_plans'); ?></div>
            </a>
        </div>
        <div class="col-md-3 col-sm-6">
            <a href="<?php echo site_url('dietician_patient_tracking/client/goals'); ?>" class="dpt-quick-action-btn">
                <i class="fa fa-bullseye dpt-quick-action-icon"></i>
                <div class="dpt-quick-action-label"><?php echo _l('dpt_my_goals'); ?></div>
            </a>
        </div>
    </div>

    <?php if (!empty($active_goals)) : ?>
        <div class="dpt-progress-overview mtop30">
            <h3><?php echo _l('dpt_active_goals'); ?></h3>
            <?php foreach (array_slice($active_goals, 0, 3) as $goal) : ?>
                <div class="dpt-progress-item">
                    <div class="dpt-progress-header">
                        <span class="dpt-progress-title"><?php echo $goal->title; ?></span>
                        <span class="dpt-progress-percentage"><?php echo $goal->completion_percentage; ?>%</span>
                    </div>
                    <div class="dpt-progress-bar-container">
                        <div class="dpt-progress-bar-fill client-goal-progress" data-progress="<?php echo $goal->completion_percentage; ?>" style="width: 0%"></div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <?php if (!empty($upcoming_consultations)) : ?>
        <div class="dpt-upcoming-events mtop30">
            <h3><?php echo _l('dpt_upcoming_consultations'); ?></h3>
            <?php foreach (array_slice($upcoming_consultations, 0, 3) as $consultation) : ?>
                <div class="dpt-event-item">
                    <div class="dpt-event-date">
                        <div class="dpt-event-day"><?php echo date('d', strtotime($consultation->consultation_date)); ?></div>
                        <div class="dpt-event-month"><?php echo date('M', strtotime($consultation->consultation_date)); ?></div>
                    </div>
                    <div class="dpt-event-details">
                        <div class="dpt-event-title"><?php echo $consultation->subject; ?></div>
                        <div class="dpt-event-time"><?php echo date('H:i', strtotime($consultation->consultation_date)); ?></div>
                        <span class="dpt-event-type"><?php echo _l('dpt_consultation_' . $consultation->consultation_type); ?></span>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>
