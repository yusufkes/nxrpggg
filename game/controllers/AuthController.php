<?php
require_once '../models/Auth.php';

class AuthController {
    public function login($username, $password) {
        $auth = new Auth();
        return $auth->attemptLogin($username, $password);
    }

    public function logout() {
        session_start();
        session_destroy();
        header('Location: login.php');
    }
}
