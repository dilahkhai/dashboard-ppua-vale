<?php

namespace App\Exports;

use App\Models\employee;
use App\Models\Kaizen;
use App\Models\OrganizationStructure;
use App\Models\productivity;
use App\Models\SafetyReport;
use App\Models\statusperday;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;
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
            ->get();

        $statusPerDay = statusperday::query()
            ->whereHas('user', function ($query) {
                $query->where('area_id', $this->area);
            })
            ->get()
            ->groupBy(function ($data) {
                return Carbon::parse($data->created_at)->format('Y-m-d');
            })
            ->map
            ->groupBy(function ($data) {
                return $data->user->name;
            });

        $safetyReport = SafetyReport::query()
            ->whereHas('user', function ($query) {
                $query->where('area_id', $this->area);
            })
            ->get()
            ->groupBy(function ($data) {
                return Carbon::parse($data->datestatus)->format('Y-m-d');
            });
        $organization = OrganizationStructure::query()
            ->where('area_id', $this->area)
            ->groupBy(function ($data) {
                return Carbon::parse($data->datestatus)->format('Y-m-d');
            });
        $kaizen = Kaizen::query()
            ->where('area_id', $this->area)
            ->groupBy(function ($data) {
                return Carbon::parse($data->datestatus)->format('Y-m-d');
            });
        $productivity = productivity::query()
            ->where('area_id', $this->area)
            ->get()
            ->groupBy(function ($data) {
                return Carbon::parse($data->datestatus)->format('Y-m-d');
            });

        dd($statusPerDay);

        return view('excel.export', compact('statusPerDay', 'safetyReport', 'organization', 'kaizen', 'productivity', 'employees'));
    }
}
