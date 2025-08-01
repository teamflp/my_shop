<?php

// Démarrer la session
session_start();

// Chargement de la configuration
require_once 'config/config.php';
require_once 'config/text_constants.php';

// Autoloader
spl_autoload_register(function ($class_name) {
    // Construire le chemin du fichier PHP
    $class_path = str_replace('\\', '/', $class_name);
    $file = __DIR__ . '/' . $class_path . '.php';
    if (file_exists($file)) {
        require_once $file;
    }
});
