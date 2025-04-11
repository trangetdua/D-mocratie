# 📢 Projet SAES3 - Démocratie Participative

Bienvenue dans l'application web de **Démocratie Participative** développée dans le cadre du SAES3 à l'IUT d'Orsay.

## 📌 Objectif

Ce projet vise à permettre à des utilisateurs de :
- Créer et gérer des groupes (associatifs, environnementaux, etc.)
- Déposer des **propositions** de projets
- Voter sur des propositions via différents types de scrutin
- Gérer des **notifications** (ex : invitations, rappels, etc.)
- Assurer une gestion des rôles : administrateur, modérateur, membre, etc.

## 🗂️ Structure du projet

```
/
├── modele/                 # Fichiers de traitement (API, logique serveur)
│   └── inscription.php
│   └── sendInvitation.php
│   └── handleAccept.php
├── vue/                    # Fichiers d'affichage / interfaces utilisateurs
│   └── accueil_groupe.php
│   └── invitation.php
│   └── register.php
│   └── connection.php
│   └── votes_en_cours.php, etc.
├── controller/             # Contrôleur API pour accès aux données
│   └── api.php
├── css/                    # Fichiers de styles
├── js/                     # Scripts JS (notification, interaction…)
└── config/
    └── connexion.php       # Connexion PDO à la base de données
```

## 🧑‍💻 Fonctionnalités principales

- 🔐 Authentification & inscription avec vérification d’unicité des emails
- 🧑‍🤝‍🧑 Gestion des groupes et des membres (invitations, rôles, etc.)
- 🗳️ Création, consultation et vote sur les propositions
- 🔔 Système de notifications personnalisées (invitation, vote à venir…)
- 🧾 Historique des votes et propositions terminées
- 👤 Rôles utilisateurs : administrateur, membre, modérateur, etc.

## 🛠️ Technologies utilisées

- PHP (API + back-end logique)
- MySQL (Base de données relationnelle)
- HTML/CSS + JavaScript (interfaces utilisateur)
- cURL pour appel API interne
- Architecture MVC simplifiée

## 🧪 Données de test

Des utilisateurs, groupes, propositions, votes et rôles sont pré-remplis dans la base. Vous pouvez modifier ou réinitialiser la base via les requêtes `INSERT` fournies.

## 👥 Auteurs

- Étudiantes de BUT Informatique - IUT d'Orsay
- Projet SAES3 - 2024/2025

