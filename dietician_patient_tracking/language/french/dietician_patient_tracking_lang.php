<?php

defined('BASEPATH') or exit('No direct script access allowed');

# Version 1.0.0

// Module
$lang['dietician_patient_tracking'] = 'Suivi Diététicien-Patient';
$lang['dpt_module_name'] = 'Suivi Nutritionnel';

// Menu
$lang['dpt_patients'] = 'Patients';
$lang['dpt_consultations'] = 'Consultations';
$lang['dpt_meal_plans'] = 'Plans Alimentaires';
$lang['dpt_food_library'] = 'Bibliothèque Alimentaire';
$lang['dpt_reports'] = 'Rapports';
$lang['dpt_my_tracking'] = 'Mon Suivi';
$lang['dpt_my_profile'] = 'Mon Profil';
$lang['dpt_my_measurements'] = 'Mes Mesures';
$lang['dpt_my_meal_plans'] = 'Mes Plans Alimentaires';
$lang['dpt_my_goals'] = 'Mes Objectifs';
$lang['dpt_my_consultations'] = 'Mes Consultations';
$lang['dpt_my_achievements'] = 'Mes Réalisations';
$lang['dpt_messages'] = 'Messages';

// Patient Management
$lang['dpt_patient'] = 'Patient';
$lang['dpt_add_patient'] = 'Ajouter un Patient';
$lang['dpt_edit_patient'] = 'Modifier le Patient';
$lang['dpt_patient_profile'] = 'Profil Patient';
$lang['dpt_patient_info'] = 'Informations Patient';
$lang['dpt_medical_info'] = 'Informations Médicales';
$lang['dpt_goals_objectives'] = 'Objectifs';

// Patient Fields
$lang['dpt_contact'] = 'Contact';
$lang['dpt_dietician'] = 'Diététicien';
$lang['dpt_date_of_birth'] = 'Date de naissance';
$lang['dpt_gender'] = 'Sexe';
$lang['dpt_height'] = 'Taille';
$lang['dpt_medical_history'] = 'Antécédents médicaux';
$lang['dpt_allergies'] = 'Allergies';
$lang['dpt_dietary_restrictions'] = 'Restrictions alimentaires';
$lang['dpt_activity_level'] = 'Niveau d\'activité';
$lang['dpt_goal_type'] = 'Type d\'objectif';
$lang['dpt_target_weight'] = 'Poids cible';
$lang['dpt_weekly_goal'] = 'Objectif hebdomadaire';
$lang['dpt_profile_photo'] = 'Photo de profil';
$lang['dpt_notes'] = 'Notes';
$lang['dpt_status'] = 'Statut';

// Gender
$lang['dpt_male'] = 'Homme';
$lang['dpt_female'] = 'Femme';
$lang['dpt_other'] = 'Autre';

// Activity Levels
$lang['dpt_activity_sedentary'] = 'Sédentaire (peu ou pas d\'exercice)';
$lang['dpt_activity_lightly_active'] = 'Légèrement actif (exercice léger 1-3 jours/semaine)';
$lang['dpt_activity_moderately_active'] = 'Modérément actif (exercice modéré 3-5 jours/semaine)';
$lang['dpt_activity_very_active'] = 'Très actif (exercice intense 6-7 jours/semaine)';
$lang['dpt_activity_extremely_active'] = 'Extrêmement actif (exercice très intense quotidien)';

// Goal Types
$lang['dpt_goal_lose_weight'] = 'Perdre du poids';
$lang['dpt_goal_gain_weight'] = 'Prendre du poids';
$lang['dpt_goal_maintain'] = 'Maintenir le poids';
$lang['dpt_goal_muscle_gain'] = 'Prise de masse musculaire';
$lang['dpt_goal_health'] = 'Amélioration de la santé';

// Status
$lang['dpt_active'] = 'Actif';
$lang['dpt_inactive'] = 'Inactif';
$lang['dpt_completed'] = 'Terminé';
$lang['dpt_archived'] = 'Archivé';

