<?php

require_once __DIR__.'/../model/User.php';
require_once __DIR__. '/../helpers/ResponseHelper.php';

class RegController {
    private $db;
    private $userModel;

    public function __construct($db) {
        $this->db = $db;
        $this->userModel = new User($this->db);
    }

    // Handle user registration
    public function register() {
        $data = json_decode(file_get_contents('php://input'), true);

        if (empty($data['username']) || empty($data['password'])) {
            ResponseHelper::error('Username and password are required', 400);
        }

        if ($this->userModel->userExists($data['username'])) {
            ResponseHelper::error('Username already exists', 409);
        }

        $created = $this->userModel->register($data['username'], $data['password']);
        if ($created) {
            ResponseHelper::success('User registered successfully', [], 201);
        } else {
            ResponseHelper::error('User registration failed', 500);
        }
    }

    public function login(){
        $data = json_decode(file_get_contents('php://input'), true);

        if (empty($data['username']) || empty($data['password'])) {
            ResponseHelper::error('Username and password are required', 400);
        }

        $user = $this->userModel->login($data['username'], $data['password']);
        if ($user) {
            ResponseHelper::success('Login successful', [
                'user' => [
                    'id' => $user['id'],
                    'username' => $user['username']
                ]
            ]);
        } else {
            ResponseHelper::error('Invalid username or password', 401);
        }
    }


}