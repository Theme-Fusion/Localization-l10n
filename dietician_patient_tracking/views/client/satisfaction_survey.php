<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<div class="panel_s">
    <div class="panel-body">
        <h4 class="no-margin">
            <i class="fa fa-smile-o"></i> <?php echo _l('dpt_satisfaction_survey'); ?>
        </h4>
        <hr />

        <?php if ($already_completed): ?>
            <!-- Survey Already Completed -->
            <div class="alert alert-success">
                <i class="fa fa-check-circle"></i>
                <strong><?php echo _l('dpt_thank_you_feedback'); ?></strong>
                <p class="mtop10"><?php echo _l('dpt_survey_completed'); ?> le <?php echo _dt($survey->completed_at); ?></p>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <h5><?php echo _l('dpt_nps'); ?>:</h5>
                    <p class="text-muted">
                        <?php
                        $nps = (int)$survey->nps_score;
                        $nps_class = $nps >= 9 ? 'success' : ($nps >= 7 ? 'warning' : 'danger');
                        ?>
                        <span class="label label-<?php echo $nps_class; ?>" style="font-size: 18px;"><?php echo $nps; ?>/10</span>
                    </p>
                </div>

                <div class="col-md-6">
                    <h5><?php echo _l('dpt_overall_satisfaction'); ?>:</h5>
                    <p>
                        <?php
                        for ($i = 1; $i <= 5; $i++) {
                            echo $i <= $survey->overall_satisfaction ? '<i class="fa fa-star text-warning"></i>' : '<i class="fa fa-star-o text-muted"></i>';
                        }
                        ?>
                    </p>
                </div>
            </div>

            <?php if ($survey->positive_feedback): ?>
                <div class="mtop15">
                    <h5><?php echo _l('dpt_positive_feedback'); ?>:</h5>
                    <p class="text-muted"><?php echo nl2br($survey->positive_feedback); ?></p>
                </div>
            <?php endif; ?>

        <?php else: ?>
            <!-- Survey Form -->
            <div class="alert alert-info">
                <i class="fa fa-info-circle"></i>
                <?php echo _l('we_appreciate_your_feedback'); ?>
            </div>

            <?php if (isset($consultation)): ?>
                <div class="well well-sm">
                    <strong><?php echo _l('dpt_consultation'); ?>:</strong> <?php echo $consultation->subject; ?><br>
                    <strong><?php echo _l('dpt_date'); ?>:</strong> <?php echo _dt($consultation->consultation_date); ?>
                </div>
            <?php endif; ?>

            <?php echo form_open(site_url('dietician_patient_tracking/client/satisfaction_survey/' . $survey->id), ['id' => 'satisfaction-form']); ?>

            <!-- NPS Score -->
            <div class="form-group mtop25">
                <label><strong><?php echo _l('dpt_would_recommend'); ?></strong> (0-10)</label>
                <p class="text-muted"><small>0 = Pas du tout probable, 10 = Extrêmement probable</small></p>
                <div class="nps-buttons">
                    <?php for ($i = 0; $i <= 10; $i++): ?>
                        <label class="btn btn-default nps-btn" data-score="<?php echo $i; ?>">
                            <input type="radio" name="nps_score" value="<?php echo $i; ?>" required>
                            <?php echo $i; ?>
                        </label>
                    <?php endfor; ?>
                </div>
            </div>

            <!-- Overall Satisfaction -->
            <div class="form-group mtop25">
                <label><strong><?php echo _l('dpt_overall_satisfaction'); ?></strong></label>
                <div class="star-rating" data-field="overall_satisfaction">
                    <?php for ($i = 1; $i <= 5; $i++): ?>
                        <i class="fa fa-star-o star" data-rating="<?php echo $i; ?>"></i>
                    <?php endfor; ?>
                    <input type="hidden" name="overall_satisfaction" required>
                </div>
            </div>

            <!-- Communication Rating -->
            <div class="form-group">
                <label><strong><?php echo _l('dpt_communication_rating'); ?></strong></label>
                <div class="star-rating" data-field="communication_rating">
                    <?php for ($i = 1; $i <= 5; $i++): ?>
                        <i class="fa fa-star-o star" data-rating="<?php echo $i; ?>"></i>
                    <?php endfor; ?>
                    <input type="hidden" name="communication_rating" required>
                </div>
            </div>

            <!-- Expertise Rating -->
            <div class="form-group">
                <label><strong><?php echo _l('dpt_expertise_rating'); ?></strong></label>
                <div class="star-rating" data-field="expertise_rating">
                    <?php for ($i = 1; $i <= 5; $i++): ?>
                        <i class="fa fa-star-o star" data-rating="<?php echo $i; ?>"></i>
                    <?php endfor; ?>
                    <input type="hidden" name="expertise_rating" required>
                </div>
            </div>

            <!-- Plan Quality Rating -->
            <div class="form-group">
                <label><strong><?php echo _l('dpt_plan_quality_rating'); ?></strong></label>
                <div class="star-rating" data-field="plan_quality_rating">
                    <?php for ($i = 1; $i <= 5; $i++): ?>
                        <i class="fa fa-star-o star" data-rating="<?php echo $i; ?>"></i>
                    <?php endfor; ?>
                    <input type="hidden" name="plan_quality_rating" required>
                </div>
            </div>

            <!-- Waiting Time Rating -->
            <div class="form-group">
                <label><strong><?php echo _l('dpt_waiting_time_rating'); ?></strong></label>
                <div class="star-rating" data-field="waiting_time_rating">
                    <?php for ($i = 1; $i <= 5; $i++): ?>
                        <i class="fa fa-star-o star" data-rating="<?php echo $i; ?>"></i>
                    <?php endfor; ?>
                    <input type="hidden" name="waiting_time_rating" required>
                </div>
            </div>

            <!-- Would Recommend -->
            <div class="form-group mtop25">
                <label><strong><?php echo _l('dpt_would_recommend'); ?></strong></label>
                <div class="radio">
                    <label>
                        <input type="radio" name="would_recommend" value="1" required> <?php echo _l('yes'); ?>
                    </label>
                </div>
                <div class="radio">
                    <label>
                        <input type="radio" name="would_recommend" value="0"> <?php echo _l('no'); ?>
                    </label>
                </div>
            </div>

            <!-- Positive Feedback -->
            <div class="form-group mtop25">
                <label><strong><?php echo _l('dpt_positive_feedback'); ?></strong></label>
                <textarea name="positive_feedback" class="form-control" rows="4" placeholder="<?php echo _l('what_did_you_like'); ?>..."></textarea>
            </div>

            <!-- Negative Feedback -->
            <div class="form-group">
                <label><strong><?php echo _l('dpt_negative_feedback'); ?></strong></label>
                <textarea name="negative_feedback" class="form-control" rows="4" placeholder="<?php echo _l('what_could_be_improved'); ?>..."></textarea>
            </div>

            <!-- Suggestions -->
            <div class="form-group">
                <label><strong><?php echo _l('dpt_suggestions'); ?></strong></label>
                <textarea name="suggestions" class="form-control" rows="4" placeholder="<?php echo _l('your_suggestions'); ?>..."></textarea>
            </div>

            <button type="submit" class="btn btn-primary btn-block mtop25">
                <i class="fa fa-check"></i> <?php echo _l('dpt_complete_survey'); ?>
            </button>

            <?php echo form_close(); ?>
        <?php endif; ?>
    </div>
