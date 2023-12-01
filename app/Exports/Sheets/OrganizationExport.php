<?php

namespace App\Exports\Sheets;

use App\Models\OrganizationStructure;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithTitle;

class OrganizationExport implements FromQuery, WithMapping, WithHeadings, ShouldAutoSize, WithTitle
{
    protected $from, $to, $area;

    public function __construct($from, $to, $area)
    {
        $this->from = $from;
        $this->to = $to;
        $this->area = $area;
    }

    public function query()
    {
        return OrganizationStructure::query()->where('area_id', $this->area)->whereBetween('created_at', [$this->from, $this->to]);
    }

    public function map($row): array
    {
        return [
            $row->created_at->toDateString(),
            $row->value
        ];
    }

    public function headings(): array
    {
        return [
            'Date',
            'Count'
        ];
    }

    public function title(): string
    {
        return 'Organization';
    }
}
