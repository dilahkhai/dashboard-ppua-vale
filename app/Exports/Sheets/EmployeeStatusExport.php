<?php

namespace App\Exports\Sheets;

use App\Models\statusperday;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class EmployeeStatusExport implements FromQuery, WithMapping, WithHeadings, WithTitle, WithStyles
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

    public function title(): string
    {
        return 'Employee Status';
    }

    public function styles(Worksheet $sheet)
    {
        $sheet->getStyle('A1:J1')->getFont()->setBold(true);

        $sheet->getStyle('A1:J1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID);
        $sheet->getStyle('A1:J1')->getFill()->getStartColor()->setARGB('FFB0C4DE');

        $sheet->getColumnDimension('A')->setWidth(20); 
        $sheet->getColumnDimension('B')->setWidth(30); 
        $sheet->getColumnDimension('C')->setWidth(15); 
        $sheet->getColumnDimension('D')->setWidth(15); 
        $sheet->getColumnDimension('E')->setWidth(20); 
        $sheet->getColumnDimension('F')->setWidth(20); 
        $sheet->getColumnDimension('G')->setWidth(20); 
        $sheet->getColumnDimension('H')->setWidth(20); 
        $sheet->getColumnDimension('I')->setWidth(20); 
        $sheet->getColumnDimension('J')->setWidth(20); 
    }
}