</div>

<style>
    .nps-buttons {
        display: flex;
        gap: 5px;
        flex-wrap: wrap;
    }

    .nps-btn {
        min-width: 50px;
        margin: 0 !important;
    }

    .nps-btn input {
        display: none;
    }

    .nps-btn.active {
        background-color: #5cb85c;
        color: white;
    }

    .star-rating {
        font-size: 32px;
        cursor: pointer;
    }

    .star-rating .star {
        color: #ddd;
        transition: color 0.2s;
    }

    .star-rating .star:hover,
    .star-rating .star.active {
        color: #f39c12;
    }
</style>

<script>
    $(document).ready(function() {
        // NPS Buttons
        $('.nps-btn').click(function() {
            $('.nps-btn').removeClass('active');
            $(this).addClass('active');
        });

        // Star Rating
        $('.star-rating').each(function() {
            var $container = $(this);
            var $stars = $container.find('.star');
            var $input = $container.find('input');

            $stars.click(function() {
                var rating = $(this).data('rating');
                $input.val(rating);

                $stars.removeClass('active fa-star').addClass('fa-star-o');

                $stars.each(function() {
                    if ($(this).data('rating') <= rating) {
                        $(this).removeClass('fa-star-o').addClass('fa-star active');
                    }
                });
            });

            $stars.hover(
                function() {
                    var hoverRating = $(this).data('rating');
                    $stars.each(function() {
                        if ($(this).data('rating') <= hoverRating) {
                            $(this).removeClass('fa-star-o').addClass('fa-star');
                        }
                    });
                },
                function() {
                    var currentRating = $input.val();
                    $stars.removeClass('active fa-star').addClass('fa-star-o');
                    if (currentRating) {
                        $stars.each(function() {
                            if ($(this).data('rating') <= currentRating) {
                                $(this).removeClass('fa-star-o').addClass('fa-star active');
                            }
                        });
                    }
                }
            );
        });

        // Form validation
        $('#satisfaction-form').submit(function(e) {
            var allRated = true;
            $('input[name="nps_score"]').each(function() {
                if (!$('input[name="nps_score"]:checked').length) {
                    allRated = false;
                }
            });

            $('.star-rating input').each(function() {
                if (!$(this).val()) {
                    allRated = false;
                }
            });

            if (!allRated) {
                e.preventDefault();
                alert('<?php echo _l('please_fill_all_required_fields'); ?>');
                return false;
            }
        });
    });
</script>
