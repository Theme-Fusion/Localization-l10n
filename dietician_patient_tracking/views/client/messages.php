<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<div class="panel_s">
    <div class="panel-body">
        <h4><?php echo _l('dpt_messages'); ?></h4>
        <hr />
        <div class="dpt-messages-container">
            <?php if (!empty($messages)) : ?>
                <?php foreach ($messages as $msg) : ?>
                    <div class="dpt-message <?php echo $msg->sender_type == 'patient' ? 'sent' : 'received'; ?>">
                        <div class="dpt-message-content">
                            <div class="dpt-message-sender"><?php echo $msg->sender_type == 'patient' ? _l('you') : _l('dpt_dietician'); ?></div>
                            <div class="dpt-message-text"><?php echo nl2br($msg->message); ?></div>
                            <div class="dpt-message-time"><?php echo date('d/m/Y H:i', strtotime($msg->created_at)); ?></div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else : ?>
                <p class="text-center"><?php echo _l('dpt_no_messages'); ?></p>
            <?php endif; ?>
        </div>
        <hr />
        <?php echo form_open(site_url('dietician_patient_tracking/client/messages'), ['id' => 'send-message-form']); ?>
        <div class="form-group">
            <textarea name="message" class="form-control" rows="3" placeholder="<?php echo _l('dpt_send_message'); ?>..." required></textarea>
        </div>
        <button type="submit" class="btn btn-info"><?php echo _l('send'); ?></button>
        <?php echo form_close(); ?>
    </div>
</div>
