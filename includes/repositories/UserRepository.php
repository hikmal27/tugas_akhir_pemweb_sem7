<?php
// Includes/Repositories/UserRepository.php

class UserRepository {
    private $pdo;
    
    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function findAll() {
        try {
            $stmt = $this->pdo->prepare("SELECT * FROM ms_users ORDER BY register_date DESC");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error in findAll(): " . $e->getMessage());
            return [];
        }
    }
    
    public function findByUsername($username) {
        $stmt = $this->pdo->prepare("SELECT * FROM ms_users WHERE username = ?");
        $stmt->execute([$username]);
        return $stmt->fetch();
    }
    
    public function findById($id) {
        $stmt = $this->pdo->prepare("SELECT * FROM ms_users WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }
    
    public function createUser($name, $username, $hashedPassword, $passwordStr, $status) {
        $stmt = $this->pdo->prepare(
            "INSERT INTO ms_users (name, username, password, password_str, status, register_date) VALUES (?, ?, ?, ?, ?, CURDATE())"
        );
        return $stmt->execute([$name, $username, $hashedPassword, $passwordStr, $status]);
    }

    public function updateUser($id, $hashedPassword, $data) {
        $stmt = $this->pdo->prepare(
            "UPDATE ms_users 
            SET name = :name, 
                username = :username, 
                password = :password, 
                password_str = :passwordStr, 
                status = :status
            WHERE id = :id"
        );

        return $stmt->execute([
            ':id' => $id,
            ':name' => $data['name'],
            ':username' => $data['username'],
            ':password' => $hashedPassword,
            ':passwordStr' => $data['passwordStr'],
            ':status' => $data['status']
        ]);
    }

    public function countAll() {
        $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM ms_users");
        $stmt->execute();
        return $stmt->fetchColumn();
    }
}
?>