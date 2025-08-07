<?php
require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/core/connection.php';
require_once __DIR__ . '/models/User/User.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

\Stripe\Stripe::setApiKey($_ENV['STRIPE_SECRET_KEY']);

$endpoint_secret = $_ENV['STRIPE_WEBHOOK_SECRET'];

$payload = @file_get_contents('php://input');

$sig_header = $_SERVER['HTTP_STRIPE_SIGNATURE'] ?? '';

try {
    $event = \Stripe\Webhook::constructEvent(
        $payload,
        $sig_header,
        $endpoint_secret
    );

    if ($event->type === 'checkout.session.completed') {
        $session = $event->data->object;

        $userId = $session->metadata->user_id ?? null;
        $membershipId = $session->metadata->membership_id ?? null;

        if ($userId && $membershipId) {
            $userModel = new User();
            $userModel->createUserMembership($connection, $userId, $membershipId);
        }
    }

    http_response_code(200);
} catch (\UnexpectedValueException $e) {
    file_put_contents('logs/log.txt', "Error de valor inesperado: " . $e->getMessage() . "\n", FILE_APPEND);
    http_response_code(400);
    exit();
} catch (\Stripe\Exception\SignatureVerificationException $e) {
    file_put_contents('logs/log.txt', "Firma inválida: " . $e->getMessage() . "\n", FILE_APPEND);
    http_response_code(400);
    exit();
}
