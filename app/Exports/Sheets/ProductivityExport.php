<?php

namespace App\Exports\Sheets;

use App\Models\productivity;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithTitle;

class ProductivityExport implements FromQuery, WithMapping, WithHeadings, ShouldAutoSize, WithTitle
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
        return productivity::query()->where('area_id', $this->area)->with('departement')->whereBetween('created_at', [$this->from, $this->to]);
    }

    public function map($row): array
    {
        return [
            $row->created_at->toDateString(),
            $row->departement->name,
            $row->update,
            $row->selisih
        ];
    }

    public function headings(): array
    {
        return [
            'Date',
            'Section',
            'Productivity',
            'Difference'
        ];
    }

    public function title(): string
    {
        return 'Productivity';
    }

    public function styles(Worksheet $sheet)
    {
        $sheet->getStyle('A1:D1')->getFont()->setBold(true);

        $sheet->getStyle('A1:D1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID);
        $sheet->getStyle('A1:D1')->getFill()->getStartColor()->setARGB('FFB0C4DE');

        $sheet->getColumnDimension('A')->setWidth(20); 
        $sheet->getColumnDimension('B')->setWidth(30); 
        $sheet->getColumnDimension('C')->setWidth(30); 
        $sheet->getColumnDimension('D')->setWidth(30); 
    }
}
