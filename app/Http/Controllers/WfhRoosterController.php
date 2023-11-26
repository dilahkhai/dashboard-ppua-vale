<?php

namespace App\Http\Controllers;

use App\Models\WFHInitialDetail;
use Illuminate\Http\Request;
use App\Models\WfhRooster;
use App\Models\WorkFromHomeRooster;
use Carbon\Carbon;

class WfhRoosterController extends Controller
{
    public function index()
    {
        $initialDetail = WFHInitialDetail::all();

        return view('wfhrooster', compact('initialDetail'));
    }

    public function store(Request $request)
    {
        $dateAttended = Carbon::parse($request->attended)->addDay()->format('Y-m-d');

        WorkFromHomeRooster::query()
            ->updateOrCreate([
                'date_attend' => $dateAttended
            ], [
                'initial' => $request->initial
            ]);

        return response()->json(['message' => 'success']);
    }

    public function source()
    {
        $year = Carbon::parse(request('start'))->format('Y');
        $weeks = [];

        for ($i = 1; $i <= Carbon::create($year)->weekOfYear; $i++) {
            $weeks[] = Carbon::create($year)->week($i)->format('Y-m-d');
        }

        foreach ($weeks as $week) {
            WorkFromHomeRooster::query()
                ->firstOrCreate(['date_attend' => $week]);
        }

        $oncall = WorkFromHomeRooster::query()
            ->get()
            ->transform(function ($value) {
                return [
                    'title' => $value->initial ?? "Kosong",
                    'start' => $value->date_attend,
                    'end' => $value->date_attend
                ];
            })
            ->toArray();

        return response()->json($oncall);
    }
}
