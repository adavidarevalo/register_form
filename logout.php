<?php
require_once 'assets/db/config.php';
require_once 'controllers/UserController.php';

$userController = new UserController($connect);
$userController->logout();
?>
