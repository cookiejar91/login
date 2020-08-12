<?php

declare(strict_types=1);

error_reporting(E_ALL);
require_once 'classes/Router.php';

$router = new Router();
$action = isset($_REQUEST['action']) ? $_REQUEST['action'] : null;
$parameters = $_REQUEST;

$router->route($action);


