<?php

require_once __DIR__ . '/../repositories/ItemRepository.php';

class UserService {
    private $itemRepository;
    
    public function __construct($pdo) {
        $this->itemRepository = new ItemRepository($pdo);
    }
    
    public function register($name, $email, $password, $confirmPassword) {
        // Validasi input
        $validator = new Validator();
        
        if (!$validator->validateEmail($email)) {
            throw new Exception("Email tidak valid");
        }
        
        if (!$validator->validatePassword($password, $confirmPassword)) {
            throw new Exception("Password tidak sesuai atau kurang dari 8 karakter");
        }
        
        // Cek apakah email sudah terdaftar
        if ($this->userRepository->findByEmail($email)) {
            throw new Exception("Email sudah terdaftar");
        }
        
        // Hash password
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        
        // Simpan user
        $this->userRepository->createUser($name, $email, $hashedPassword);
        
        // Kirim email selamat datang (jika ada)
        // $this->sendWelcomeEmail($email, $name);
        
        return true;
    }
}
?>