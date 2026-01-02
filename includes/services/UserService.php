<?php
// $target = __DIR__ . '/../repositories/UserRepository.php';
// if (!file_exists($target)) {
//     die("File tidak ditemukan di: " . realpath(__DIR__ . '/../') . "/repositories/UserRepository.php");
// }
// require_once $target;
require_once __DIR__ . "/../repositories/UserRepository.php";

class UserService {
    private $userRepository;
    
    public function __construct($pdo) {
        $this->userRepository = new UserRepository($pdo);
    }

    public function findAll() {
        return $this->userRepository->findAll();
    }

    public function findById($id) {
        return $this->userRepository->findById($id);
    }
    
    public function register($name, $username, $password, $passwordStr, $status) {
        if ($this->userRepository->findByUsername($username)) {
            throw new Exception("Username sudah terdaftar");
        }
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $this->userRepository->createUser($name, $username, $hashedPassword, $passwordStr, $status);
        return true;
    }
    
    public function login($username, $password) {
        $user = $this->userRepository->findByUsername($username);
        
        if (!$user) {
            throw new Exception("Username atau password salah");
        }
        
        if (!password_verify($password, $user['password'])) {
            throw new Exception("Username atau password salah");
        }
        
        // Set session atau token
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_name'] = $user['name'];
        
        return $user;
    }

    public function updateUser($id, $data) {
        $hashedPassword = password_hash($data['password'], PASSWORD_DEFAULT);
        return $this->userRepository->updateUser($id, $hashedPassword, $data);
    }
}
?>