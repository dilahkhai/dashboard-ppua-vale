<?php

namespace App\Exports;

use App\Models\statusperday;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class EmployeeStatusExport implements FromQuery, WithMapping, WithHeadings, ShouldAutoSize
{
    protected $from, $to;

    public function __construct($from, $to)
    {
        $this->from = $from;
        $this->to = $to;
    }

    public function query()
    {
        return statusperday::query()->with('user')->whereBetween('created_at', [$this->from, $this->to]);
    }

    public function map($row): array
    {
        return [
            $row->created_at->toDateString(),
            $row->user->name,
            $row->office,
            $row->ho,
            $row->training,
            $row->sick_leave,
            $row->annual_leave,
            $row->emergency_leave,
            $row->medical_leave,
            $row->maternity_leave
        ];
    }

    public function headings(): array
    {
        return [
            'Date',
            'Employee Name',
            'Office',
            'HO',
            'Training',
            'Sick Leave',
            'Annual Leave',
            'Emergency Leave',
            'Medical Leave',
            'Maternity Leave'
        ];
    }
}
