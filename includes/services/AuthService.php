<?php
require_once __DIR__ . '/../repositories/UserRepository.php';

class AuthService {
    private $userRepository;
    
    public function __construct($pdo) {
        $this->userRepository = new UserRepository($pdo);
    }

    public function login($username, $password) {
        // Validasi input
        if (empty($username) || empty($password)) {
            throw new Exception("Username dan password harus diisi");
        }

        // Cek apakah username terdaftar
        $user = $this->userRepository->findByUsername($username);
        if (!$user) {
            throw new Exception("Username tidak terdaftar");
        }

        // Verifikasi password
        if (!password_verify($password, $user['password'])) {
            throw new Exception("Password salah");
        }

        // Set session user
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_name'] = $user['name'];
        
        return true;
    }
}

?>