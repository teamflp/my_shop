<?php

require_once 'init.php';

use models\Auth;

Auth::logout();

// Redirect to home page after logout
header("Location: index.php");
exit();
