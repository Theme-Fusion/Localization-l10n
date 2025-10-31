<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head(); ?>
<div id="wrapper">
    <div class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="panel_s">
                    <div class="panel-body">
                        <h4><?php echo isset($food_item) ? _l('dpt_edit_food_item') : _l('dpt_add_food_item'); ?></h4>
                        <hr />
                        <?php echo form_open(admin_url('dietician_patient_tracking/food_item' . (isset($food_item) ? '/' . $food_item->id : '')), ['id' => 'food-item-form']); ?>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label><?php echo _l('dpt_food_name'); ?> *</label>
                                    <input type="text" class="form-control" name="name" value="<?php echo isset($food_item) ? $food_item->name : ''; ?>" required>
                                </div>
                                <div class="form-group">
                                    <label><?php echo _l('dpt_category'); ?></label>
                                    <input type="text" class="form-control" name="category" value="<?php echo isset($food_item) ? $food_item->category : ''; ?>">
                                </div>
                                <div class="form-group">
                                    <label><?php echo _l('dpt_serving_size'); ?> (g) *</label>
                                    <input type="number" step="0.01" class="form-control" name="serving_size" value="<?php echo isset($food_item) ? $food_item->serving_size : '100'; ?>" required>
                                </div>
                                <div class="form-group">
                                    <label><?php echo _l('dpt_calories'); ?> (kcal) *</label>
                                    <input type="number" step="0.01" class="form-control" name="calories" value="<?php echo isset($food_item) ? $food_item->calories : ''; ?>" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label><?php echo _l('dpt_protein'); ?> (g) *</label>
                                    <input type="number" step="0.01" class="form-control" name="protein" value="<?php echo isset($food_item) ? $food_item->protein : ''; ?>" required>
                                </div>
                                <div class="form-group">
                                    <label><?php echo _l('dpt_carbs'); ?> (g) *</label>
                                    <input type="number" step="0.01" class="form-control" name="carbohydrates" value="<?php echo isset($food_item) ? $food_item->carbohydrates : ''; ?>" required>
                                </div>
                                <div class="form-group">
                                    <label><?php echo _l('dpt_fat'); ?> (g) *</label>
                                    <input type="number" step="0.01" class="form-control" name="fat" value="<?php echo isset($food_item) ? $food_item->fat : ''; ?>" required>
                                </div>
                                <div class="form-group">
                                    <label><?php echo _l('dpt_fiber'); ?> (g)</label>
                                    <input type="number" step="0.01" class="form-control" name="fiber" value="<?php echo isset($food_item) ? $food_item->fiber : ''; ?>">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label><?php echo _l('dpt_description'); ?></label>
                            <textarea class="form-control" name="description" rows="3"><?php echo isset($food_item) ? $food_item->description : ''; ?></textarea>
                        </div>
                        <div class="btn-bottom-toolbar text-right">
                            <a href="<?php echo admin_url('dietician_patient_tracking/food_library'); ?>" class="btn btn-default"><?php echo _l('cancel'); ?></a>
                            <button type="submit" class="btn btn-info"><?php echo _l('save'); ?></button>
                        </div>
                        <?php echo form_close(); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php init_tail(); ?>
