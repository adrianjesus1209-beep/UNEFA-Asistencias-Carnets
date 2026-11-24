<?php

namespace App\DAO;

use App\DAO\Contracts\ProfileDAOInterface;
use App\Models\Profile;
use App\Support\Sanitizer;

class ProfileDAO implements ProfileDAOInterface {
    public function findById(int $id): ?Profile {
        return Profile::find($id);
    }

    public function findByIdNumber(string $idType, string $idNumber): ?Profile {
        $idType   = strtoupper(trim($idType)) === 'E' ? 'E' : 'V';
        $idNumber = Sanitizer::cedula($idNumber);
        if (!$idNumber) return null;

        return Profile::where('id_type', $idType)
            ->where('id_number', $idNumber)
            ->first();
    }

    public function existsIdNumber(string $idType, string $idNumber): bool {
        return $this->findByIdNumber($idType, $idNumber) !== null;
    }

    public function create(array $data): Profile {
        foreach (['first_name','middle_name','last_name','second_last_name'] as $k) {
            if (isset($data[$k])) {
                $data[$k] = Sanitizer::letters($data[$k]);
            }
        }
        if (isset($data['address'])) {
            $data['address'] = Sanitizer::clean($data['address']);
        }
        return Profile::create($data);
    }

    public function update(int $id, array $data): bool {
        return (bool) Profile::where('id', $id)->update($data);
    }
}