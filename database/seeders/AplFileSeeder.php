<?php

namespace Database\Seeders;

use App\Models\AplFile;
use App\Models\AplSheet;
use App\Models\AplItem;
use Illuminate\Database\Seeder;

class AplFileSeeder extends Seeder
{
    public function run(): void
    {
        // Create master APL file
        $masterFile = AplFile::create([
            'name' => 'Master APL Midlife HD785-7',
        ]);

        // Create sheets
        $sheets = [
            ['name' => 'Hoist Cylinder', 'items' => [
                ['part_number' => 'HC-001', 'stock_code' => 'SC-001', 'description' => 'Hoist Cylinder Assembly', 'qty' => 2, 'stock' => 'Available', 'price' => 4500000, 'wr' => 'WR-001', 'remarks_install' => 'YES'],
                ['part_number' => 'HC-002', 'stock_code' => 'SC-002', 'description' => 'Hoist Cylinder Seal Kit', 'qty' => 5, 'stock' => 'Available', 'price' => 850000, 'wr' => 'WR-002', 'remarks_install' => 'YES'],
            ]],
            ['name' => 'Brake Cylinder', 'items' => [
                ['part_number' => 'BC-001', 'stock_code' => 'SC-003', 'description' => 'Brake Cylinder Assembly', 'qty' => 4, 'stock' => 'Available', 'price' => 2100000, 'wr' => 'WR-003', 'remarks_install' => 'YES'],
                ['part_number' => 'BC-002', 'stock_code' => 'SC-004', 'description' => 'Brake Pad Set', 'qty' => 10, 'stock' => 'Low Stock', 'price' => 950000, 'wr' => 'WR-004', 'remarks_install' => 'NO'],
            ]],
            ['name' => 'Hydraulic Pump', 'items' => [
                ['part_number' => 'HP-001', 'stock_code' => 'SC-005', 'description' => 'Hydraulic Main Pump', 'qty' => 1, 'stock' => 'Available', 'price' => 12000000, 'wr' => 'WR-005', 'remarks_install' => 'YES'],
            ]],
            ['name' => 'Engine Component', 'items' => [
                ['part_number' => 'EC-001', 'stock_code' => 'SC-006', 'description' => 'Engine Oil Filter', 'qty' => 20, 'stock' => 'Available', 'price' => 180000, 'wr' => null, 'remarks_install' => 'YES'],
                ['part_number' => 'EC-002', 'stock_code' => 'SC-007', 'description' => 'Fuel Filter', 'qty' => 15, 'stock' => 'Available', 'price' => 220000, 'wr' => null, 'remarks_install' => 'YES'],
                ['part_number' => 'EC-003', 'stock_code' => 'SC-008', 'description' => 'Air Filter', 'qty' => 8, 'stock' => 'Low Stock', 'price' => 450000, 'wr' => null, 'remarks_install' => 'NO'],
            ]],
        ];

        foreach ($sheets as $sheetData) {
            $sheet = AplSheet::create([
                'apl_file_id' => $masterFile->id,
                'name' => $sheetData['name'],
            ]);

            foreach ($sheetData['items'] as $itemData) {
                AplItem::create([
                    'apl_sheet_id' => $sheet->id,
                    'part_number' => $itemData['part_number'],
                    'stock_code' => $itemData['stock_code'],
                    'description' => $itemData['description'],
                    'qty' => $itemData['qty'],
                    'stock' => $itemData['stock'],
                    'price' => $itemData['price'],
                    'amount' => $itemData['qty'] * $itemData['price'],
                    'wr' => $itemData['wr'],
                    'remarks_install' => $itemData['remarks_install'],
                ]);
            }
        }
    }
}