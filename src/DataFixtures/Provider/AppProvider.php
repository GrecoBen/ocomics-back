<?php

namespace App\DataFixtures\Provider;

class AppProvider
{
    private $user = [
        "admin" => [
            "email" => "admin@oclock.io",
            "roles" => ["ROLE_ADMIN"],
            "password" => "admin"
        ],
        "user" => [
            "email" => "user@oclock.io",
            "roles" => [],
            "password" => "user"
        ]
    ];


    /**
     * Get a a user, available roles : admin, email
     * @param string $role the role of the user
     * @return array a user
     */
    public function user($role = null)
    {
        if ($role) {
            return $this->user[$role];
        }
        return $this->user[array_rand($this->user)];
    }
}