// Measurements
$lang['dpt_measurement'] = 'Mesure';
$lang['dpt_measurements'] = 'Mesures';
$lang['dpt_add_measurement'] = 'Ajouter une Mesure';
$lang['dpt_measurement_date'] = 'Date de mesure';
$lang['dpt_weight'] = 'Poids';
$lang['dpt_body_fat_percentage'] = 'Pourcentage de graisse corporelle';
$lang['dpt_muscle_mass'] = 'Masse musculaire';
$lang['dpt_waist_circumference'] = 'Tour de taille';
$lang['dpt_hip_circumference'] = 'Tour de hanches';
$lang['dpt_chest_circumference'] = 'Tour de poitrine';
$lang['dpt_arm_circumference'] = 'Tour de bras';
$lang['dpt_thigh_circumference'] = 'Tour de cuisse';
$lang['dpt_blood_pressure'] = 'Tension artérielle';
$lang['dpt_systolic'] = 'Systolique';
$lang['dpt_diastolic'] = 'Diastolique';
$lang['dpt_blood_sugar'] = 'Glycémie';
$lang['dpt_weight_help'] = 'Poids mesuré à la même heure de la journée pour plus de précision';
$lang['dpt_photos'] = 'Photos';

// Biometric Calculations
$lang['dpt_bmi'] = 'IMC (Indice de Masse Corporelle)';
$lang['dpt_bmi_underweight'] = 'Insuffisance pondérale';
$lang['dpt_bmi_normal'] = 'Poids normal';
$lang['dpt_bmi_overweight'] = 'Surpoids';
$lang['dpt_bmi_obese'] = 'Obésité';
$lang['dpt_bmr'] = 'MB (Métabolisme de Base)';
$lang['dpt_tdee'] = 'TDEE (Dépense Énergétique Totale)';
$lang['dpt_whr'] = 'Ratio Taille/Hanches';
$lang['dpt_ideal_weight_range'] = 'Plage de poids idéal';
$lang['dpt_current_weight'] = 'Poids actuel';
$lang['dpt_weight_progress'] = 'Évolution du poids';
$lang['dpt_weight_change'] = 'Changement de poids';

// Risk Levels
$lang['dpt_risk_low'] = 'Risque faible';
$lang['dpt_risk_moderate'] = 'Risque modéré';
$lang['dpt_risk_high'] = 'Risque élevé';

// Consultations
$lang['dpt_consultation'] = 'Consultation';
$lang['dpt_add_consultation'] = 'Ajouter une Consultation';
$lang['dpt_edit_consultation'] = 'Modifier la Consultation';
$lang['dpt_consultation_date'] = 'Date de consultation';
$lang['dpt_consultation_type'] = 'Type de consultation';
$lang['dpt_duration'] = 'Durée (minutes)';
$lang['dpt_subject'] = 'Sujet';
$lang['dpt_anamnesis'] = 'Anamnèse';
$lang['dpt_diagnosis'] = 'Diagnostic';
$lang['dpt_recommendations'] = 'Recommandations';
$lang['dpt_next_consultation'] = 'Prochaine consultation';
$lang['dpt_attachments'] = 'Pièces jointes';
$lang['dpt_anamnesis_file'] = 'Fichier Anamnèse';
$lang['dpt_upload_anamnesis_file_help'] = 'Télécharger un fichier PDF, DOC ou DOCX pour l\'anamnèse';
$lang['dpt_existing_attachments'] = 'Pièces jointes existantes';
$lang['dpt_contact_required'] = 'Le contact est obligatoire';
$lang['dpt_contact_has_no_client'] = 'Ce contact n\'est pas associé à un client';

// Consultation Types
$lang['dpt_consultation_initial'] = 'Consultation initiale';
$lang['dpt_consultation_followup'] = 'Consultation de suivi';
$lang['dpt_consultation_emergency'] = 'Consultation d\'urgence';
$lang['dpt_consultation_final'] = 'Consultation finale';

// Consultation Status
$lang['dpt_scheduled'] = 'Programmée';
$lang['dpt_cancelled'] = 'Annulée';
$lang['dpt_no_show'] = 'Absence';

// Food Library
$lang['dpt_food_item'] = 'Aliment';
$lang['dpt_add_food_item'] = 'Ajouter un Aliment';
$lang['dpt_edit_food_item'] = 'Modifier l\'Aliment';
$lang['dpt_food_name'] = 'Nom de l\'aliment';
$lang['dpt_category'] = 'Catégorie';
$lang['dpt_serving_size'] = 'Portion (g)';
$lang['dpt_calories'] = 'Calories';
$lang['dpt_protein'] = 'Protéines';
$lang['dpt_carbs'] = 'Glucides';
$lang['dpt_fat'] = 'Lipides';
$lang['dpt_fiber'] = 'Fibres';
$lang['dpt_sugar'] = 'Sucres';
$lang['dpt_sodium'] = 'Sodium';
$lang['dpt_cholesterol'] = 'Cholestérol';
$lang['dpt_vitamins'] = 'Vitamines';
$lang['dpt_minerals'] = 'Minéraux';
$lang['dpt_allergens'] = 'Allergènes';
$lang['dpt_description'] = 'Description';
$lang['dpt_nutritional_info'] = 'Informations nutritionnelles';

