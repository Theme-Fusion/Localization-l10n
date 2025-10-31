<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head(); ?>

<div id="wrapper">
    <div class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="panel_s">
                    <div class="panel-body">
                        <h4 class="no-margin">
                            <?php echo isset($reminder) ? _l('dpt_edit') . ' ' . _l('dpt_reminder') : _l('dpt_add_reminder'); ?>
                        </h4>
                        <hr class="hr-panel-heading" />

                        <?php echo form_open(admin_url('dietician_patient_tracking/reminder/' . (isset($reminder) ? $reminder->id : '')), ['id' => 'reminder-form']); ?>

                        <div class="row">
                            <div class="col-md-6">
                                <?php
                                $selected = isset($reminder) ? $reminder->patient_id : '';
                                echo render_select('patient_id', $patients, ['id', ['firstname', 'lastname']], 'dpt_patient', $selected, ['required' => true]);
                                ?>
                            </div>

                            <div class="col-md-6">
                                <?php
                                $reminder_types = [
                                    ['id' => 'meal', 'name' => _l('dpt_reminder_meal')],
                                    ['id' => 'hydration', 'name' => _l('dpt_reminder_hydration')],
                                    ['id' => 'medication', 'name' => _l('dpt_reminder_medication')],
                                    ['id' => 'appointment', 'name' => _l('dpt_reminder_appointment')],
                                    ['id' => 'measurement', 'name' => _l('dpt_reminder_measurement')],
                                    ['id' => 'plan_renewal', 'name' => _l('dpt_reminder_plan_renewal')],
                                    ['id' => 'custom', 'name' => _l('dpt_reminder_custom')],
                                ];
                                $selected = isset($reminder) ? $reminder->reminder_type : '';
                                echo render_select('reminder_type', $reminder_types, ['id', 'name'], 'dpt_reminder_type', $selected, ['required' => true]);
                                ?>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <?php echo render_input('title', 'dpt_title', isset($reminder) ? $reminder->title : '', 'text', ['required' => true]); ?>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <?php echo render_textarea('message', 'dpt_message', isset($reminder) ? $reminder->message : ''); ?>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <?php
                                $frequencies = [
                                    ['id' => 'once', 'name' => _l('dpt_frequency_once')],
                                    ['id' => 'daily', 'name' => _l('dpt_daily')],
                                    ['id' => 'weekly', 'name' => _l('dpt_weekly')],
                                    ['id' => 'monthly', 'name' => _l('dpt_monthly')],
                                    ['id' => 'custom', 'name' => _l('dpt_frequency_custom')],
                                ];
                                $selected = isset($reminder) ? $reminder->frequency : '';
                                echo render_select('frequency', $frequencies, ['id', 'name'], 'dpt_frequency', $selected, ['required' => true]);
                                ?>
                            </div>

                            <div class="col-md-4">
                                <?php
                                $time_value = isset($reminder) ? $reminder->time_of_day : '09:00';
                                echo render_input('time_of_day', 'dpt_time_of_day', $time_value, 'time');
                                ?>
                            </div>

                            <div class="col-md-4">
                                <?php
                                $statuses = [
                                    ['id' => 'active', 'name' => _l('dpt_active')],
                                    ['id' => 'paused', 'name' => _l('dpt_paused')],
                                    ['id' => 'completed', 'name' => _l('dpt_completed')],
                                    ['id' => 'cancelled', 'name' => _l('dpt_cancelled')],
                                ];
                                $selected = isset($reminder) ? $reminder->status : 'active';
                                echo render_select('status', $statuses, ['id', 'name'], 'dpt_status', $selected);
                                ?>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <?php echo render_date_input('start_date', 'dpt_start_date', isset($reminder) ? $reminder->start_date : date('Y-m-d'), ['required' => true]); ?>
                            </div>

                            <div class="col-md-6">
                                <?php echo render_date_input('end_date', 'dpt_end_date', isset($reminder) ? $reminder->end_date : ''); ?>
                            </div>
                        </div>

                        <div class="row" id="days_of_week_row" style="display: none;">
                            <div class="col-md-12">
                                <label><?php echo _l('dpt_days_of_week'); ?></label>
                                <div class="checkbox-inline">
                                    <?php
                                    $days = ['1' => _l('dpt_monday'), '2' => _l('dpt_tuesday'), '3' => _l('dpt_wednesday'), '4' => _l('dpt_thursday'), '5' => _l('dpt_friday'), '6' => _l('dpt_saturday'), '7' => _l('dpt_sunday')];
                                    $selected_days = isset($reminder) && $reminder->days_of_week ? explode(',', $reminder->days_of_week) : [];
                                    foreach ($days as $day_num => $day_name) {
                                        $checked = in_array($day_num, $selected_days) ? 'checked' : '';
                                        echo '<label class="checkbox-inline"><input type="checkbox" name="days_of_week[]" value="' . $day_num . '" ' . $checked . '> ' . $day_name . '</label> ';
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>

                        <h4 class="mtop25"><?php echo _l('dpt_send_via'); ?></h4>
                        <hr />

                        <div class="row">
                            <div class="col-md-4">
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="send_via_email" value="1" <?php echo isset($reminder) && $reminder->send_via_email ? 'checked' : 'checked'; ?>>
                                        <i class="fa fa-envelope"></i> <?php echo _l('dpt_send_via_email'); ?>
                                    </label>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="send_via_sms" value="1" <?php echo isset($reminder) && $reminder->send_via_sms ? 'checked' : ''; ?>>
                                        <i class="fa fa-mobile"></i> <?php echo _l('dpt_send_via_sms'); ?>
                                    </label>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="send_via_notification" value="1" <?php echo isset($reminder) && $reminder->send_via_notification ? 'checked' : 'checked'; ?>>
                                        <i class="fa fa-bell"></i> <?php echo _l('notification'); ?>
                                    </label>
                                </div>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary mtop15">
                            <i class="fa fa-check"></i>
                            <?php echo _l('submit'); ?>
                        </button>
                        <a href="<?php echo admin_url('dietician_patient_tracking/reminders'); ?>" class="btn btn-default mtop15">
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

<script>
    $(function() {
        $('#frequency').on('change', function() {
            if ($(this).val() === 'weekly' || $(this).val() === 'custom') {
                $('#days_of_week_row').show();
            } else {
                $('#days_of_week_row').hide();
            }
        }).trigger('change');
    });
</script>

</body>
</html>
