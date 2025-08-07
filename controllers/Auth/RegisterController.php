<?php

class RegisterController
{

    function register()
    {

        $error   = $_SESSION['error'] ?? null;
        unset($_SESSION['success'], $_SESSION['error']);
        require_once './views/auth/register.view.php';
    }

    function registerProcess($connection)
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            require 'vendor/autoload.php';
            require_once './models/User/User.php';
            require_once './models/Membership/Membership.php';
            $userModel = new User();
            $membershipModel = new Membership();

            \Stripe\Stripe::setApiKey($_ENV['STRIPE_SECRET_KEY']);

            $name = $_POST['name'] ?? null;
            $email = $_POST['email'] ?? null;
            $password = $_POST['password'] ?? null;
            $membership_id = $_POST['membership_id'] ?? null;

            if (empty($name) || empty($email) || empty($password) || $membership_id == null) {
                $_SESSION['error'] = 'Por favor rellene todos los campos.';
                header('Location: ' . URL_BASE . '?controller=auth/register&action=register');
                exit;
            }

            $user = $userModel->findUserByEmail($connection, $email);

            if (!$user) {
                $user_id = $userModel->createUser($connection, $name, $email, $password);

                $membership = $membershipModel->findMembershipById($connection, $membership_id);

                if (!$membership) die("Membresía no encontrada");

                $session = \Stripe\Checkout\Session::create([
                    'payment_method_types' => ['card'],
                    'line_items' => [[
                        'price' => $membership['stripe_price_id'],
                        'quantity' => 1,
                    ]],
                    'mode' => 'payment',
                    'success_url' => URL_BASE . '?controller=auth/register&action=successRegisterPage',
                    'cancel_url' => URL_BASE . '?controller=auth/register&action=register',
                    'metadata' => [
                        'user_id' => $user_id,
                        'membership_id' => $membership['id']
                    ]
                ]);

                header("Location: " . $session->url);
            } else {
                $_SESSION['error'] = 'El correo ya está registrado';
                header('Location: ' . URL_BASE . '?controller=auth/register&action=register');
                exit;
            }
        }
    }


    public function successRegisterPage()
    {
        $_SESSION['success'] = 'Registrado correctamente. ¡Membresía activada!';
        header('Location: ' . URL_BASE . '?controller=auth/login&action=login');
    }
}