// Meal Plans
$lang['dpt_meal_plan'] = 'Plan Alimentaire';
$lang['dpt_add_meal_plan'] = 'Ajouter un Plan Alimentaire';
$lang['dpt_edit_meal_plan'] = 'Modifier le Plan Alimentaire';
$lang['dpt_meal_plan_name'] = 'Nom du plan';
$lang['dpt_start_date'] = 'Date de début';
$lang['dpt_end_date'] = 'Date de fin';
$lang['dpt_target_calories'] = 'Calories cibles';
$lang['dpt_target_protein'] = 'Protéines cibles';
$lang['dpt_target_carbs'] = 'Glucides cibles';
$lang['dpt_target_fat'] = 'Lipides cibles';
$lang['dpt_meal_item'] = 'Élément de repas';
$lang['dpt_add_meal_item'] = 'Ajouter un Élément';
$lang['dpt_day_number'] = 'Jour';
$lang['dpt_meal_type'] = 'Type de repas';
$lang['dpt_meal_time'] = 'Heure du repas';
$lang['dpt_quantity'] = 'Quantité';
$lang['dpt_unit'] = 'Unité';
$lang['dpt_instructions'] = 'Instructions';

// Meal Types
$lang['dpt_meal_breakfast'] = 'Petit-déjeuner';
$lang['dpt_meal_morning_snack'] = 'Collation matinale';
$lang['dpt_meal_lunch'] = 'Déjeuner';
$lang['dpt_meal_afternoon_snack'] = 'Collation après-midi';
$lang['dpt_meal_dinner'] = 'Dîner';
$lang['dpt_meal_evening_snack'] = 'Collation soirée';

// Days
$lang['dpt_monday'] = 'Lundi';
$lang['dpt_tuesday'] = 'Mardi';
$lang['dpt_wednesday'] = 'Mercredi';
$lang['dpt_thursday'] = 'Jeudi';
$lang['dpt_friday'] = 'Vendredi';
$lang['dpt_saturday'] = 'Samedi';
$lang['dpt_sunday'] = 'Dimanche';

// Food Diary
$lang['dpt_food_diary'] = 'Journal Alimentaire';
$lang['dpt_food_entry'] = 'Entrée alimentaire';
$lang['dpt_add_food_entry'] = 'Ajouter une Entrée';
$lang['dpt_diary_date'] = 'Date';
$lang['dpt_daily_totals'] = 'Totaux journaliers';
$lang['dpt_weekly_average'] = 'Moyenne hebdomadaire';

// Goals
$lang['dpt_goal'] = 'Objectif';
$lang['dpt_goals'] = 'Objectifs';
$lang['dpt_add_goal'] = 'Ajouter un Objectif';
$lang['dpt_goal_title'] = 'Titre de l\'objectif';
$lang['dpt_target_value'] = 'Valeur cible';
$lang['dpt_current_value'] = 'Valeur actuelle';
$lang['dpt_target_date'] = 'Date cible';
$lang['dpt_frequency'] = 'Fréquence';
$lang['dpt_priority'] = 'Priorité';
$lang['dpt_completion_percentage'] = 'Pourcentage de réalisation';
$lang['dpt_goal_progress'] = 'Progression de l\'objectif';

// Frequency
$lang['dpt_daily'] = 'Quotidien';
$lang['dpt_weekly'] = 'Hebdomadaire';
$lang['dpt_monthly'] = 'Mensuel';

// Priority
$lang['dpt_low'] = 'Faible';
$lang['dpt_medium'] = 'Moyen';
$lang['dpt_high'] = 'Élevé';

// Goal Types (detailed)
$lang['dpt_goal_type_weight'] = 'Poids';
$lang['dpt_goal_type_body_fat'] = 'Masse grasse';
$lang['dpt_goal_type_measurements'] = 'Mensurations';
$lang['dpt_goal_type_nutrition'] = 'Nutrition';
$lang['dpt_goal_type_habit'] = 'Habitude';
$lang['dpt_goal_type_other'] = 'Autre';

