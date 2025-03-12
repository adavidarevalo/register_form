<?php
require_once 'config/db/config.php';
require_once 'controllers/UserController.php';

$userController = new UserController($connect);
$userController->register();
?>
