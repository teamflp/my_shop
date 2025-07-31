<?php

// Start the session
session_start();

// Include configuration
require_once 'config/config.php';

// Autoloader
spl_autoload_register(function ($class_name) {
    // Replace namespace separators with directory separators
    $class_path = str_replace('\\', '/', $class_name);
    $file = __DIR__ . '/' . $class_path . '.php';
    if (file_exists($file)) {
        require_once $file;
    }
});
