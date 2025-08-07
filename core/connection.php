<?php
$host = $_ENV['DB_HOST'] ?? '127.0.0.1';
$db = $_ENV['DB_DATABASE'] ?? 'membership_db';
$user = $_ENV['DB_USERNAME'] ?? 'root';
$pass = $_ENV['DB_PASSWORD'] ?? '';
try {
    $connection = new PDO('mysql:host=' . $host . ';' . 'dbname=' . $db, $user, $pass);
} catch (PDOException $e) {
    die('Error de conexión: ' . $e->getMessage());
}
