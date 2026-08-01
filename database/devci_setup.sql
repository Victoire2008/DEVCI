-- DevCI – Script SQL de création de base de données
-- Exécuter dans phpMyAdmin ou MySQL CLI avant le premier lancement

CREATE DATABASE IF NOT EXISTS `devci`
    CHARACTER SET utf8mb4
    COLLATE utf8mb4_unicode_ci;

USE `devci`;

-- Puis lancer : php artisan migrate && php artisan db:seed
