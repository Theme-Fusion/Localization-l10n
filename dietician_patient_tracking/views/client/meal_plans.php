<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<div class="panel_s">
    <div class="panel-body">
        <h4><?php echo _l('dpt_my_meal_plans'); ?></h4>
        <hr />
        <?php if (!empty($meal_plans)) : ?>
            <?php foreach ($meal_plans as $plan) : ?>
                <div class="dpt-meal-plan-day">
                    <h5><?php echo $plan->name; ?></h5>
                    <p><?php echo $plan->description; ?></p>
                    <a href="<?php echo site_url('dietician_patient_tracking/client/meal_plan/' . $plan->id); ?>" class="btn btn-info btn-sm">
                        <?php echo _l('view'); ?>
                    </a>
                </div>
            <?php endforeach; ?>
        <?php else : ?>
            <div class="text-center mtop40 mbottom40">
                <i class="fa fa-cutlery fa-5x" style="opacity: 0.3;"></i>
                <h4 class="mtop20"><?php echo _l('dpt_no_meal_plans'); ?></h4>
            </div>
        <?php endif; ?>
    </div>
</div>
