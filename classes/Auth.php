<?php

class Auth {

    public static function isLoggedIn($role) {
        return isset($_SESSION["is_logged_in"]) and $_SESSION["is_logged_in"] and $_SESSION["role"] === $role;
    }

}
