/**
 * Dietician Patient Tracking Module - Main JavaScript
 */

(function($) {
    'use strict';

    var DPT = {
        init: function() {
            this.initDataTables();
            this.initForms();
            this.initModals();
            this.initCharts();
            this.initDatePickers();
            this.initTooltips();
        },

        /**
         * Initialize DataTables
         */
        initDataTables: function() {
            if ($.fn.DataTable) {
                $('.dpt-datatable').DataTable({
                    responsive: true,
                    pageLength: 25,
                    order: [[0, 'desc']],
                    language: {
                        search: '_INPUT_',
                        searchPlaceholder: 'Search...'
                    }
                });
            }
        },

        /**
         * Initialize Forms
         */
        initForms: function() {
            // Patient form - NO AJAX, use standard form submit
            // This allows Perfex to handle it properly

            // Real-time BMI calculation
            $('#height').on('input', function() {
                DPT.calculateBMI();
            });

            // Food search
            $('#food-search').on('keyup', function() {
                DPT.searchFood($(this).val());
            });
        },

        /**
         * Submit form via AJAX (for specific cases only)
         */
        submitForm: function($form, type) {
            // This function is kept for backward compatibility
            // Most forms should use standard submit
            $form[0].submit();
        },

        /**
         * Calculate BMI in real-time
         */
        calculateBMI: function() {
            var height = parseFloat($('#height').val());

            if (height > 0) {
                // Just show that we have the height, actual BMI needs weight from measurements
                console.log('Height entered: ' + height + ' cm');
            }
        },

        /**
         * Get BMI Category
         */
        getBMICategory: function(bmi) {
            if (bmi < 18.5) return 'Underweight';
            if (bmi < 25) return 'Normal';
            if (bmi < 30) return 'Overweight';
            return 'Obese';
        },

        /**
         * Search food items
         */
        searchFood: function(query) {
            if (query.length < 2) {
                $('#food-results').empty();
                return;
            }

            $.ajax({
                url: admin_url + 'dietician_patient_tracking/search_food',
                type: 'GET',
                data: { q: query },
                success: function(response) {
                    var data = typeof response === 'string' ? JSON.parse(response) : response;
                    DPT.displayFoodResults(data);
                }
            });
        },

        /**
         * Display food search results
         */
        displayFoodResults: function(foods) {
            var $results = $('#food-results');
            $results.empty();

            if (foods.length === 0) {
                $results.html('<div class="no-results">No foods found</div>');
                return;
            }

            foods.forEach(function(food) {
                var $item = $('<div class="food-result-item">')
                    .html(
                        '<strong>' + food.name + '</strong>' +
                        '<span class="food-calories">' + food.calories + ' kcal</span>'
                    )
                    .data('food', food)
                    .on('click', function() {
                        DPT.selectFood($(this).data('food'));
                    });

                $results.append($item);
            });
        },

        /**
         * Select food item
         */
        selectFood: function(food) {
            $('#food_id').val(food.id);
            $('#food_name').val(food.name);
            $('#calories').val(food.calories);
            $('#protein').val(food.protein);
            $('#carbs').val(food.carbohydrates);
            $('#fat').val(food.fat);
            $('#food-results').empty();
            $('#food-search').val('');
        },

        /**
         * Initialize Modals
         */
        initModals: function() {
            // Delete confirmation
            $(document).on('click', '.dpt-delete-btn', function(e) {
                e.preventDefault();

                var url = $(this).attr('href');
                var type = $(this).data('type');

                if (confirm('Are you sure you want to delete this ' + type + '?')) {
                    DPT.deleteItem(url, type);
                }
            });

            // Add measurement modal
            $('#add-measurement-btn').on('click', function() {
                $('#measurement-modal').show();
            });

            // Close modal
            $('.modal-close, .modal-overlay').on('click', function() {
                $(this).closest('.modal-overlay').hide();
            });
        },

        /**
         * Delete item
         */
        deleteItem: function(url, type) {
            $.ajax({
                url: url,
                type: 'POST',
                beforeSend: function() {
                    DPT.showLoader();
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
                    alert_float('danger', 'An error occurred while deleting.');
                },
                complete: function() {
                    DPT.hideLoader();
                }
            });
        },

        /**
         * Initialize Charts
         */
        initCharts: function() {
            // Weight progress chart
            if ($('#weight-chart').length && typeof Chart !== 'undefined') {
                DPT.initWeightChart();
            }

            // Nutrition donut chart
            if ($('#nutrition-chart').length) {
                DPT.initNutritionChart();
            }

            // Goal progress charts
            $('.goal-progress-chart').each(function() {
                DPT.initGoalChart($(this));
            });
        },

        /**
         * Initialize Weight Chart
         */
        initWeightChart: function() {
            var $canvas = $('#weight-chart');
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
                        pointRadius: 5,
                        pointHoverRadius: 7,
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
                        },
                        tooltip: {
                            backgroundColor: 'rgba(0, 0, 0, 0.8)',
                            padding: 12,
                            titleColor: '#fff',
                            bodyColor: '#fff',
                            borderColor: '#667eea',
                            borderWidth: 1
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: false,
                            grid: {
                                color: 'rgba(0, 0, 0, 0.05)'
                            }
                        },
                        x: {
                            grid: {
                                display: false
                            }
                        }
                    }
                }
            });
        },

        /**
         * Initialize Nutrition Chart
         */
        initNutritionChart: function() {
            var $canvas = $('#nutrition-chart');
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
                        ],
                        borderWidth: 0
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
         * Initialize Goal Progress Chart
         */
        initGoalChart: function($element) {
            var progress = parseFloat($element.data('progress')) || 0;
            var $fill = $element.find('.dpt-goal-progress-fill');

            setTimeout(function() {
                $fill.css('width', progress + '%');
            }, 100);
        },

        /**
         * Initialize Date Pickers
         */
        initDatePickers: function() {
            if ($.fn.datepicker) {
                $('.dpt-datepicker').datepicker({
                    dateFormat: 'yy-mm-dd',
                    changeMonth: true,
                    changeYear: true,
                    yearRange: '-100:+10'
                });
            }
        },

        /**
         * Initialize Tooltips
         */
        initTooltips: function() {
            if ($.fn.tooltip) {
                $('[data-toggle="tooltip"]').tooltip();
            }
        },

        /**
         * Show loader
         */
        showLoader: function() {
            if ($('#dpt-loader').length === 0) {
                $('body').append('<div id="dpt-loader" class="dpt-loader-overlay"><div class="dpt-spinner"></div></div>');
            }
            $('#dpt-loader').fadeIn();
        },

        /**
         * Hide loader
         */
        hideLoader: function() {
            $('#dpt-loader').fadeOut();
        },

        /**
         * Format number
         */
        formatNumber: function(num, decimals) {
            decimals = decimals || 1;
            return parseFloat(num).toFixed(decimals);
        },

        /**
         * Show notification
         */
        showNotification: function(message, type) {
            type = type || 'success';

            var $notification = $('<div class="dpt-notification dpt-notification-' + type + '">')
                .text(message)
                .appendTo('body')
                .fadeIn();

            setTimeout(function() {
                $notification.fadeOut(function() {
                    $(this).remove();
                });
            }, 3000);
        }
    };

    // Initialize on document ready
    $(document).ready(function() {
        DPT.init();
    });

    // Export to global scope
    window.DPT = DPT;

})(jQuery);
