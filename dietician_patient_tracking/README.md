# Module Suivi Diététicien-Patient pour Perfex CRM

## 📋 Description

Module complet de gestion et suivi nutritionnel pour diététiciens et leurs patients, intégré à Perfex CRM. Ce module permet un suivi détaillé de l'évolution des patients, la création de plans alimentaires personnalisés, et une communication directe diététicien-patient.

## ✨ Fonctionnalités Principales

### 🏥 Gestion des Patients

- **Profils patients complets** liés aux contacts Perfex CRM
- Informations médicales : antécédents, allergies, restrictions alimentaires
- Objectifs nutritionnels personnalisés
- Niveau d'activité physique
- Photos de profil et suivi photographique

### 📊 Mesures et Calculs Biométriques

- **Suivi évolutif** : poids, mensurations, composition corporelle
- **Calculs automatiques** :
  - IMC (Indice de Masse Corporelle)
  - MB (Métabolisme de Base) - équation Mifflin-St Jeor
  - TDEE (Dépense Énergétique Totale)
  - Pourcentage de masse grasse - méthode US Navy
  - Ratio taille/hanches
  - Recommandations hydriques
- **Graphiques d'évolution** interactifs
- **Plage de poids idéal** calculée automatiquement
- Photos avant/après pour suivi visuel

### 🍽️ Plans Alimentaires

- **Création de menus personnalisés** par jour et repas
- **Bibliothèque alimentaire** complète avec valeurs nutritionnelles
- Calcul automatique des **macronutriments** (protéines, glucides, lipides)
- Suivi des **objectifs caloriques** quotidiens
- **Export PDF** des plans alimentaires
- Base de données alimentaire pré-remplie (extensible)

### 📝 Journal Alimentaire

- **Saisie quotidienne** des repas par les patients
- Analyse automatique des apports nutritionnels
- Totaux journaliers et moyennes hebdomadaires
- Recherche d'aliments dans la base de données
- Interface intuitive par type de repas

### 👨‍⚕️ Consultations

- **Calendrier** des rendez-vous
- **Notes de consultation** détaillées
- Anamnèse et diagnostic
- Recommandations nutritionnelles
- Lien avec les projets Perfex CRM
- Rappels automatiques par email

### 🎯 Objectifs et Suivi

- **Définition d'objectifs** personnalisés
- Suivi de progression avec pourcentages
- Objectifs hebdomadaires/mensuels
- Système de priorités
- Historique des progressions

### 🏆 Gamification

- **Système de badges** et réalisations
- Points attribués pour :
  - Première mesure enregistrée
  - Une semaine de suivi complétée
  - Pertes de poids (5kg, 10kg)
  - Objectifs atteints
  - Journalisation régulière (7 jours consécutifs)
- Motivation et engagement des patients

### 💬 Messagerie

- **Communication directe** diététicien-patient
- Notifications de nouveaux messages
- Historique des conversations
- Support des pièces jointes

### 📈 Rapports et Statistiques

- **Tableaux de bord** interactifs
- Statistiques globales par diététicien
- Rapports d'évolution mensuels/trimestriels
- Export Excel/PDF
- Graphiques comparatifs avant/après

### 🍳 Recettes Santé (Bonus)

- **Bibliothèque de recettes** nutritionnelles
- Temps de préparation et cuisson
- Niveau de difficulté
- Valeurs nutritionnelles calculées
- Tags et catégories
- Images des plats

### 🔗 Intégration Perfex CRM

- **Lien automatique** avec les contacts
- Intégration dans la section Projets
- Gestion des permissions par rôle
- Notifications par email
- Espace client personnalisé

## 🎨 Interface Utilisateur

### Espace Diététicien (Admin)

- **Dashboard** : Vue d'ensemble des patients, consultations à venir, statistiques
- **Gestion patients** : Profils complets, historique, mesures
- **Consultations** : Planification, notes, suivi
- **Plans alimentaires** : Création, modification, assignation
- **Bibliothèque** : Aliments, recettes
- **Rapports** : Analyses et exports

### Espace Patient (Client)

- **Mon Suivi** : Dashboard personnel avec métriques clés
- **Mes Mesures** : Saisie et historique
- **Journal Alimentaire** : Enregistrement quotidien
- **Mes Plans** : Consultation des plans alimentaires assignés
- **Mes Objectifs** : Suivi de progression
- **Mes Consultations** : Historique et compte-rendus
- **Réalisations** : Badges et points gagnés
- **Messages** : Communication avec le diététicien

