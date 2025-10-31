<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head(); ?>
<div id="wrapper">
    <div class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="panel_s">
                    <div class="panel-body">
                        <h4><?php echo _l('settings'); ?></h4>
                        <hr />
                        <?php echo form_open(admin_url('dietician_patient_tracking/settings')); ?>
                        <div class="form-group">
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" name="dpt_enable_gamification" value="1" <?php echo ($settings['dpt_enable_gamification'] == '1') ? 'checked' : ''; ?>>
                                    <?php echo _l('dpt_enable_gamification'); ?>
                                </label>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" name="dpt_enable_messaging" value="1" <?php echo ($settings['dpt_enable_messaging'] == '1') ? 'checked' : ''; ?>>
                                    <?php echo _l('dpt_enable_messaging'); ?>
                                </label>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" name="dpt_enable_food_diary" value="1" <?php echo ($settings['dpt_enable_food_diary'] == '1') ? 'checked' : ''; ?>>
                                    <?php echo _l('dpt_enable_food_diary'); ?>
                                </label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label><?php echo _l('dpt_consultation_reminder_days'); ?></label>
                            <input type="number" class="form-control" name="dpt_consultation_reminder_days" value="<?php echo $settings['dpt_consultation_reminder_days']; ?>">
                        </div>
                        <button type="submit" class="btn btn-info"><?php echo _l('save'); ?></button>
                        <?php echo form_close(); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php init_tail(); ?>
