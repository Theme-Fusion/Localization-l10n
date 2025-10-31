/**
 * Dietician Patient Tracking - Client Area JavaScript
 */

(function($) {
    'use strict';

    var DPTClient = {
        init: function() {
            this.initFoodDiary();
            this.initMeasurementForm();
            this.initModals();
            this.initCharts();
            this.initGoalTracking();
            this.initMessaging();
        },

        /**
         * Initialize Food Diary
         */
        initFoodDiary: function() {
            var self = this;

            // Date navigation
            $('.dpt-diary-date-btn').on('click', function() {
                var direction = $(this).data('direction');
                self.changeDiaryDate(direction);
            });

            // Add food entry
            $('#add-food-entry-form').on('submit', function(e) {
                e.preventDefault();
                self.addFoodEntry($(this));
            });

            // Delete food entry
            $(document).on('click', '.delete-food-entry', function(e) {
                e.preventDefault();
                if (confirm('Are you sure you want to delete this entry?')) {
                    self.deleteFoodEntry($(this).data('id'));
                }
            });

            // Food search
            $('#food-search-input').on('keyup', function() {
                var query = $(this).val();
                if (query.length >= 2) {
                    self.searchFood(query);
                } else {
                    $('#food-search-results').empty().hide();
                }
            });

            // Calculate daily totals
            this.calculateDailyTotals();
        },

        /**
         * Change diary date
         */
        changeDiaryDate: function(direction) {
            var currentDate = new Date($('#current-diary-date').data('date'));

            if (direction === 'prev') {
                currentDate.setDate(currentDate.getDate() - 1);
            } else {
                currentDate.setDate(currentDate.getDate() + 1);
            }

            var formattedDate = this.formatDate(currentDate);
            window.location.href = site_url + 'dietician_patient_tracking/client/food_diary?date=' + formattedDate;
        },

        /**
         * Add food entry
         */
        addFoodEntry: function($form) {
            var formData = $form.serialize();

            $.ajax({
                url: site_url + 'dietician_patient_tracking/client/add_food_diary_entry',
                type: 'POST',
                data: formData,
                beforeSend: function() {
                    $form.find('button[type="submit"]').prop('disabled', true);
                },
                success: function(response) {
                    var data = typeof response === 'string' ? JSON.parse(response) : response;

                    if (data.success) {
                        alert_float('success', data.message);
                        setTimeout(function() {
                            location.reload();
                        }, 1000);
                    } else {
                        alert_float('danger', data.message);
                    }
                },
                error: function() {
                    alert_float('danger', 'An error occurred. Please try again.');
                },
                complete: function() {
                    $form.find('button[type="submit"]').prop('disabled', false);
                }
            });
        },

        /**
         * Delete food entry
         */
        deleteFoodEntry: function(entryId) {
            $.ajax({
                url: site_url + 'dietician_patient_tracking/client/delete_food_diary_entry/' + entryId,
                type: 'POST',
                success: function(response) {
                    var data = typeof response === 'string' ? JSON.parse(response) : response;

                    if (data.success) {
                        alert_float('success', data.message);
                        setTimeout(function() {
                            location.reload();
                        }, 1000);
                    } else {
                        alert_float('danger', data.message);
                    }
                },
                error: function() {
                    alert_float('danger', 'An error occurred while deleting.');
                }
            });
        },

        /**
         * Search food items
         */
        searchFood: function(query) {
            $.ajax({
                url: site_url + 'dietician_patient_tracking/client/search_food',
                type: 'GET',
                data: { q: query },
                success: function(response) {
                    var data = typeof response === 'string' ? JSON.parse(response) : response;
                    DPTClient.displayFoodResults(data);
                }
            });
        },

        /**
         * Display food search results
         */
        displayFoodResults: function(foods) {
            var $results = $('#food-search-results');
            $results.empty();

            if (foods.length === 0) {
                $results.html('<div class="no-results">No foods found</div>').show();
                return;
            }

            foods.forEach(function(food) {
                var $item = $('<div class="food-result-item">')
                    .html(
                        '<div class="food-name">' + food.name + '</div>' +
                        '<div class="food-nutrition">' +
                        food.calories + ' kcal | ' +
                        'P: ' + food.protein + 'g | ' +
                        'C: ' + food.carbohydrates + 'g | ' +
                        'F: ' + food.fat + 'g' +
                        '</div>'
                    )
                    .data('food', food)
                    .on('click', function() {
                        DPTClient.selectFood($(this).data('food'));
                    });

                $results.append($item);
            });

            $results.show();
        },

        /**
         * Select food item
         */
        selectFood: function(food) {
            $('#food_id').val(food.id);
            $('#food_name').val(food.name);
            $('#quantity').val(food.serving_size);
            $('#calories').val(food.calories);
            $('#protein').val(food.protein);
            $('#carbs').val(food.carbohydrates);
            $('#fat').val(food.fat);

            $('#food-search-results').empty().hide();
            $('#food-search-input').val('');
        },

        /**
         * Calculate daily totals
         */
        calculateDailyTotals: function() {
            var totals = {
                calories: 0,
                protein: 0,
                carbs: 0,
                fat: 0
            };

            $('.food-diary-entry').each(function() {
                totals.calories += parseFloat($(this).data('calories')) || 0;
                totals.protein += parseFloat($(this).data('protein')) || 0;
                totals.carbs += parseFloat($(this).data('carbs')) || 0;
                totals.fat += parseFloat($(this).data('fat')) || 0;
            });

            $('#daily-calories').text(Math.round(totals.calories));
            $('#daily-protein').text(Math.round(totals.protein));
            $('#daily-carbs').text(Math.round(totals.carbs));
            $('#daily-fat').text(Math.round(totals.fat));
        },

        /**
         * Initialize Measurement Form
         */
        initMeasurementForm: function() {
            var self = this;

            $('#add-measurement-form').on('submit', function(e) {
                e.preventDefault();
                self.addMeasurement($(this));
            });

            // Real-time BMI calculation
            $('#measurement-weight, #patient-height').on('input', function() {
                self.calculateRealtimeBMI();
            });
        },

        /**
         * Add measurement
         */
        addMeasurement: function($form) {
            var formData = $form.serialize();

            $.ajax({
                url: site_url + 'dietician_patient_tracking/client/add_measurement',
                type: 'POST',
                data: formData,
                beforeSend: function() {
                    $form.find('button[type="submit"]').prop('disabled', true);
                },
                success: function(response) {
                    var data = typeof response === 'string' ? JSON.parse(response) : response;

                    if (data.success) {
                        alert_float('success', data.message);
                        setTimeout(function() {
                            location.reload();
                        }, 1000);
                    } else {
                        alert_float('danger', data.message);
                    }
                },
                error: function() {
                    alert_float('danger', 'An error occurred. Please try again.');
                },
                complete: function() {
                    $form.find('button[type="submit"]').prop('disabled', false);
                }
            });
        },

        /**
         * Calculate real-time BMI
         */
        calculateRealtimeBMI: function() {
            var weight = parseFloat($('#measurement-weight').val());
            var height = parseFloat($('#patient-height').val());

            if (weight > 0 && height > 0) {
                var heightM = height / 100;
                var bmi = weight / (heightM * heightM);

                $('#realtime-bmi').text(bmi.toFixed(2)).show();
                $('#bmi-category').text(this.getBMICategory(bmi)).show();
            } else {
                $('#realtime-bmi').hide();
                $('#bmi-category').hide();
            }
        },

        /**
         * Get BMI Category
         */
        getBMICategory: function(bmi) {
            if (bmi < 18.5) return 'Underweight';
            if (bmi < 25) return 'Normal Weight';
            if (bmi < 30) return 'Overweight';
            return 'Obese';
        },

        /**
         * Initialize Modals
         */
        initModals: function() {
            // Open modal
            $(document).on('click', '[data-modal-target]', function(e) {
                e.preventDefault();
                var target = $(this).data('modal-target');
                $('#' + target).addClass('active');
            });

            // Close modal
            $('.dpt-modal-close, .dpt-modal-overlay').on('click', function(e) {
                if (e.target === this) {
                    $(this).closest('.dpt-modal-overlay').removeClass('active');
                }
            });

            // ESC key to close modal
            $(document).on('keydown', function(e) {
                if (e.key === 'Escape') {
                    $('.dpt-modal-overlay.active').removeClass('active');
                }
            });
        },

        /**
         * Initialize Charts
         */
        initCharts: function() {
            // Weight progress chart
            if ($('#client-weight-chart').length && typeof Chart !== 'undefined') {
                this.initWeightChart();
            }

            // Daily nutrition chart
            if ($('#daily-nutrition-chart').length) {
                this.initDailyNutritionChart();
            }

            // Goal progress charts
            $('.client-goal-progress').each(function() {
                DPTClient.animateGoalProgress($(this));
            });
        },

        /**
         * Initialize Weight Chart
         */
        initWeightChart: function() {
            var $canvas = $('#client-weight-chart');
            var chartData = $canvas.data('chart');

            if (!chartData || !chartData.labels || chartData.labels.length === 0) {
                return;
            }

            var ctx = $canvas[0].getContext('2d');
            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: chartData.labels,
                    datasets: [{
                        label: 'Weight (kg)',
                        data: chartData.values,
                        borderColor: '#667eea',
                        backgroundColor: 'rgba(102, 126, 234, 0.1)',
                        borderWidth: 3,
                        fill: true,
                        tension: 0.4,
                        pointRadius: 6,
                        pointHoverRadius: 8,
                        pointBackgroundColor: '#667eea',
                        pointBorderColor: '#fff',
                        pointBorderWidth: 2
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: false
                        }
                    }
                }
            });
        },

        /**
         * Initialize Daily Nutrition Chart
         */
        initDailyNutritionChart: function() {
            var $canvas = $('#daily-nutrition-chart');
            var protein = parseFloat($canvas.data('protein')) || 0;
            var carbs = parseFloat($canvas.data('carbs')) || 0;
            var fat = parseFloat($canvas.data('fat')) || 0;

            if (protein === 0 && carbs === 0 && fat === 0) {
                return;
            }

            var ctx = $canvas[0].getContext('2d');
            new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: ['Protein', 'Carbohydrates', 'Fat'],
                    datasets: [{
                        data: [protein, carbs, fat],
                        backgroundColor: [
                            '#28a745',
                            '#17a2b8',
                            '#ffc107'
                        ]
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom'
                        }
                    }
                }
            });
        },

        /**
         * Animate Goal Progress
         */
        animateGoalProgress: function($element) {
            var progress = parseFloat($element.data('progress')) || 0;
            var $fill = $element.find('.dpt-progress-bar-fill');

            setTimeout(function() {
                $fill.css('width', progress + '%');
            }, 100);
        },

        /**
         * Initialize Goal Tracking
         */
        initGoalTracking: function() {
            // Update goal progress
            $(document).on('click', '.update-goal-progress', function(e) {
                e.preventDefault();
                var goalId = $(this).data('goal-id');
                DPTClient.showGoalProgressModal(goalId);
            });
        },

        /**
         * Show Goal Progress Modal
         */
        showGoalProgressModal: function(goalId) {
            // Implementation for goal progress update
            $('#goal-progress-modal-' + goalId).addClass('active');
        },

        /**
         * Initialize Messaging
         */
        initMessaging: function() {
            var self = this;

            // Send message
            $('#send-message-form').on('submit', function(e) {
                e.preventDefault();
                self.sendMessage($(this));
            });

            // Auto-scroll to latest message
            var $messageContainer = $('.dpt-messages-container');
            if ($messageContainer.length) {
                $messageContainer.scrollTop($messageContainer[0].scrollHeight);
            }

            // Mark messages as read
            this.markMessagesAsRead();
        },

        /**
         * Send message
         */
        sendMessage: function($form) {
            var message = $form.find('textarea[name="message"]').val().trim();

            if (message === '') {
                alert_float('warning', 'Please enter a message');
                return;
            }

            $.ajax({
                url: site_url + 'dietician_patient_tracking/client/send_message',
                type: 'POST',
                data: $form.serialize(),
                beforeSend: function() {
                    $form.find('button[type="submit"]').prop('disabled', true);
                },
                success: function(response) {
                    var data = typeof response === 'string' ? JSON.parse(response) : response;

                    if (data.success) {
                        $form.find('textarea').val('');
                        setTimeout(function() {
                            location.reload();
                        }, 500);
                    } else {
                        alert_float('danger', data.message);
                    }
                },
                complete: function() {
                    $form.find('button[type="submit"]').prop('disabled', false);
                }
            });
        },

        /**
         * Mark messages as read
         */
        markMessagesAsRead: function() {
            var unreadMessages = $('.dpt-message.unread');

            if (unreadMessages.length > 0) {
                $.ajax({
                    url: site_url + 'dietician_patient_tracking/client/mark_messages_read',
                    type: 'POST'
                });
            }
        },

        /**
         * Format date
         */
        formatDate: function(date) {
            var year = date.getFullYear();
            var month = String(date.getMonth() + 1).padStart(2, '0');
            var day = String(date.getDate()).padStart(2, '0');
            return year + '-' + month + '-' + day;
        },

        /**
         * Show notification
         */
        showNotification: function(message, type) {
            type = type || 'success';

            var $notification = $('<div class="dpt-alert dpt-alert-' + type + '">')
                .html('<i class="fa fa-info-circle dpt-alert-icon"></i>' + message)
                .prependTo('.content')
                .hide()
                .slideDown();

            setTimeout(function() {
                $notification.slideUp(function() {
                    $(this).remove();
                });
            }, 5000);
        }
    };

    // Initialize on document ready
    $(document).ready(function() {
        DPTClient.init();
    });

    // Export to global scope
    window.DPTClient = DPTClient;

})(jQuery);
