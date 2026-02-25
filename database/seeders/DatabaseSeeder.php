<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
{
    // 1. Jalankan PlantSeeder DULU (karena Division butuh Plant)
    $this->call([
        PlantSeeder::class,    
        DivisionSeeder::class, 
    ]);

    // 2. Buat User (pastikan user ini punya plant_id jika kolomnya wajib)
    User::factory()->create([
        'name' => 'Operator User',
        'email' => 'operator@example.com',
        'password' => bcrypt('password'),
        'role' => 'operator',
        'plant_id' => 1, // Pastikan plant_id 1 sudah dibuat oleh PlantSeeder
    ]);
}
}
