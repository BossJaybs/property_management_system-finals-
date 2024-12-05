<?php

namespace App\Controllers;

use App\Models\Property;
use App\Database\Database;
use PDO;

class PropertyController {
    private PDO $db;

    public function __construct() {
        $this->db = Database::getConnection();
    }

    public function getAll(): array {
        $stmt = $this->db->query("SELECT * FROM properties");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById(int $id): ?array {
        $stmt = $this->db->prepare("SELECT * FROM properties WHERE id = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
    }

    public function create(array $data): int {
        $stmt = $this->db->prepare("INSERT INTO properties (address, bedrooms, bathrooms, rent) VALUES (:address, :bedrooms, :bathrooms, :rent)");
        $stmt->execute([
            'address' => $data['address'],
            'bedrooms' => $data['bedrooms'],
            'bathrooms' => $data['bathrooms'],
            'rent' => $data['rent']
        ]);
        return (int) $this->db->lastInsertId();
    }

    public function update(int $id, array $data): bool {
        $stmt = $this->db->prepare("UPDATE properties SET address = :address, bedrooms = :bedrooms, bathrooms = :bathrooms, rent = :rent WHERE id = :id");
        return $stmt->execute([
            'id' => $id,
            'address' => $data['address'],
            'bedrooms' => $data['bedrooms'],
            'bathrooms' => $data['bathrooms'],
            'rent' => $data['rent']
        ]);
    }

    public function delete(int $id): bool {
        $stmt = $this->db->prepare("DELETE FROM properties WHERE id = :id");
        return $stmt->execute(['id' => $id]);
    }
}

