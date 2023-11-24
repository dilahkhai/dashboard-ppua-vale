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
        $dateAttended = Carbon::parse($request->attended)->addDay()->format('Y-m-d');

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

        $year = now()->year;
        $weeks = [];

        for ($i = 1; $i <= Carbon::create($year)->weekOfYear; $i++) {
            $weeks[] = Carbon::create($year)->week($i)->format('Y-m-d');
        }

        foreach ($weeks as $week) {
            OnCallAutomation::query()
                ->firstOrCreate(['date_attend' => $week]);
        }

        $oncall = OnCallAutomation::query()
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
