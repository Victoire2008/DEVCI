# 🇨🇮 DevCI – Plateforme Freelance Côte d'Ivoire

> Plateforme web Laravel de mise en relation entre développeurs freelances et clients en Côte d'Ivoire, avec messagerie intégrée et paiement mobile (Wave & Orange Money).

---

## 📋 Table des matières

- [Aperçu](#aperçu)
- [Fonctionnalités](#fonctionnalités)
- [Stack technique](#stack-technique)
- [Installation](#installation)
- [Configuration](#configuration)
- [Comptes de démo](#comptes-de-démo)
- [Structure du projet](#structure-du-projet)
- [Paiement mobile](#paiement-mobile)
- [Roadmap](#roadmap)

---

## Aperçu

DevCI connecte des **clients** (entreprises, startups, particuliers) avec des **développeurs freelances** vérifiés en Côte d'Ivoire. La plateforme permet de :

- Parcourir et filtrer les profils développeurs
- Envoyer des demandes de projet
- Communiquer via une messagerie en temps réel (AJAX polling)
- Payer les prestations via Wave CI ou Orange Money

---

## ✅ Fonctionnalités

| Module | Détail |
|---|---|
| **Authentification** | Inscription client/développeur, connexion, déconnexion sécurisée |
| **Profils développeurs** | Photo, bio, compétences, portfolio, tarif, disponibilité, réseaux sociaux |
| **Services** | Développeurs : création, édition, suppression de leurs offres |
| **Recherche & Filtres** | Par compétence, disponibilité, tarif max, recherche textuelle |
| **Mise en relation** | Formulaire de contact → conversation automatique |
| **Messagerie (Chat)** | Bulles de discussion, envoi AJAX, polling toutes les 3 secondes |
| **Tableau de bord** | Statistiques, conversations, paiements récents |
| **Paiements** | Wave CI et Orange Money (mode démo sans clé API) |
| **Notifications** | Compteur de messages non lus dans la navbar |

---

## 🛠 Stack technique

- **Backend** : Laravel 10 (PHP 8.1+)
- **Base de données** : MySQL 8 / MariaDB
- **Frontend** : Blade, Bootstrap 5.3, Bootstrap Icons
- **Fonts** : Inter + Space Grotesk (Google Fonts)
- **Paiement** : Wave CI API, Orange Money WebPay CI
- **Auth** : Laravel Session Auth
- **Chat** : AJAX polling (toutes les 3 s)

---

## 🚀 Installation

### Prérequis

- PHP >= 8.1
- Composer
- MySQL / MariaDB
- Node.js (optionnel)

### Étapes

```bash
# 1. Cloner / décompresser le projet
cd devci

# 2. Installer les dépendances PHP
composer install

# 3. Copier le fichier d'environnement
cp .env.example .env

# 4. Générer la clé d'application
php artisan key:generate

# 5. Créer un lien symbolique pour le storage
php artisan storage:link

# 6. Migrer la base de données
php artisan migrate

# 7. (Optionnel) Charger les données de démo
php artisan db:seed

# 8. Lancer le serveur de développement
php artisan serve
```

Accédez ensuite à : **http://localhost:8000**

---

## ⚙️ Configuration

Éditez le fichier `.env` :

```env
APP_NAME=DevCI
APP_URL=http://localhost:8000

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=devci
DB_USERNAME=root
DB_PASSWORD=votre_mot_de_passe

MAIL_MAILER=smtp
MAIL_FROM_ADDRESS="noreply@devci.ci"

# Wave CI (https://developer.wave.com)
WAVE_API_KEY=your_wave_api_key

# Orange Money CI (https://developer.orange.com)
ORANGE_MONEY_MERCHANT_KEY=your_merchant_key
ORANGE_MONEY_AUTH_HEADER=your_base64_auth_header
```

### Avec XAMPP (Windows/macOS)

1. Placez le dossier `devci` dans `htdocs/`
2. Créez la base `devci` dans phpMyAdmin
3. Configurez `.env` avec vos identifiants MySQL
4. Accédez via : `http://localhost/devci/public`

---

## 👤 Comptes de démo

Après `php artisan db:seed` :

| Rôle | Email | Mot de passe |
|------|-------|--------------|
| Client | client@devci.ci | password |
| Développeur | dev1@devci.ci | password |
| Développeur | dev2@devci.ci | password |
| Développeur | dev3@devci.ci | password |
| Développeur | dev4@devci.ci | password |
| Développeur | dev5@devci.ci | password |
| Développeur | dev6@devci.ci | password |

---

## 📁 Structure du projet

```
devci/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Auth/AuthController.php
│   │   │   ├── HomeController.php
│   │   │   ├── DeveloperController.php
│   │   │   ├── DashboardController.php
│   │   │   ├── ChatController.php
│   │   │   ├── ProfileController.php
│   │   │   └── PaymentController.php
│   │   └── Middleware/
│   │       └── RoleMiddleware.php
│   └── Models/
│       ├── User.php
│       ├── Profil.php
│       ├── Service.php
│       ├── Conversation.php
│       ├── Message.php
│       └── Paiement.php
├── database/
│   ├── migrations/          # 6 migrations
│   └── seeders/
│       └── DatabaseSeeder.php
├── public/
│   ├── css/app.css          # Styles complets DevCI
│   ├── js/app.js
│   └── images/              # ← Déposez vos images ici
├── resources/views/
│   ├── layouts/app.blade.php
│   ├── home/index.blade.php
│   ├── auth/{login,register}.blade.php
│   ├── developers/{index,show}.blade.php
│   ├── dashboard/{client,developer}.blade.php
│   ├── chat/{index,show}.blade.php
│   ├── profile/{edit,services}.blade.php
│   └── payments/{index,show}.blade.php
├── routes/web.php
├── .env.example
└── composer.json
```

---

## 🖼️ Espace Logo

Placez votre logo ici :
```
public/images/logo.png        ← Logo principal (hauteur recommandée : 38px)
public/images/favicon.png     ← Favicon (32×32 px)
public/images/default-avatar.png  ← Avatar par défaut
```

Le navbar affiche automatiquement `logo.png`. Si le fichier est absent, le texte **DevCI** s'affiche à la place.

---

## 💳 Paiement mobile

### Wave CI
- Créez un compte développeur sur [developer.wave.com](https://developer.wave.com)
- Ajoutez `WAVE_API_KEY` dans `.env`
- Le callback est configuré sur `/payments/callback/wave`

### Orange Money CI
- Inscrivez-vous sur [developer.orange.com](https://developer.orange.com)
- Configurez `ORANGE_MONEY_MERCHANT_KEY` et `ORANGE_MONEY_AUTH_HEADER`
- Le callback est sur `/payments/callback/orange`

> **Mode démo** : Sans clé API, les paiements fonctionnent en mode simulation — un message d'info s'affiche à la place de la redirection opérateur.

---

## 🗺 Roadmap

- [ ] Application mobile (Flutter)
- [ ] Système de notation des développeurs
- [ ] Recommandations par IA
- [ ] Vérification des profils (badge vérifié)
- [ ] Notifications en temps réel (WebSocket/Pusher)
- [ ] Système de litiges / remboursement
- [ ] Tableau de bord admin

---

## 📞 Support

Pour toute question, ouvrez une issue ou contactez : **victoirebamba1@gmail.com**

---

*Développé, pour l'écosystème numérique ivoirien*
