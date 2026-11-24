<?php

namespace App\DAO\Contracts;

use App\Models\Profile;

interface ProfileDAOInterface {
    public function findById(int $id): ?Profile;
    public function findByIdNumber(string $idType, string $idNumber): ?Profile;
    public function existsIdNumber(string $idType, string $idNumber): bool;
    public function create(array $data): Profile;
    public function update(int $id, array $data): bool;
}