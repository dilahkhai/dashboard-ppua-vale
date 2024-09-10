<?php

namespace App\Exports;

use App\Models\ManPower;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ManPowerExport implements FromCollection, WithStyles
{
    protected $from;
    protected $to;
    protected $area;

    public function __construct($from, $to, $area)
    {
        $this->from = $from;
        $this->to = $to;
        $this->area = $area;
    }

    public function collection()
    {
        $manPowers = ManPower::query()
            ->whereBetween('created_at', [$this->from, $this->to])
            ->where('area_id', $this->area)
            ->with('area', 'user')
            ->get();


        $areaName = $manPowers->first()->area->area;
        $leader = $manPowers->first()->user ? $manPowers->first()->user->name : 'No Leader';

        $data = [];
        $data[] = ['Date', $this->from];
        $data[] = ['Area: ' . $areaName];
        $data[] = ['Leader: ' . $leader];
        $data[] = [''];

        foreach ($manPowers as $manPower) {
            $data[] = ['Vale', '', ''];
            $data[] = ['Total Hadir', $manPower->crew_total, $manPower->crew_total_man];
            $data[] = ['Leave', $manPower->crew_leave, $manPower->crew_leave_man];
            $data[] = ['Sick Leave', $manPower->crew_sick_leave, $manPower->crew_sick_leave_man];
            $data[] = ['Medical Check Up', $manPower->crew_mcu, $manPower->crew_mcu_man];
            $data[] = ['Total Man Power', $manPower->crew_total_power, $manPower->crew_total_power_man];
            $data[] = [''];
            $data[] = ['Contractor', '', ''];
            $data[] = ['Total Hadir', $manPower->contractor_total, $manPower->contractor_total_man];
            $data[] = ['Leave', $manPower->contractor_leave, $manPower->contractor_leave_man];
            $data[] = ['Sick Leave', $manPower->contractor_sick_leave, $manPower->contractor_sick_leave_man];
            $data[] = ['Medical Check Up', $manPower->contractor_mcu, $manPower->contractor_mcu_man];
            $data[] = ['Total Man Power', $manPower->contractor_total_power, $manPower->contractor_total_power_man];
        }
    
        return collect($data);
    }

    public function styles(Worksheet $sheet)
    {
        $sheet->getColumnDimension('A')->setWidth(20); 
        $sheet->getColumnDimension('B')->setWidth(10); 
        $sheet->getColumnDimension('C')->setWidth(30); 
        $sheet->getStyle('C')->getAlignment()->setWrapText(true);

        $sheet->getStyle('A1')->getFont()->setBold(true);
        $sheet->getStyle('A2')->getFont()->setBold(true); 
        $sheet->getStyle('A3')->getFont()->setBold(true);
        $sheet->getStyle('A5')->getFont()->setBold(true);
        $sheet->getStyle('A12')->getFont()->setBold(true);

        $sheet->mergeCells('A1:C1');
        $sheet->mergeCells('A2:C2');
        $sheet->mergeCells('A3:C3');

        $sheet->getStyle('A1:C3')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID);
        $sheet->getStyle('A:C')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_TOP);
        $sheet->getStyle('A1:C3')->getFill()->getStartColor()->setARGB('FFB0C4DE');
    }

    public function title(): string
    {
        return 'Man Power';
    }
}
