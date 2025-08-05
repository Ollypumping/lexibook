<?php

require_once  __DIR__. '/../model/User.php';
require_once __DIR__.'/../helpers/ResponseHelper.php';


class AuthMiddleware {
    protected $db;
    protected $userModel;
    protected $user;

    public function __construct($db) {
        $this->db = $db;
        $this->userModel = new User($this->db);
        $this->authenticate();
    }

    protected function authenticate() {
        $username = isset($_SERVER['PHP_AUTH_USER']) ? $_SERVER['PHP_AUTH_USER'] : null;
        $password = isset($_SERVER['PHP_AUTH_PW']) ? $_SERVER['PHP_AUTH_PW'] : null;

       
        $user = $this->userModel->getUserByUsername($username);
        if (!$user || !password_verify($password, $user['password'])) {
            ResponseHelper::error('Authentication unauthorized', 401);
        }

        $this->user = $user;
        return $user;

       
    }

}