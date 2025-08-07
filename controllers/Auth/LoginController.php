<?php

class LoginController
{
    function login()
    {
        $error   = $_SESSION['error'] ?? null;
        $success   = $_SESSION['success'] ?? null;
        unset($_SESSION['error'], $_SESSION['success']);
        require_once './views/auth/login.view.php';
    }

    function loginPost($connection)
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $email = trim($_POST['email'] ?? '');
            $password = trim($_POST['password'] ?? '');

            if (empty($email) || empty($password)) {
                $_SESSION['error'] = 'Por favor rellene los campos';
                header('Location: ' . URL_BASE . '?controller=auth/login&action=login');
                exit;
            }

            require_once './models/User/User.php';
            $userModel = new User();

            $user = $userModel->findUserByEmail($connection, $email);

            if ($user && password_verify($password, $user['password'])) {
                if ($user['status'] !== 'active') {
                    $_SESSION['error'] = 'Usuario sin membresía activa';
                    header('Location: ' . URL_BASE . '?controller=auth/login&action=login');
                    exit;
                } else {
                    $_SESSION['user_id']    = $user['id'];
                    $_SESSION['user_name']  = $user['name'];
                    $_SESSION['user_email'] = $user['email'];

                    header('Location: ' . URL_BASE . '?controller=dashboard/dashboard&action=home');
                    exit;
                }
            } else {
                $_SESSION['error'] = 'Credenciales incorrectas';
                header('Location: ' . URL_BASE . '?controller=auth/login&action=login');
                exit;
            }
        }
    }
}