// Achievements
$lang['dpt_achievement'] = 'Réalisation';
$lang['dpt_achievements'] = 'Réalisations';
$lang['dpt_achievement_earned'] = 'Réalisation débloquée!';
$lang['dpt_points'] = 'Points';
$lang['dpt_total_points'] = 'Total de points';
$lang['dpt_earned_date'] = 'Date d\'obtention';

// Achievement Types
$lang['dpt_achievement_first_measurement'] = 'Première mesure enregistrée';
$lang['dpt_achievement_first_week'] = 'Une semaine de suivi complétée';
$lang['dpt_achievement_weight_loss_5kg'] = 'Perte de 5 kg';
$lang['dpt_achievement_weight_loss_10kg'] = 'Perte de 10 kg';
$lang['dpt_achievement_goal_completed'] = 'Objectif atteint';
$lang['dpt_achievement_consistent_logging'] = '7 jours consécutifs de journalisation';

// Messages
$lang['dpt_message'] = 'Message';
$lang['dpt_send_message'] = 'Envoyer un message';
$lang['dpt_message_sent'] = 'Message envoyé avec succès';
$lang['dpt_unread_messages'] = 'Messages non lus';
$lang['dpt_from'] = 'De';
$lang['dpt_to'] = 'À';
$lang['dpt_sent_at'] = 'Envoyé le';

// Recipes
$lang['dpt_recipe'] = 'Recette';
$lang['dpt_recipes'] = 'Recettes';
$lang['dpt_add_recipe'] = 'Ajouter une Recette';
$lang['dpt_recipe_name'] = 'Nom de la recette';
$lang['dpt_cuisine_type'] = 'Type de cuisine';
$lang['dpt_difficulty_level'] = 'Niveau de difficulté';
$lang['dpt_prep_time'] = 'Temps de préparation';
$lang['dpt_cook_time'] = 'Temps de cuisson';
$lang['dpt_servings'] = 'Portions';
$lang['dpt_ingredients'] = 'Ingrédients';
$lang['dpt_image'] = 'Image';
$lang['dpt_tags'] = 'Tags';

// Difficulty Levels
$lang['dpt_easy'] = 'Facile';
$lang['dpt_hard'] = 'Difficile';

// Statistics
$lang['dpt_statistics'] = 'Statistiques';
$lang['dpt_total_patients'] = 'Total patients';
$lang['dpt_total_consultations'] = 'Total consultations';
$lang['dpt_upcoming_consultations'] = 'Consultations à venir';
$lang['dpt_active_goals'] = 'Objectifs actifs';
$lang['dpt_completed_goals'] = 'Objectifs complétés';
$lang['dpt_total_achievements'] = 'Total réalisations';

// Reports
$lang['dpt_generate_report'] = 'Générer un rapport';
$lang['dpt_report_period'] = 'Période du rapport';
$lang['dpt_export_pdf'] = 'Exporter en PDF';
$lang['dpt_export_excel'] = 'Exporter en Excel';
$lang['dpt_progress_report'] = 'Rapport de progression';
$lang['dpt_monthly_report'] = 'Rapport mensuel';
$lang['dpt_quarterly_report'] = 'Rapport trimestriel';

// Settings
$lang['dpt_enable_gamification'] = 'Activer la gamification';
$lang['dpt_enable_messaging'] = 'Activer la messagerie';
$lang['dpt_enable_food_diary'] = 'Activer le journal alimentaire';
$lang['dpt_default_activity_level'] = 'Niveau d\'activité par défaut';
$lang['dpt_measurement_system'] = 'Système de mesure';
$lang['dpt_notification_email'] = 'Notifications par email';
$lang['dpt_consultation_reminder_days'] = 'Rappel consultation (jours avant)';

// Common Actions
$lang['dpt_view'] = 'Voir';
$lang['dpt_edit'] = 'Modifier';
$lang['dpt_delete'] = 'Supprimer';
$lang['dpt_save'] = 'Enregistrer';
$lang['dpt_cancel'] = 'Annuler';
$lang['dpt_add'] = 'Ajouter';
$lang['dpt_search'] = 'Rechercher';
$lang['dpt_filter'] = 'Filtrer';
$lang['dpt_export'] = 'Exporter';
$lang['dpt_print'] = 'Imprimer';
$lang['dpt_back'] = 'Retour';

