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
        ],
        "nicolas" => [
            "email" => "nicolas@oclock.io",
            "roles" => ["ROLE_ADMIN"],
            "password" => "nicolas"
        ],
        "ben" => [
            "email" => "ben@oclock.io",
            "roles" => ["ROLE_ADMIN"],
            "password" => "ben"
        ],
        "hocine" => [
            "email" => "hocine@oclock.io",
            "roles" => ["ROLE_ADMIN"],
            "password" => "hocine"
        ],
        "thanh" => [
            "email" => "thanh@oclock.io",
            "roles" => ["ROLE_ADMIN"],
            "password" => "thanh"
        ],
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