<?php

namespace App\Exports;

use App\Models\ReplacementHistory;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class ReplacementHistoryExport implements FromQuery, WithHeadings, WithMapping, WithStyles
{
    protected $search;

    public function __construct($search = null)
    {
        $this->search = $search;
    }

    public function query()
    {
        $query = ReplacementHistory::with(['user'])
            ->where('status', 'approved');

        if ($this->search) {
            $query->where(function($q) {
                $q->where('code_number', 'like', "%{$this->search}%")
                  ->orWhere('component_name', 'like', "%{$this->search}%")
                  ->orWhere('hm_km', 'like', "%{$this->search}%")
                  ->orWhere('notes', 'like', "%{$this->search}%");
            });
        }

        return $query->latest();
    }

    public function headings(): array
    {
        return [
            'Code Number',
            'HM Unit',
            'Date',
            'Activity',
            'Category',
            'Component',
            'PIC',
            'Status',
            'Created At',
        ];
    }

    public function map($history): array
    {
        return [
            $history->code_number ?: '-',
            $history->hm_km,
            $history->replacement_date->format('d M Y'),
            $history->notes ?: '-',
            $history->category ?: '-',
            $history->component_name ?: '-',
            $history->pic ?: '-',
            ucfirst($history->status),
            $history->created_at->format('d M Y H:i'),
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => [
                'font' => ['bold' => true],
                'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
                'fill' => [
                    'fillType' => Fill::FILL_SOLID,
                    'startColor' => ['rgb' => '8B0A50'],
                ],
                'font' => [
                    'color' => ['rgb' => 'FFFFFF'],
                ],
            ],
        ];
    }
}