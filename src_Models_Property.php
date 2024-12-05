<?php

namespace App\Models;

class Property {
    private int $id;
    private string $address;
    private int $bedrooms;
    private int $bathrooms;
    private float $rent;

    public function __construct(int $id, string $address, int $bedrooms, int $bathrooms, float $rent) {
        $this->id = $id;
        $this->address = $address;
        $this->bedrooms = $bedrooms;
        $this->bathrooms = $bathrooms;
        $this->rent = $rent;
    }

    // Getters and setters
    public function getId(): int {
        return $this->id;
    }

    public function getAddress(): string {
        return $this->address;
    }

    public function setAddress(string $address): void {
        $this->address = $address;
    }

    public function getBedrooms(): int {
        return $this->bedrooms;
    }

    public function setBedrooms(int $bedrooms): void {
        $this->bedrooms = $bedrooms;
    }

    public function getBathrooms(): int {
        return $this->bathrooms;
    }

    public function setBathrooms(int $bathrooms): void {
        $this->bathrooms = $bathrooms;
    }

    public function getRent(): float {
        return $this->rent;
    }

    public function setRent(float $rent): void {
        $this->rent = $rent;
    }
}

