<?php

namespace App\Exports;

use App\Models\statusperday;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class InputExport implements FromView, ShouldAutoSize
{
    protected $area, $from, $to;

    public function __construct($area, $from, $to)
    {
        $this->area = $area;
        $this->from = $from;
        $this->to = $to;
    }

    public function view(): View
    {
        $employees = User::query()
            ->where('area_id', $this->area)
            ->withSum(['statusperday as office' => function ($query) {
                $query->whereDate('created_at', '>=', $this->from)->whereDate('created_at', '<=', $this->to);
            }], 'office')
            ->withSum(['statusperday as ho' => function ($query) {
                $query->whereDate('created_at', '>=', $this->from)->whereDate('created_at', '<=', $this->to);
            }], 'ho')
            ->withSum(['statusperday as training' => function ($query) {
                $query->whereDate('created_at', '>=', $this->from)->whereDate('created_at', '<=', $this->to);
            }], 'training')
            ->withSum(['statusperday as sick_leave' => function ($query) {
                $query->whereDate('created_at', '>=', $this->from)->whereDate('created_at', '<=', $this->to);
            }], 'sick_leave')
            ->withSum(['statusperday as annual_leave' => function ($query) {
                $query->whereDate('created_at', '>=', $this->from)->whereDate('created_at', '<=', $this->to);
            }], 'annual_leave')
            ->withSum(['statusperday as emergency' => function ($query) {
                $query->whereDate('created_at', '>=', $this->from)->whereDate('created_at', '<=', $this->to);
            }], 'emergency_leave')
            ->withSum(['statusperday as medical_leave' => function ($query) {
                $query->whereDate('created_at', '>=', $this->from)->whereDate('created_at', '<=', $this->to);
            }], 'medical_leave')
            ->withSum(['statusperday as maternity_leave' => function ($query) {
                $query->whereDate('created_at', '>=', $this->from)->whereDate('created_at', '<=', $this->to);
            }], 'maternity_leave')
            ->get();

        return view('excel.export', [
            'employees' => $employees,
            'from' => $this->from,
            'to' => $this->to
        ]);
    }
}
