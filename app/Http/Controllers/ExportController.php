<?php

namespace App\Http\Controllers;

use App\Exports\EmployeeStatusExport;
use App\Exports\InputExport;
use App\Exports\KaizenExport;
use App\Exports\MasterExport;
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

    public function export(Request $request)
    {
        $area = Area::query()
            ->where('id', $request->area_id)
            ->value('id');

        $date = now()->toDateTimeString();

        $from = Carbon::parse($request->from)->toDateString();
        $to = Carbon::parse($request->to)->toDateString();

        return Excel::download(new MasterExport($from, $to, $area), "master_data_{$area}_{$date}.xlsx");
    }
}
