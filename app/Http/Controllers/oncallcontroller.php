<?php

namespace App\Http\Controllers;

use App\Models\InitialDetail;
use Illuminate\Http\Request;
use App\Models\oncall;
use App\Models\OnCallAutomation;
use Carbon\Carbon;

class oncallcontroller extends Controller
{
    public function index()
    {
        $initialDetail = InitialDetail::all();

        return view('oncall', compact('initialDetail'));
    }

    public function store(Request $request)
    {
        $dateAttended = Carbon::parse($request->attended)->format('Y-m-d');

        OnCallAutomation::query()
            ->updateOrCreate([
                'date_attend' => $dateAttended
            ], [
                'initial' => $request->initial
            ]);

        return response()->json(['message' => 'success']);
    }

    public function upload(Request $request)
    {
        $fileextension = $request->file('fileupload')->getClientOriginalExtension();
        $filename = time() . "." . $fileextension;
        // $filename = "splashscreencustomer". $fileextension;
        $request->file('fileupload')->move(public_path('/upload'), $filename);

        $oncall = new oncall;
        $oncall->file = asset("upload/$filename");
        $oncall->save();

        return redirect('/oncall');
    }

    public function source()
    {
        $nowYear = now()->year;
        $year = request('year');
        $weeks = [];

        for ($i = 1; $i <= Carbon::create($nowYear)->weekOfYear; $i++) {
            $weeks[] = Carbon::create($nowYear)->week($i)->format('Y-m-d');
        }

        foreach ($weeks as $week) {
            $oncall = OnCallAutomation::query()
                ->firstOrCreate(['date_attend' => Carbon::parse($week)->setYear($year)->toDateString()]);

            $oncall->updateOrCreate(['date_attend' => Carbon::parse($week)->setYear($year)->toDateString()], ['initial' => $oncall->initial]);
        }

        $oncall = OnCallAutomation::query()
            ->get()
            ->transform(function ($value) {
                return [
                    'title' => $value->initial ?? "-",
                    'start' => $value->date_attend,
                    'end' => $value->date_attend
                ];
            })
            ->toArray();

        return response()->json($oncall);
    }
}