// Units
$lang['dpt_kg'] = 'kg';
$lang['dpt_cm'] = 'cm';
$lang['dpt_kcal'] = 'kcal';
$lang['dpt_g'] = 'g';
$lang['dpt_mg'] = 'mg';
$lang['dpt_l'] = 'L';
$lang['dpt_ml'] = 'mL';
$lang['dpt_minutes'] = 'minutes';

// Messages
$lang['dpt_no_patients'] = 'Aucun patient trouvé';
$lang['dpt_no_consultations'] = 'Aucune consultation trouvée';
$lang['dpt_no_measurements'] = 'Aucune mesure enregistrée';
$lang['dpt_no_meal_plans'] = 'Aucun plan alimentaire';
$lang['dpt_no_goals'] = 'Aucun objectif défini';
$lang['dpt_no_achievements'] = 'Aucune réalisation débloquée';
$lang['dpt_no_messages'] = 'Aucun message';
$lang['dpt_patient_not_found'] = 'Patient non trouvé';

// Dashboard
$lang['dpt_dashboard'] = 'Tableau de bord';
$lang['dpt_overview'] = 'Vue d\'ensemble';
$lang['dpt_recent_activity'] = 'Activité récente';
$lang['dpt_quick_stats'] = 'Statistiques rapides';
$lang['dpt_upcoming_events'] = 'Événements à venir';

// Notifications
$lang['dpt_notification_new_measurement'] = 'Nouvelle mesure enregistrée';
$lang['dpt_notification_consultation_reminder'] = 'Rappel de consultation';
$lang['dpt_notification_goal_achieved'] = 'Objectif atteint!';
$lang['dpt_notification_new_message'] = 'Nouveau message reçu';

// Help Text
$lang['dpt_help_bmi'] = 'L\'IMC est calculé en divisant le poids (kg) par le carré de la taille (m)';
$lang['dpt_help_bmr'] = 'Le métabolisme de base représente les calories brûlées au repos';
$lang['dpt_help_tdee'] = 'La dépense énergétique totale inclut l\'activité physique';
$lang['dpt_help_water_intake'] = 'Recommandation: 35ml par kg de poids corporel';

// Additional translations
$lang['dpt_all_time'] = 'Total';
$lang['dpt_next_7_days'] = 'Prochains 7 jours';
$lang['dpt_active_meal_plans'] = 'Plans alimentaires actifs';
$lang['dpt_recent_activity'] = 'Activité récente';
$lang['dpt_upcoming_events'] = 'Événements à venir';
$lang['dpt_date'] = 'Date';
$lang['dpt_type'] = 'Type';
$lang['dpt_created_at'] = 'Créé le';
$lang['dpt_biometric_data'] = 'Données biométriques';
$lang['dpt_select_patient_to_view_report'] = 'Sélectionnez un patient pour voir son rapport';
$lang['dpt_select_patient'] = 'Sélectionner un patient';
$lang['dpt_recent_consultations'] = 'Consultations récentes';
$lang['dpt_track_daily_meals'] = 'Suivez vos repas quotidiens';
$lang['you'] = 'Vous';
$lang['welcome'] = 'Bienvenue';
$lang['draft'] = 'Brouillon';
$lang['select'] = 'Sélectionner';
$lang['send'] = 'Envoyer';

// Programs
$lang['dpt_program'] = 'Programme';
$lang['dpt_programs'] = 'Programmes';
$lang['dpt_add_program'] = 'Ajouter un Programme';
$lang['dpt_program_name'] = 'Nom du programme';
$lang['dpt_program_type'] = 'Type de programme';
$lang['dpt_duration_weeks'] = 'Durée (semaines)';
$lang['dpt_milestones'] = 'Jalons';
$lang['dpt_add_milestone'] = 'Ajouter un Jalon';
$lang['dpt_milestone'] = 'Jalon';
$lang['dpt_program_weight_loss'] = 'Perte de poids';
$lang['dpt_program_weight_gain'] = 'Prise de poids';
$lang['dpt_program_muscle_building'] = 'Prise de masse musculaire';
$lang['dpt_program_health_improvement'] = 'Amélioration de la santé';
$lang['dpt_program_sports_nutrition'] = 'Nutrition sportive';
$lang['dpt_program_therapeutic'] = 'Programme thérapeutique';
$lang['dpt_training_frequency'] = 'Fréquence d\'entraînement';
$lang['dpt_training_type'] = 'Type d\'entraînement';

