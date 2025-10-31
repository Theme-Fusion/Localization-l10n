<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<div class="panel_s">
    <div class="panel-body">
        <h4><?php echo _l('dpt_my_goals'); ?></h4>
        <hr />
        <?php if (!empty($goals)) : ?>
            <?php foreach ($goals as $goal) : ?>
                <div class="dpt-goal-card">
                    <div class="dpt-goal-header">
                        <div class="dpt-goal-title"><?php echo $goal->title; ?></div>
                        <span class="dpt-goal-priority <?php echo $goal->priority; ?>"><?php echo _l('dpt_' . $goal->priority); ?></span>
                    </div>
                    <div class="dpt-goal-progress-bar">
                        <div class="dpt-goal-progress-fill client-goal-progress" data-progress="<?php echo $goal->completion_percentage; ?>" style="width: 0%">
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
