<?php

class Membership
{

    public function findMembershipById($connection, $membership_id)
    {
        $stmt = $connection->prepare("SELECT * FROM memberships WHERE id = ?");
        $stmt->execute([$membership_id]);
        $membership = $stmt->fetch();
        return $membership;
    }
}
