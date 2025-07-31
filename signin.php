<?php

require_once 'init.php';

use controllers\UserController;

$controller = new UserController();
$controller->login();
