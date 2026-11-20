<?php

/**
 * Seeder principal de Laravel.
 *
 * Ejecuta automaticamente UnefaInitialDataSeeder al correr:
 * php artisan db:seed  o  php artisan migrate --seed
 */

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        $this->call([
            UnefaInitialDataSeeder::class,
        ]);
    }
}
