<?php
class ItemRepository {
    private $pdo;
    
    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function findAll() {
        try {
            $stmt = $this->pdo->prepare("SELECT * FROM stocks ORDER BY created_at DESC");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error in findAll(): " . $e->getMessage());
            return [];
        }
    }
    
    public function findByCode($code) {
        $stmt = $this->pdo->prepare("SELECT * FROM stocks WHERE code = ?");
        $stmt->execute([$code]);
        return $stmt->fetch();
    }
    
    public function findById($id) {
        $stmt = $this->pdo->prepare("SELECT * FROM stocks WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }
    
    public function createItem($code, $itemName, $unit, $rak, $stok, $keterangan) {
        $stmt = $this->pdo->prepare(
            "INSERT INTO stocks (code, item_name, unit, shelf_location, system_stock, notes) VALUES (?, ?, ?, ?, ?, ?)"
        );
        return $stmt->execute([$code, $itemName, $unit, $rak, $stok, $keterangan]);
    }

    public function updateItem($id, $data) {
        $stmt = $this->pdo->prepare(
            "UPDATE stocks 
            SET code = :code, 
                item_name = :item_name, 
                unit = :unit, 
                shelf_location = :shelf_location, 
                system_stock = :system_stock, 
                notes = :notes
            WHERE id = :id"
        );

        return $stmt->execute([
            ':id' => $id,
            ':code' => $data['code'],
            ':item_name' => $data['item_name'],
            ':unit' => $data['unit'],
            ':shelf_location' => $data['shelf_location'],
            ':system_stock' => $data['system_stock'],
            ':notes' => $data['notes']
        ]);
    }

    public function countAll() {
        $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM stocks");
        $stmt->execute();
        return $stmt->fetchColumn();
    }
}
?>