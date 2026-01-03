<?php

require_once __DIR__ . '/../repositories/ItemRepository.php';

class ItemService {
    private $itemRepository;
    
    public function __construct($pdo) {
        $this->itemRepository = new ItemRepository($pdo);
    }

    public function findAll() {
        return $this->itemRepository->findAll();
    }
    
    public function insert($code, $itemName, $unit, $rak, $stok, $keterangan) {
        
        // Cek apakah email sudah terdaftar
        if ($this->itemRepository->findByCode($code)) {
            throw new Exception("Kode sudah terdaftar");
        }
        
        // Simpan user
        $this->itemRepository->createItem($code, $itemName, $unit, $rak, $stok, $keterangan);
        
        return true;
    }

    public function findById($id) {
        return $this->itemRepository->findById($id);
    }

    public function update($id, $data) {
        return $this->itemRepository->updateItem($id, $data);
    }

    public function countAll() {
        return $this->itemRepository->countAll();
    }
}
?>