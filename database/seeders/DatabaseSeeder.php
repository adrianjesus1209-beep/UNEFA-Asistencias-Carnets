<?php

<<<<<<< HEAD
namespace Database\Seeders;

use App\Models\User;
=======
/**
 * Seeder principal de Laravel.
 *
 * Ejecuta automaticamente UnefaInitialDataSeeder al correr:
 * php artisan db:seed  o  php artisan migrate --seed
 */

namespace Database\Seeders;

>>>>>>> ee414c225eb0aff997eca903e6038973995a87f5
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

<<<<<<< HEAD
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
=======
    public function run(): void
    {
        $this->call([
            UnefaInitialDataSeeder::class,
>>>>>>> ee414c225eb0aff997eca903e6038973995a87f5
        ]);
    }
}