## 📦 Installation

### Prérequis

- Perfex CRM version 2.3.0 ou supérieure
- PHP 7.4 ou supérieur
- MySQL 5.7 ou supérieur

### Instructions

1. **Télécharger** le module `dietician_patient_tracking`

2. **Copier** le dossier dans `/modules/` de votre installation Perfex CRM

3. **Activer** le module depuis :
   ```
   Configuration → Modules → Dietician Patient Tracking → Activer
   ```

4. **Configuration initiale** :
   - Aller dans Diététicien-Patient → Paramètres
   - Configurer les options par défaut
   - Activer/désactiver les fonctionnalités selon vos besoins

5. **Permissions** :
   - Configuration → Rôles
   - Attribuer les permissions "Dietician Patient Tracking" aux rôles appropriés

## 🔧 Configuration

### Paramètres Disponibles

| Paramètre | Description | Valeur par défaut |
|-----------|-------------|-------------------|
| Gamification | Activer le système de badges et points | Activé |
| Messagerie | Permettre la communication patients-diététiciens | Activé |
| Journal alimentaire | Permettre aux patients de tenir un journal | Activé |
| Niveau d'activité par défaut | Niveau d'activité initial pour nouveaux patients | Modérément actif |
| Système de mesure | Métrique (kg/cm) ou Impérial (lb/in) | Métrique |
| Notifications email | Envoyer des rappels par email | Activé |
| Rappel consultation | Nombre de jours avant rappel | 3 jours |

### Permissions

- **View** : Voir les données des patients
- **Create** : Créer de nouveaux patients et données
- **Edit** : Modifier les informations existantes
- **Delete** : Supprimer des enregistrements

## 💻 Structure Technique

### Base de Données

Le module crée automatiquement 12 tables :

- `dpt_patient_profiles` : Profils patients
- `dpt_measurements` : Mesures corporelles
- `dpt_consultations` : Consultations et rendez-vous
- `dpt_food_library` : Bibliothèque d'aliments
- `dpt_meal_plans` : Plans alimentaires
- `dpt_meal_plan_items` : Détails des plans
- `dpt_food_diary` : Journal alimentaire
- `dpt_goals` : Objectifs patients
- `dpt_goal_progress` : Progressions
- `dpt_achievements` : Réalisations débloquées
- `dpt_messages` : Messages
- `dpt_recipes` : Recettes
- `dpt_settings` : Paramètres du module

### Architecture MVC

```
dietician_patient_tracking/
├── controllers/
│   ├── Dietician_patient_tracking.php  # Contrôleur admin
│   └── Client.php                       # Contrôleur client
├── models/
│   └── Dietician_patient_tracking_model.php
├── views/
│   ├── admin/                           # Vues admin
│   └── client/                          # Vues client
├── language/
│   ├── french/                          # Traductions FR
│   └── english/                         # Traductions EN
├── assets/
│   ├── css/                             # Styles
│   └── js/                              # Scripts
├── helpers/
│   └── dietician_patient_tracking_helper.php
├── install.php                          # Script d'installation
└── dietician_patient_tracking.php      # Fichier principal
```

## 🔬 Calculs et Formules

### IMC (Indice de Masse Corporelle)
```
IMC = poids (kg) / taille² (m)
```

### Métabolisme de Base (Mifflin-St Jeor)
**Homme** : MB = (10 × poids) + (6,25 × taille) - (5 × âge) + 5
**Femme** : MB = (10 × poids) + (6,25 × taille) - (5 × âge) - 161

### TDEE (Dépense Énergétique Totale)
```
TDEE = MB × Facteur d'activité
```
- Sédentaire : 1,2
- Légèrement actif : 1,375
- Modérément actif : 1,55
- Très actif : 1,725
- Extrêmement actif : 1,9

### Masse Grasse (US Navy)
**Homme** :
`MG% = 495 / (1,0324 - 0,19077 × log10(taille - cou) + 0,15456 × log10(hauteur)) - 450`

**Femme** :
`MG% = 495 / (1,29579 - 0,35004 × log10(taille + hanches - cou) + 0,22100 × log10(hauteur)) - 450`

### Apport Hydrique Recommandé
```
Eau (L) = poids (kg) × 0,035 × facteur d'activité
```

### Répartition des Macronutriments

Selon l'objectif :

