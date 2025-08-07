<?php


function sessionValidate()
{
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    if (!isset($_SESSION['user_id'])) {
        header('Location: ' . URL_BASE . '?controller=Auth/login&action=login');
        exit;
    }
}
