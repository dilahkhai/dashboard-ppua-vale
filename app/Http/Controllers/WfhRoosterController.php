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
        $dateAttended = Carbon::parse($request->attended)->format('Y-m-d');

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
        $nowYear = now()->year;
        $year = request('year') ?? $nowYear;
        $weeks = [];

        for ($i = 1; $i <= Carbon::create($nowYear)->weekOfYear; $i++) {
            $weeks[] = Carbon::create($nowYear)->week($i)->format('Y-m-d');
        }

        foreach ($weeks as $week) {
            $wfhRooster = WorkFromHomeRooster::query()
                ->firstOrCreate(['date_attend' => Carbon::parse($week)->setYear($year)->toDateString()]);

            $wfhRooster->updateOrCreate(['date_attend' => Carbon::parse($week)->setYear($year)->toDateString()], ['initial' => $wfhRooster->initial]);
        }

        $wfhRoosters = WorkFromHomeRooster::query()
            ->get()
            ->transform(function ($value) {
                return [
                    'title' => $value->initial ?? "-",
                    'start' => $value->date_attend,
                    'end' => $value->date_attend
                ];
            })
            ->toArray();

        return response()->json($wfhRoosters);
    }
}
