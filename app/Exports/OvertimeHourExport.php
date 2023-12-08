<?php

namespace App\Exports;

use App\Models\OvertimeHour;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithMapping;

class OvertimeHourExport implements FromQuery, WithMapping, ShouldAutoSize
{
    protected $from, $to;

    public function __construct($from, $to)
    {
        $this->from = $from;
        $this->to = $to;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function query()
    {
        return OvertimeHour::query()
            ->when($this->from, function ($query) {
                $query->whereDate('date', '>=', $this->from);
            })
            ->when($this->to, function ($query) {
                $query->whereDate('date', '<=', $this->to);
            });
    }

    public function map($row): array
    {
        return [
            $row->user->area->area,
            $row->user->name,
            $row->hour,
            $row->date
        ];
    }
}
