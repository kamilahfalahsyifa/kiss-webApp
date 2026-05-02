<?php

namespace Database\Seeders;

use App\Models\Unit;
use Illuminate\Database\Seeder;

class UnitSeeder extends Seeder
{
    public function run(): void
    {
        $units = [
            ['unit_name' => 'HD 785-7 #001', 'qr_code' => 'HD785-001', 'location' => 'Pit A - Zone 1', 'status' => 'active'],
            ['unit_name' => 'HD 785-7 #002', 'qr_code' => 'HD785-002', 'location' => 'Pit A - Zone 2', 'status' => 'active'],
            ['unit_name' => 'HD 785-7 #003', 'qr_code' => 'HD785-003', 'location' => 'Pit B - Zone 1', 'status' => 'active'],
            ['unit_name' => 'HD 785-7 #004', 'qr_code' => 'HD785-004', 'location' => 'Pit B - Zone 2', 'status' => 'maintenance'],
            ['unit_name' => 'HD 785-7 #005', 'qr_code' => 'HD785-005', 'location' => 'Pit C - Zone 1', 'status' => 'active'],
        ];

        foreach ($units as $unit) {
            Unit::create($unit);
        }
    }
}