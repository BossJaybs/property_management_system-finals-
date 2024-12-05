<?php

namespace App\Models;

class LeaseAgreement {
    private int $id;
    private int $propertyId;
    private int $tenantId;
    private string $startDate;
    private string $endDate;
    private float $monthlyRent;

    public function __construct(int $id, int $propertyId, int $tenantId, string $startDate, string $endDate, float $monthlyRent) {
        $this->id = $id;
        $this->propertyId = $propertyId;
        $this->tenantId = $tenantId;
        $this->startDate = $startDate;
        $this->endDate = $endDate;
        $this->monthlyRent = $monthlyRent;
    }

    // Getters and setters
    public function getId(): int {
        return $this->id;
    }

    public function getPropertyId(): int {
        return $this->propertyId;
    }

    public function setPropertyId(int $propertyId): void {
        $this->propertyId = $propertyId;
    }

    public function getTenantId(): int {
        return $this->tenantId;
    }

    public function setTenantId(int $tenantId): void {
        $this->tenantId = $tenantId;
    }

    public function getStartDate(): string {
        return $this->startDate;
    }

    public function setStartDate(string $startDate): void {
        $this->startDate = $startDate;
    }

    public function getEndDate(): string {
        return $this->endDate;
    }

    public function setEndDate(string $endDate): void {
        $this->endDate = $endDate;
    }

    public function getMonthlyRent(): float {
        return $this->monthlyRent;
    }

    public function setMonthlyRent(float $monthlyRent): void {
        $this->monthlyRent = $monthlyRent;
    }
}