// Anamnesis
$lang['dpt_anamnesis_detailed'] = 'Anamnèse Détaillée';
$lang['dpt_create_anamnesis'] = 'Créer une Anamnèse';
$lang['dpt_current_medications'] = 'Médicaments actuels';
$lang['dpt_food_intolerances'] = 'Intolérances alimentaires';
$lang['dpt_chronic_conditions'] = 'Affections chroniques';
$lang['dpt_family_history'] = 'Antécédents familiaux';
$lang['dpt_lifestyle_habits'] = 'Habitudes de vie';
$lang['dpt_eating_habits'] = 'Habitudes alimentaires';
$lang['dpt_stress_level'] = 'Niveau de stress';
$lang['dpt_sleep_quality'] = 'Qualité du sommeil';
$lang['dpt_motivation_level'] = 'Niveau de motivation';
$lang['dpt_main_objective'] = 'Objectif principal';
$lang['dpt_secondary_objectives'] = 'Objectifs secondaires';
$lang['dpt_obstacles'] = 'Obstacles';
$lang['dpt_support_system'] = 'Système de soutien';
$lang['dpt_previous_diets'] = 'Régimes précédents';
$lang['dpt_preferences'] = 'Préférences';
$lang['dpt_budget_constraints'] = 'Contraintes budgétaires';
$lang['dpt_cooking_skills'] = 'Compétences culinaires';
$lang['dpt_meal_prep_time'] = 'Temps de préparation des repas';
$lang['dpt_stress_low'] = 'Faible';
$lang['dpt_stress_moderate'] = 'Modéré';
$lang['dpt_stress_high'] = 'Élevé';
$lang['dpt_stress_very_high'] = 'Très élevé';
$lang['dpt_sleep_poor'] = 'Mauvaise';
$lang['dpt_sleep_fair'] = 'Passable';
$lang['dpt_sleep_good'] = 'Bonne';
$lang['dpt_sleep_excellent'] = 'Excellente';
$lang['dpt_budget_low'] = 'Limité';
$lang['dpt_budget_unlimited'] = 'Illimité';
$lang['dpt_cooking_beginner'] = 'Débutant';
$lang['dpt_cooking_intermediate'] = 'Intermédiaire';
$lang['dpt_cooking_advanced'] = 'Avancé';
$lang['dpt_cooking_expert'] = 'Expert';

// Reminders
$lang['dpt_reminders'] = 'Rappels';
$lang['dpt_reminder'] = 'Rappel';
$lang['dpt_add_reminder'] = 'Ajouter un Rappel';
$lang['dpt_reminder_type'] = 'Type de rappel';
$lang['dpt_reminder_meal'] = 'Repas';
$lang['dpt_reminder_hydration'] = 'Hydratation';
$lang['dpt_reminder_medication'] = 'Médicament';
$lang['dpt_reminder_appointment'] = 'Rendez-vous';
$lang['dpt_reminder_measurement'] = 'Prise de mesures';
$lang['dpt_reminder_plan_renewal'] = 'Renouvellement du plan';
$lang['dpt_reminder_custom'] = 'Personnalisé';
$lang['dpt_time_of_day'] = 'Heure de la journée';
$lang['dpt_days_of_week'] = 'Jours de la semaine';
$lang['dpt_send_via_sms'] = 'Envoyer par SMS';
$lang['dpt_send_via_email'] = 'Envoyer par Email';
$lang['dpt_frequency_once'] = 'Une fois';
$lang['dpt_frequency_custom'] = 'Personnalisé';
$lang['dpt_paused'] = 'En pause';

// SMS
$lang['dpt_sms_settings'] = 'Paramètres SMS';
$lang['dpt_sms_enabled'] = 'SMS activé';
$lang['dpt_sms_api_key'] = 'Clé API LAM';
$lang['dpt_sms_sender_id'] = 'ID Expéditeur';
$lang['dpt_sms_api_url'] = 'URL API';
$lang['dpt_sms_logs'] = 'Journaux SMS';
$lang['dpt_sms_sent'] = 'SMS envoyé';
$lang['dpt_sms_failed'] = 'SMS échoué';
$lang['dpt_sms_pending'] = 'SMS en attente';

