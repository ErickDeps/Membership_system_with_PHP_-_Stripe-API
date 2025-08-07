<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once __DIR__ . '/vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

include_once 'core/connection.php';
include_once 'config/config.php';
require_once 'helpers/helpers.php';
include_once 'core/router.php';


router($connection);
