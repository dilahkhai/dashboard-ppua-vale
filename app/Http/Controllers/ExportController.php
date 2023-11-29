<?php

namespace App\Http\Controllers;

use App\Exports\EmployeeStatusExport;
use App\Exports\InputExport;
use App\Exports\KaizenExport;
use App\Exports\OrganizationExport;
use App\Exports\ProductivityExport;
use App\Exports\SafetyReportExport;
use App\Models\Area;
use App\Models\Kaizen;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ExportController extends Controller
{
    public function index()
    {
        $areas = Area::all();

        return view('export', compact('areas'));
    }

    public function exportEmployeeStatus(Request $request)
    {
        $area = Area::query()
            ->where('id', $request->area_id)
            ->value('area');

        $date = now()->toDateTimeString();

        $from = Carbon::parse($request->from)->toDateString();
        $to = Carbon::parse($request->to)->toDateString();

        return Excel::download(new EmployeeStatusExport($from, $to), "employee_status_{$area}_{$date}.xlsx");
    }

    public function exportSafetyReport(Request $request)
    {
        $area = Area::query()
            ->where('id', $request->area_id)
            ->value('area');

        $date = now()->toDateTimeString();

        $from = Carbon::parse($request->from)->toDateString();
        $to = Carbon::parse($request->to)->toDateString();

        return Excel::download(new SafetyReportExport($from, $to), "safety_reports_{$area}_{$date}.xlsx");
    }

    public function OrganizationReport(Request $request)
    {
        $area = Area::query()
            ->where('id', $request->area_id)
            ->value('area');

        $date = now()->toDateTimeString();

        $from = Carbon::parse($request->from)->toDateString();
        $to = Carbon::parse($request->to)->toDateString();

        return Excel::download(new OrganizationExport($from, $to, $request->area_id), "organization_{$area}_{$date}.xlsx");
    }

    public function KaizenReport(Request $request)
    {
        $area = Area::query()
            ->where('id', $request->area_id)
            ->value('area');

        $date = now()->toDateTimeString();

        $from = Carbon::parse($request->from)->toDateString();
        $to = Carbon::parse($request->to)->toDateString();

        return Excel::download(new KaizenExport($from, $to, $request->area_id), "kaizen_{$area}_{$date}.xlsx");
    }

    public function ProductivityReport(Request $request)
    {
        $area = Area::query()
            ->where('id', $request->area_id)
            ->value('area');

        $date = now()->toDateTimeString();

        $from = Carbon::parse($request->from)->toDateString();
        $to = Carbon::parse($request->to)->toDateString();

        return Excel::download(new ProductivityExport($from, $to, $request->area_id), "productivity_{$area}_{$date}.xlsx");
    }
}
