<?php

namespace controllers;

use models\Dashboard;
use models\User;

class DashboardController
{
    private Dashboard $dashboardModel;
    private User $userModel;

    public function __construct()
    {
        if (!class_exists('models\Database')) {
            require_once __DIR__ . '/../models/Database.php';
        }
        $this->dashboardModel = new Dashboard();
        $this->userModel = new User();
    }

    /**
     * Afficher le tableau de bord administrateur avec les statistiques et les derniers utilisateurs
     */
    public function show(): void
    {
        $stats = $this->dashboardModel->getStatistics();
        $latestUsers = $this->dashboardModel->getLatestUsers();
        $allUsers = $this->userModel->readAll(); // Récupère tous les utilisateurs
        require_once __DIR__ . '/../views/admin_dashboard.php';
    }
}