| Objectif | Protéines | Glucides | Lipides |
|----------|-----------|----------|---------|
| Perte de poids | 35% | 35% | 30% |
| Prise de poids | 30% | 45% | 25% |
| Prise de muscle | 40% | 40% | 20% |
| Maintien | 30% | 40% | 30% |
| Santé générale | 25% | 45% | 30% |

## 🎯 Cas d'Usage

### Scénario 1 : Nouveau Patient

1. Le diététicien crée un profil patient lié à un contact Perfex
2. Renseigne les informations médicales et objectifs
3. Effectue les premières mesures (poids, taille, mensurations)
4. Le système calcule automatiquement IMC, MB, TDEE
5. Création d'un plan alimentaire personnalisé
6. Le patient reçoit un email avec ses accès

### Scénario 2 : Suivi Régulier

1. Le patient se connecte à son espace
2. Enregistre son poids et mensurations
3. Remplit son journal alimentaire quotidien
4. Consulte ses graphiques d'évolution
5. Débloque des badges (motivation)
6. Prépare des questions pour la prochaine consultation

### Scénario 3 : Consultation

1. Rendez-vous programmé dans le calendrier
2. Le diététicien consulte le dossier complet
3. Analyse l'évolution depuis la dernière visite
4. Note les observations et recommandations
5. Ajuste le plan alimentaire si nécessaire
6. Définit de nouveaux objectifs
7. Le patient consulte le compte-rendu dans son espace

## 🌟 Suggestions de Fonctionnalités Futures

### Phase 2 (Extensions possibles)

- 🔔 **Notifications push** sur mobile
- 📱 **Application mobile** dédiée
- 🔗 **Intégration balances connectées** (Fitbit, Withings, Apple Health)
- 🤖 **IA pour suggestions** de repas
- 📸 **Reconnaissance d'aliments** par photo
- 🛒 **Liste de courses** générée automatiquement
- 👥 **Groupes de patients** pour défis collectifs
- 📚 **Base de connaissances** nutritionnelles
- 🎓 **Modules éducatifs** interactifs
- 💳 **Intégration paiements** pour consultations
- 📅 **Prise de rendez-vous en ligne**
- 🌍 **Support multi-langues** étendu

### Intégrations Tierces

- API MyFitnessPal
- API Nutritionix
- Apple HealthKit
- Google Fit
- Samsung Health
- Oura Ring
- Garmin Connect

## 🛠️ Support et Maintenance

### Mises à Jour

Le module est conçu pour être facilement maintenable :

- Structure MVC claire
- Code documenté
- Hooks Perfex CRM respectés
- Base de données optimisée
- Responsive design

### Compatibilité

- ✅ Perfex CRM 2.3.0+
- ✅ PHP 7.4 - 8.2
- ✅ MySQL 5.7+
- ✅ MariaDB 10.2+

### Navigateurs Supportés

- Chrome (dernières versions)
- Firefox (dernières versions)
- Safari 12+
- Edge (Chromium)

## 📄 Licence

Ce module est propriétaire. Tous droits réservés.

## 👨‍💻 Développeur

Développé pour Perfex CRM
Version : 1.0.0
Date : 2025

## 📞 Contact

Pour toute question ou demande de personnalisation, veuillez contacter le développeur.

---

## 🚀 Démarrage Rapide

### Pour les Diététiciens

1. **Activer le module** dans Configuration → Modules
2. **Configurer les permissions** pour votre équipe
3. **Ajouter des patients** depuis Diététicien-Patient → Patients
4. **Compléter la bibliothèque alimentaire** selon vos habitudes
5. **Créer vos premiers plans** alimentaires

### Pour les Patients

1. **Recevoir l'invitation** par email
2. **Se connecter** à l'espace client
3. **Compléter son profil**
4. **Enregistrer ses premières mesures**
5. **Commencer le journal alimentaire**
6. **Suivre ses objectifs** et progressions

## 📊 Captures d'Écran

*(Les captures d'écran seraient ajoutées ici dans une version finale)*

## 🎓 Ressources

### Documentation

- Guide administrateur complet (à venir)
- Manuel utilisateur patient (à venir)
- Guide de démarrage rapide (à venir)
- FAQ (à venir)

### Tutoriels Vidéo

- Installation et configuration (à venir)
- Créer un profil patient (à venir)
- Élaborer un plan alimentaire (à venir)
- Utiliser l'espace patient (à venir)

---

**Note** : Ce module est conçu comme un outil d'aide à la pratique professionnelle. Il ne remplace pas l'expertise médicale d'un professionnel de santé qualifié.
