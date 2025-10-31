<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<div class="panel_s">
    <div class="panel-body">
        <h4><?php echo _l('dpt_my_achievements'); ?></h4>
        <p><?php echo _l('dpt_total_points'); ?>: <strong><?php echo $total_points; ?></strong></p>
        <hr />
        <div class="dpt-achievements-grid">
            <?php if (!empty($achievements)) : ?>
                <?php foreach ($achievements as $achievement) : ?>
                    <div class="dpt-achievement-card">
                        <i class="fa <?php echo $achievement->icon; ?> dpt-achievement-icon"></i>
                        <div class="dpt-achievement-title"><?php echo $achievement->title; ?></div>
                        <div class="dpt-achievement-points">+<?php echo $achievement->points; ?> pts</div>
                        <div class="dpt-achievement-date"><?php echo date('d/m/Y', strtotime($achievement->earned_date)); ?></div>
                    </div>
                <?php endforeach; ?>
            <?php else : ?>
                <p><?php echo _l('dpt_no_achievements'); ?></p>
            <?php endif; ?>
        </div>
    </div>
</div>
