<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Division;
class DivisionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
{
    $internalDivisions = [
        'Div.Cosmetic',
        'Div.Assembly',
        'Div.QC',
        'Div.Injection',
        'Div.Utility',
        'Div.Casting',
        'Div.Staff',
        'Div.Security',
        'Div.Warehouse',
        'Div.Engineering',
        'Div. Sales/Exim',
        'Div. PPIC/Purchasing',
    ];

    $subcountDivisions = [
        'Sub.Jas',
        'Sub.Sugesti',
        'Sub.Aksara',
        'Sub.Sarinci'
    ];

    foreach ([1,2] as $plant) {

        foreach ($internalDivisions as $div) {
            Division::create([
                'name' => $div,
                'plant_id' => $plant,
                'type' => 'internal'
            ]);
        }

        foreach ($subcountDivisions as $div) {
            Division::create([
                'name' => $div,
                'plant_id' => $plant,
                'type' => 'subcount'
            ]);
        }
    }
}
}
