<?php

namespace App\Http\Controllers;

use App\Exports\InputExport;
use App\Models\Area;
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
        $from = Carbon::parse($request->from)->toDateString();
        $to = Carbon::parse($request->to)->toDateString();

        return Excel::download(new InputExport($request->area_id, $from, $to), 'inputs.xlsx');
    }
}
