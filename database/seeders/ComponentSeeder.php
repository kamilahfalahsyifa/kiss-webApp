<?php

namespace Database\Seeders;

use App\Models\Component;
use Illuminate\Database\Seeder;

class ComponentSeeder extends Seeder
{
    public function run(): void
    {
        $components = [
            ['component_name' => 'Engine Oil Filter', 'part_number' => 'FO-1234', 'category' => 'Filter', 'stock' => 15, 'price' => 250000, 'vendor' => 'Caterpillar'],
            ['component_name' => 'Hydraulic Oil Filter', 'part_number' => 'FH-5678', 'category' => 'Filter', 'stock' => 12, 'price' => 320000, 'vendor' => 'Caterpillar'],
            ['component_name' => 'Air Filter', 'part_number' => 'FA-9012', 'category' => 'Filter', 'stock' => 8, 'price' => 180000, 'vendor' => 'Donaldson'],
            ['component_name' => 'Brake Pad', 'part_number' => 'BP-3456', 'category' => 'Brake', 'stock' => 4, 'price' => 850000, 'vendor' => 'Bendix'],
            ['component_name' => 'Tyre 26.5R25', 'part_number' => 'TY-7890', 'category' => 'Tyre', 'stock' => 3, 'price' => 4500000, 'vendor' => 'Michelin'],
            ['component_name' => 'Fuel Filter', 'part_number' => 'FF-1111', 'category' => 'Filter', 'stock' => 20, 'price' => 150000, 'vendor' => 'Caterpillar'],
            ['component_name' => 'Transmission Filter', 'part_number' => 'FT-2222', 'category' => 'Filter', 'stock' => 6, 'price' => 420000, 'vendor' => 'Caterpillar'],
            ['component_name' => 'Water Separator', 'part_number' => 'WS-3333', 'category' => 'Filter', 'stock' => 10, 'price' => 280000, 'vendor' => 'Fleetguard'],
        ];

        foreach ($components as $component) {
            Component::create($component);
        }
    }
}