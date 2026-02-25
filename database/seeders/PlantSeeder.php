<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Plant;

class PlantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
 public function run(): void
{
    // Menggunakan create agar timestamps (created_at/updated_at) terisi otomatis
    // Dan menentukan ID secara manual agar sinkron dengan DivisionSeeder
    Plant::create([
        'id' => 1,
        'name' => 'Sistem E-Catering PT Craze Indonesia Factory 1'
    ]);

    Plant::create([
        'id' => 2,
        'name' => 'Sistem E-Catering PT Craze Indonesia Factory 2'
    ]);
}
}