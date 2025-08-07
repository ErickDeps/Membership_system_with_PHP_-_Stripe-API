<?php

class DashboardController
{
    function home($connection)
    {
        sessionValidate();
        require_once './models/User/User.php';
        require_once './models/Membership/Membership.php';
        $userModel = new User();
        $membershipModel = new Membership();

        $user_id = $_SESSION['user_id'] ?? null;
        $user_name = ucfirst($_SESSION['user_name']) ?? null;
        $user_email = ($_SESSION['user_email']) ?? null;

        $userMembership = $userModel->findUserMembership($connection, $user_id);
        $membership = $membershipModel->findMembershipById($connection, $userMembership['membership_id']);
        require_once './views/Dashboard/home.view.php';
    }

    function logout()
    {
        sessionValidate();
        $_SESSION = array();

        session_destroy();

        header('Location: ' . URL_BASE . '?controller=Auth/login&action=login');
        exit;
    }
}
