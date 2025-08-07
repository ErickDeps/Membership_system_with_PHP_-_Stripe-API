<?php

class User
{

    function findUserByEmail($connection, $email)
    {
        $stmt = $connection->prepare("SELECT * FROM users WHERE email = ? LIMIT 1");
        $stmt->execute([$email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        return $user;
    }

    public function createUser($connection, $name, $email, $password)
    {
        $passwordHashed = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $connection->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");

        if ($stmt->execute([$name, $email, $passwordHashed])) {
            return $connection->lastInsertId();
        } else {
            return false;
        }
    }

    public function createUserMembership($connection, $userId, $membershipId)
    {
        try {
            $stmt = $connection->prepare("INSERT INTO user_memberships 
        (user_id, membership_id, payment_status, start_date, end_date, payment_method, transaction_id) 
        VALUES (?, ?, ?, NOW(), DATE_ADD(NOW(), INTERVAL 1 MONTH), ?, ?)");

            $stmt->execute([
                $userId,
                $membershipId,
                'paid',
                'webhook',
                'webhook_' . uniqid()
            ]);

            $connection->prepare("UPDATE users SET status = 'active' WHERE id = ?")->execute([$userId]);

            error_log("Activado user_id=$userId con membership_id=$membershipId\n", 3, __DIR__ . '/../logs/webhook.log');
        } catch (Exception $e) {
            error_log("Error en addUserMembership: " . $e->getMessage() . "\n", 3, __DIR__ . '/../logs/webhook.log');
        }
    }

    public function findUserMembership($connection, $user_id)
    {
        $stmt = $connection->prepare("SELECT id, user_id, membership_id, payment_status FROM user_memberships WHERE user_id = ? LIMIT 1");
        $stmt->execute([$user_id]);
        $userMembership = $stmt->fetch(PDO::FETCH_ASSOC);
        return $userMembership;
    }
}
