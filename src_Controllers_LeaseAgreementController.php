<?php

namespace App\Controllers;

use App\Models\LeaseAgreement;
use App\Database\Database;
use PDO;

class LeaseAgreementController {
    private PDO $db;

    public function __construct() {
        $this->db = Database::getConnection();
    }

    public function getAll(): array {
        $stmt = $this->db->query("SELECT * FROM lease_agreements");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById(int $id): ?array {
        $stmt = $this->db->prepare("SELECT * FROM lease_agreements WHERE id = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
    }

    public function create(array $data): int {
        $stmt = $this->db->prepare("INSERT INTO lease_agreements (property_id, tenant_id, start_date, end_date, monthly_rent) VALUES (:property_id, :tenant_id, :start_date, :end_date, :monthly_rent)");
        $stmt->execute([
            'property_id' => $data['property_id'],
            'tenant_id' => $data['tenant_id'],
            'start_date' => $data['start_date'],
            'end_date' => $data['end_date'],
            'monthly_rent' => $data['monthly_rent']
        ]);
        return (int) $this->db->lastInsertId();
    }

    public function update(int $id, array $data): bool {
        $stmt = $this->db->prepare("UPDATE lease_agreements SET property_id = :property_id, tenant_id = :tenant_id, start_date = :start_date, end_date = :end_date, monthly_rent = :monthly_rent WHERE id = :id");
        return $stmt->execute([
            'id' => $id,
            'property_id' => $data['property_id'],
            'tenant_id' => $data['tenant_id'],
            'start_date' => $data['start_date'],
            'end_date' => $data['end_date'],
            'monthly_rent' => $data['monthly_rent']
        ]);
    }

    public function delete(int $id): bool {
        $stmt = $this->db->prepare("DELETE FROM lease_agreements WHERE id = :id");
        return $stmt->execute(['id' => $id]);
    }
}

