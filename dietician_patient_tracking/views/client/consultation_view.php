<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<div class="panel_s">
    <div class="panel-body">
        <h4><?php echo $consultation->subject; ?></h4>
        <hr />
        <p><strong><?php echo _l('dpt_date'); ?>:</strong> <?php echo date('d/m/Y H:i', strtotime($consultation->consultation_date)); ?></p>
        <p><strong><?php echo _l('dpt_recommendations'); ?>:</strong></p>
        <p><?php echo nl2br($consultation->recommendations); ?></p>
    </div>
</div>
