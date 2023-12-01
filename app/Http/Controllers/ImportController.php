<?php

namespace App\Http\Controllers;

use App\Imports\MasterImport;
use App\Models\Area;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ImportController extends Controller
{
    public function index()
    {
        $areas = Area::all();

        return view('import', compact('areas'));
    }

    public function import(Request $request)
    {
        $area = Area::query()
            ->where('id', $request->area_id)
            ->value('id');

        Excel::import(new MasterImport($area), $request->file('file'));

        return back()->with('success', 'Import success!');
    }
}