// GDPR & Consent
$lang['dpt_gdpr_consent'] = 'Consentement RGPD';
$lang['dpt_consent_health_data'] = 'Traitement des données de santé';
$lang['dpt_consent_data_sharing'] = 'Partage de données';
$lang['dpt_consent_marketing'] = 'Communications marketing';
$lang['dpt_consent_photography'] = 'Photographies';
$lang['dpt_consent_sms'] = 'Notifications SMS';
$lang['dpt_consent_given'] = 'Consentement donné';
$lang['dpt_consent_withdrawn'] = 'Consentement retiré';
$lang['dpt_consent_required'] = 'Consentement requis';
$lang['dpt_withdraw_consent'] = 'Retirer le consentement';
$lang['dpt_audit_log'] = 'Journal d\'audit';
$lang['dpt_view_audit_log'] = 'Voir le journal d\'audit';

// Satisfaction Surveys
$lang['dpt_satisfaction'] = 'Satisfaction';
$lang['dpt_satisfaction_survey'] = 'Enquête de satisfaction';
$lang['dpt_nps'] = 'NPS (Net Promoter Score)';
$lang['dpt_overall_satisfaction'] = 'Satisfaction globale';
$lang['dpt_communication_rating'] = 'Évaluation communication';
$lang['dpt_expertise_rating'] = 'Évaluation expertise';
$lang['dpt_plan_quality_rating'] = 'Qualité du plan';
$lang['dpt_waiting_time_rating'] = 'Temps d\'attente';
$lang['dpt_would_recommend'] = 'Recommanderiez-vous?';
$lang['dpt_positive_feedback'] = 'Retours positifs';
$lang['dpt_negative_feedback'] = 'Points d\'amélioration';
$lang['dpt_complete_survey'] = 'Compléter l\'enquête';
$lang['dpt_survey_completed'] = 'Enquête complétée';
$lang['dpt_survey_pending'] = 'Enquête en attente';
$lang['dpt_thank_you_feedback'] = 'Merci pour votre retour!';

// Dietitians
$lang['dpt_dietitians'] = 'Diététiciens';
$lang['dpt_specialties'] = 'Spécialités';
$lang['dpt_qualifications'] = 'Qualifications';
$lang['dpt_license_number'] = 'Numéro de licence';
$lang['dpt_consultation_fee'] = 'Tarif consultation';
$lang['dpt_availability'] = 'Disponibilité';
$lang['dpt_max_patients'] = 'Maximum de patients';
$lang['dpt_on_leave'] = 'En congé';

// Dashboard & KPIs
$lang['dpt_kpi_adherence_rate'] = 'Taux d\'adhérence';
$lang['dpt_kpi_avg_weight_change'] = 'Δ poids moyen';
$lang['dpt_kpi_consultations_ratio'] = 'Ratio consultations tenues/planifiées';
$lang['dpt_kpi_avg_nps'] = 'NPS moyen';
$lang['dpt_kpi_revenue_per_dietitian'] = 'Revenu par diététicien';
$lang['dpt_adherence_by_day'] = 'Adhérence par jour';
$lang['dpt_weight_evolution'] = 'Évolution du poids';
$lang['dpt_funnel_lead_to_patient'] = 'Funnel Lead → Patient';

// Tab in Client Profile
$lang['dpt_dietary_tracking'] = 'Suivi Diététique';
$lang['dpt_no_contacts'] = 'Aucun contact pour ce client';
$lang['dpt_no_patient_profile_for_client'] = 'Aucun profil patient n\'a été créé pour ce client';
$lang['dpt_create_patient_profile'] = 'Créer un profil patient';
$lang['dpt_view_full_profile'] = 'Voir le profil complet';
$lang['dpt_new_consultation'] = 'Nouvelle consultation';

// Exports
$lang['dpt_export_csv'] = 'Exporter CSV';
$lang['dpt_export_xlsx'] = 'Exporter Excel';
$lang['dpt_generate_pdf'] = 'Générer PDF';
$lang['dpt_export_report'] = 'Exporter le rapport';
$lang['dpt_download_plan_pdf'] = 'Télécharger le plan (PDF)';

// Notifications
$lang['dpt_cron_enabled'] = 'Tâches automatiques activées';
$lang['dpt_cron_disabled'] = 'Tâches automatiques désactivées';
$lang['dpt_last_cron_run'] = 'Dernière exécution CRON';

// Status messages
$lang['dpt_pending'] = 'En attente';
$lang['dpt_on_hold'] = 'En suspens';
$lang['dpt_failed'] = 'Échec';
$lang['dpt_sent'] = 'Envoyé';
$lang['dpt_achieved'] = 'Atteint';
