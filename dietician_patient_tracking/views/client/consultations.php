<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<div class="panel_s">
    <div class="panel-body">
        <h4><?php echo _l('dpt_my_consultations'); ?></h4>
        <hr />
        <table class="table table-striped">
            <thead>
                <tr>
                    <th><?php echo _l('dpt_date'); ?></th>
                    <th><?php echo _l('dpt_subject'); ?></th>
                    <th><?php echo _l('dpt_status'); ?></th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($consultations)) : ?>
                    <?php foreach ($consultations as $c) : ?>
                        <tr>
                            <td><?php echo date('d/m/Y H:i', strtotime($c->consultation_date)); ?></td>
                            <td><?php echo $c->subject; ?></td>
                            <td><span class="label label-<?php echo $c->status == 'completed' ? 'success' : 'default'; ?>"><?php echo _l('dpt_' . $c->status); ?></span></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else : ?>
                    <tr>
                        <td colspan="3" class="text-center"><?php echo _l('dpt_no_consultations'); ?></td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
