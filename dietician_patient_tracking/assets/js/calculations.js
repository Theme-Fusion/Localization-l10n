/**
 * Dietician Patient Tracking - Biometric Calculations
 */

(function($) {
    'use strict';

    var DPTCalculations = {
        /**
         * Calculate BMI (Body Mass Index)
         * @param {number} weight - Weight in kg
         * @param {number} height - Height in cm
         * @returns {number} BMI value
         */
        calculateBMI: function(weight, height) {
            if (height <= 0 || weight <= 0) {
                return 0;
            }

            var heightM = height / 100;
            return weight / (heightM * heightM);
        },

        /**
         * Get BMI Category
         * @param {number} bmi - BMI value
         * @returns {string} Category name
         */
        getBMICategory: function(bmi) {
            if (bmi < 18.5) return 'underweight';
            if (bmi < 25) return 'normal';
            if (bmi < 30) return 'overweight';
            return 'obese';
        },

        /**
         * Get BMI Category Label
         * @param {number} bmi - BMI value
         * @returns {string} Category label
         */
        getBMICategoryLabel: function(bmi) {
            var category = this.getBMICategory(bmi);

            var labels = {
                'underweight': 'Underweight',
                'normal': 'Normal Weight',
                'overweight': 'Overweight',
                'obese': 'Obese'
            };

            return labels[category] || 'Unknown';
        },

        /**
         * Get BMI Color
         * @param {number} bmi - BMI value
         * @returns {string} Color code
         */
        getBMIColor: function(bmi) {
            var category = this.getBMICategory(bmi);

            var colors = {
                'underweight': '#FFA500',
                'normal': '#28a745',
                'overweight': '#FFA500',
                'obese': '#dc3545'
            };

            return colors[category] || '#6c757d';
        },

        /**
         * Calculate BMR (Basal Metabolic Rate) using Mifflin-St Jeor Equation
         * @param {number} weight - Weight in kg
         * @param {number} height - Height in cm
         * @param {number} age - Age in years
         * @param {string} gender - 'male' or 'female'
         * @returns {number} BMR in calories
         */
        calculateBMR: function(weight, height, age, gender) {
            if (weight <= 0 || height <= 0 || age <= 0) {
                return 0;
            }

            var bmr;
            if (gender === 'male') {
                bmr = (10 * weight) + (6.25 * height) - (5 * age) + 5;
            } else {
                bmr = (10 * weight) + (6.25 * height) - (5 * age) - 161;
            }

            return Math.round(bmr);
        },

        /**
         * Calculate TDEE (Total Daily Energy Expenditure)
         * @param {number} bmr - Basal Metabolic Rate
         * @param {string} activityLevel - Activity level
         * @returns {number} TDEE in calories
         */
        calculateTDEE: function(bmr, activityLevel) {
            var multipliers = {
                'sedentary': 1.2,
                'lightly_active': 1.375,
                'moderately_active': 1.55,
                'very_active': 1.725,
                'extremely_active': 1.9
            };

            var multiplier = multipliers[activityLevel] || 1.2;
            return Math.round(bmr * multiplier);
        },

        /**
         * Calculate Body Fat Percentage (using US Navy method)
         * @param {string} gender - 'male' or 'female'
         * @param {number} height - Height in cm
         * @param {number} waist - Waist circumference in cm
         * @param {number} neck - Neck circumference in cm
         * @param {number} hip - Hip circumference in cm (for females)
         * @returns {number} Body fat percentage
         */
        calculateBodyFat: function(gender, height, waist, neck, hip) {
            if (height <= 0 || waist <= 0 || neck <= 0) {
                return 0;
            }

            var bodyFat;

            if (gender === 'male') {
                bodyFat = 495 / (1.0324 - 0.19077 * Math.log10(waist - neck) + 0.15456 * Math.log10(height)) - 450;
            } else {
                if (hip <= 0) {
                    return 0;
                }
                bodyFat = 495 / (1.29579 - 0.35004 * Math.log10(waist + hip - neck) + 0.22100 * Math.log10(height)) - 450;
            }

            return Math.max(0, parseFloat(bodyFat.toFixed(2)));
        },

        /**
         * Calculate Waist-to-Hip Ratio
         * @param {number} waist - Waist circumference in cm
         * @param {number} hip - Hip circumference in cm
         * @returns {number} Ratio
         */
        calculateWaistToHipRatio: function(waist, hip) {
            if (hip <= 0) {
                return 0;
            }

            return parseFloat((waist / hip).toFixed(2));
        },

        /**
         * Get WHR Health Risk
         * @param {number} ratio - Waist-to-hip ratio
         * @param {string} gender - Gender
         * @returns {string} Risk level
         */
        getWHRRisk: function(ratio, gender) {
            if (gender === 'male') {
                if (ratio < 0.95) return 'low';
                if (ratio < 1.0) return 'moderate';
                return 'high';
            } else {
                if (ratio < 0.80) return 'low';
                if (ratio < 0.85) return 'moderate';
                return 'high';
            }
        },

        /**
         * Calculate ideal weight range using BMI
         * @param {number} height - Height in cm
         * @returns {object} Min and max ideal weight
         */
        calculateIdealWeightRange: function(height) {
            var heightM = height / 100;

            return {
                min: parseFloat((18.5 * (heightM * heightM)).toFixed(1)),
                max: parseFloat((24.9 * (heightM * heightM)).toFixed(1))
            };
        },

        /**
         * Calculate macronutrient distribution
         * @param {number} totalCalories - Total daily calories
         * @param {string} goalType - Goal type (lose_weight, gain_weight, etc.)
         * @returns {object} Protein, carbs, fat in grams
         */
        calculateMacros: function(totalCalories, goalType) {
            goalType = goalType || 'maintain';

            var ratios = {
                'lose_weight': { protein: 0.35, carbs: 0.35, fat: 0.30 },
                'gain_weight': { protein: 0.30, carbs: 0.45, fat: 0.25 },
                'muscle_gain': { protein: 0.40, carbs: 0.40, fat: 0.20 },
                'maintain': { protein: 0.30, carbs: 0.40, fat: 0.30 },
                'health': { protein: 0.25, carbs: 0.45, fat: 0.30 }
            };

            var ratio = ratios[goalType] || ratios['maintain'];

            return {
                protein: Math.round((totalCalories * ratio.protein) / 4), // 4 cal per gram
                carbs: Math.round((totalCalories * ratio.carbs) / 4),
                fat: Math.round((totalCalories * ratio.fat) / 9) // 9 cal per gram
            };
        },

        /**
         * Calculate daily water intake recommendation (in liters)
         * @param {number} weight - Weight in kg
         * @param {string} activityLevel - Activity level
         * @returns {number} Water in liters
         */
        calculateWaterIntake: function(weight, activityLevel) {
            activityLevel = activityLevel || 'moderately_active';

            // Base: 35ml per kg of body weight
            var baseML = weight * 35;

            // Adjust for activity
            var multipliers = {
                'sedentary': 1.0,
                'lightly_active': 1.1,
                'moderately_active': 1.2,
                'very_active': 1.3,
                'extremely_active': 1.5
            };

            var multiplier = multipliers[activityLevel] || 1.0;

            return parseFloat(((baseML * multiplier) / 1000).toFixed(1)); // Convert to liters
        },

        /**
         * Calculate age from date of birth
         * @param {string} dateOfBirth - Date of birth (Y-m-d)
         * @returns {number} Age in years
         */
        calculateAge: function(dateOfBirth) {
            if (!dateOfBirth) {
                return 0;
            }

            var dob = new Date(dateOfBirth);
            var today = new Date();
            var age = today.getFullYear() - dob.getFullYear();
            var monthDiff = today.getMonth() - dob.getMonth();

            if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < dob.getDate())) {
                age--;
            }

            return age;
        },

        /**
         * Calculate calorie deficit/surplus needed
         * @param {number} currentWeight - Current weight in kg
         * @param {number} targetWeight - Target weight in kg
         * @param {number} weeksToGoal - Number of weeks to reach goal
         * @returns {object} Daily calorie adjustment and weekly weight change
         */
        calculateCalorieAdjustment: function(currentWeight, targetWeight, weeksToGoal) {
            var weightDiff = targetWeight - currentWeight;
            var weeklyWeightChange = weightDiff / weeksToGoal;

            // 1 kg of fat = approximately 7700 calories
            var caloriesPerKg = 7700;
            var dailyCalorieAdjustment = (weeklyWeightChange * caloriesPerKg) / 7;

            return {
                dailyCalories: Math.round(dailyCalorieAdjustment),
                weeklyChange: parseFloat(weeklyWeightChange.toFixed(2)),
                type: weightDiff < 0 ? 'deficit' : 'surplus'
            };
        },

        /**
         * Calculate protein requirement
         * @param {number} weight - Weight in kg
         * @param {string} goalType - Goal type
         * @returns {number} Daily protein in grams
         */
        calculateProteinRequirement: function(weight, goalType) {
            var proteinPerKg = {
                'lose_weight': 2.2,
                'gain_weight': 1.8,
                'muscle_gain': 2.4,
                'maintain': 1.6,
                'health': 1.2
            };

            var multiplier = proteinPerKg[goalType] || 1.6;
            return Math.round(weight * multiplier);
        },

        /**
         * Format measurement value with unit
         * @param {number} value - Value
         * @param {string} unit - Unit type
         * @returns {string} Formatted value
         */
        formatMeasurement: function(value, unit) {
            if (!value || value === 0) {
                return '-';
            }

            var units = {
                'weight': 'kg',
                'height': 'cm',
                'circumference': 'cm',
                'body_fat': '%',
                'calories': 'kcal',
                'protein': 'g',
                'carbs': 'g',
                'fat': 'g',
                'water': 'L'
            };

            var unitLabel = units[unit] || '';
            return parseFloat(value).toFixed(1) + ' ' + unitLabel;
        },

        /**
         * Get progress percentage
         * @param {number} current - Current value
         * @param {number} target - Target value
         * @param {number} start - Start value (optional)
         * @returns {number} Progress percentage
         */
        getProgressPercentage: function(current, target, start) {
            if (!target) {
                return 0;
            }

            if (start) {
                var totalChange = target - start;
                var currentChange = current - start;
                return Math.min(100, Math.round((currentChange / totalChange) * 100));
            }

            return Math.min(100, Math.round((current / target) * 100));
        },

        /**
         * Interactive calculator for all metrics
         */
        initCalculatorWidget: function() {
            var $calculator = $('#dpt-calculator');
            if ($calculator.length === 0) {
                return;
            }

            var self = this;

            // Bind input events
            $calculator.on('input', 'input', function() {
                self.updateCalculatorResults($calculator);
            });

            // Initial calculation
            self.updateCalculatorResults($calculator);
        },

        /**
         * Update calculator results
         */
        updateCalculatorResults: function($calculator) {
            var weight = parseFloat($calculator.find('[name="weight"]').val()) || 0;
            var height = parseFloat($calculator.find('[name="height"]').val()) || 0;
            var age = parseFloat($calculator.find('[name="age"]').val()) || 0;
            var gender = $calculator.find('[name="gender"]').val();
            var activityLevel = $calculator.find('[name="activity_level"]').val();
            var goalType = $calculator.find('[name="goal_type"]').val();

            if (weight > 0 && height > 0) {
                // BMI
                var bmi = this.calculateBMI(weight, height);
                $calculator.find('.calc-bmi-value').text(bmi.toFixed(2));
                $calculator.find('.calc-bmi-category').text(this.getBMICategoryLabel(bmi));
                $calculator.find('.calc-bmi-result').css('color', this.getBMIColor(bmi));

                // Ideal Weight Range
                var idealRange = this.calculateIdealWeightRange(height);
                $calculator.find('.calc-ideal-weight').text(idealRange.min + ' - ' + idealRange.max + ' kg');

                if (age > 0) {
                    // BMR
                    var bmr = this.calculateBMR(weight, height, age, gender);
                    $calculator.find('.calc-bmr-value').text(bmr + ' kcal/day');

                    // TDEE
                    var tdee = this.calculateTDEE(bmr, activityLevel);
                    $calculator.find('.calc-tdee-value').text(tdee + ' kcal/day');

                    // Macros
                    var macros = this.calculateMacros(tdee, goalType);
                    $calculator.find('.calc-protein').text(macros.protein + ' g');
                    $calculator.find('.calc-carbs').text(macros.carbs + ' g');
                    $calculator.find('.calc-fat').text(macros.fat + ' g');

                    // Water
                    var water = this.calculateWaterIntake(weight, activityLevel);
                    $calculator.find('.calc-water').text(water + ' L/day');
                }
            }
        }
    };

    // Initialize on document ready
    $(document).ready(function() {
        DPTCalculations.initCalculatorWidget();
    });

    // Export to global scope
    window.DPTCalculations = DPTCalculations;

})(jQuery);
