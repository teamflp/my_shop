<?php

namespace controllers;

use models\User;
use models\Dashboard;

class DashboardController
{
    private User $userModel;
    private Dashboard $dashboardModel;

    public function __construct()
    {
        // L'autoloader (probablement dans init.php) devrait gérer les inclusions.
        // require_once __DIR__ . '/../models/Dashboard.php';
        // require_once __DIR__ . '/../models/User.php';

        $this->dashboardModel = new Dashboard();
        $this->userModel = new User();
    }

    /**
     * Display the admin dashboard with statistics and latest users
     */
    public function show(): void
    {
        // Optional: Check if the user is admin
        if (method_exists('\models\Auth', 'isAdmin') && !\models\Auth::isAdmin()) {
            die('Forbidden');
        }

        // Utilise le modèle Dashboard pour récupérer les statistiques en une seule requête optimisée.
        $dbStats = $this->dashboardModel->getStatistics();
        $stats = [
            'products' => $dbStats['product_count'],
            'categories' => $dbStats['category_count'],
            'users' => $dbStats['user_count']
        ];

        $latestUsers = $this->dashboardModel->getLatestUsers(5); // Récupère les derniers utilisateurs de manière optimisée.
        $allUsers = $this->userModel->readAll(); // Récupère tous les utilisateurs pour la table de gestion.

        require_once __DIR__ . '/../views/admin_dashboard.php';
    }
}