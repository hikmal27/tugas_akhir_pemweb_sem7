<?php
class DatabaseConfig {
    private static $pdo = null;
    
    public static function getConnection() {
        if (self::$pdo === null) {
            // $host = "localhost:3306";
            // $username = "smart";
            // $password = "Smart@123";
            // $dbname = "db_tugas_akhir";

            // Macbook
            $host = "localhost:3306";
            $username = "admin";
            $password = "supersecret";
            $dbname = "db_pemweb_2";
            
            try {
                self::$pdo = new PDO(
                    "mysql:host=$host;dbname=$dbname;charset=utf8",
                    $username,
                    $password,
                    [
                        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
                    ]
                );
            } catch (PDOException $e) {
                die("Koneksi database gagal: " . $e->getMessage());
            }
        }
        
        return self::$pdo;
    }
}
?>