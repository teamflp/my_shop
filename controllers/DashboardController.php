<?php

namespace controllers;

use models\Dashboard;

class DashboardController
{
    private Dashboard $dashboardModel;

    public function __construct()
    {
        $this->dashboardModel = new Dashboard();
    }

    /**
     * Display the admin dashboard with statistics
     */
    public function show(): void
    {
        $stats = $this->dashboardModel->getStatistics();
        require_once __DIR__ . '/../views/admin_dashboard.php';
    }
}