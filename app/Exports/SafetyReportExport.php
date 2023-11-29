<?php

namespace App\Exports;

use App\Models\SafetyReport;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class SafetyReportExport implements FromQuery, WithMapping, WithHeadings, ShouldAutoSize
{
    protected $from, $to;

    public function __construct($from, $to)
    {
        $this->from = $from;
        $this->to = $to;
    }

    public function query()
    {
        return SafetyReport::query()->with('user')->whereBetween('created_at', [$this->from, $this->to]);
    }

    public function map($row): array
    {
        return [
            $row->created_at->toDateString(),
            $row->user->name,
            $row->count
        ];
    }

    public function headings(): array
    {
        return [
            'Date',
            'Employee Name',
            'Count'
        ];
    }
}
