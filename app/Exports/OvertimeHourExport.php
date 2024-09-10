<?php

namespace App\Exports;

use App\Models\OvertimeHour;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class OvertimeHourExport implements FromCollection, WithHeadings, WithStyles
{
    public function collection()
    {
        return OvertimeHour::with('user.area')->get()->map(function($overtimeHour) {
            return [
                'area' => $overtimeHour->user->area->area,  
                'name' => $overtimeHour->user->name,         
                'hours' => $overtimeHour->hour,
                'date' => $overtimeHour->date, 
            ];
        });
    }

    public function headings(): array
    {
        return [
            'Area',
            'Name',
            'Hours',
            'Date',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        $sheet->getStyle('A1:D1')->getFont()->setBold(true);

        $sheet->getStyle('A1:D1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID);
        $sheet->getStyle('A1:D1')->getFill()->getStartColor()->setARGB('FFB0C4DE');

        $sheet->getColumnDimension('A')->setWidth(20); 
        $sheet->getColumnDimension('B')->setWidth(30); 
        $sheet->getColumnDimension('C')->setWidth(10);  
        $sheet->getColumnDimension('D')->setWidth(20); 
    }
}
