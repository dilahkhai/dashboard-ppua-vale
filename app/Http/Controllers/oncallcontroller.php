<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\oncall;
use App\Models\OnCallAutomation;
use App\Models\User;
use Carbon\Carbon;

class oncallcontroller extends Controller
{
    public function index()
    {
        $users = User::all();
        $usersWithInitial = User::query()
            ->whereHas('oncalls')
            ->get();

        return view('oncall', compact('users', 'usersWithInitial'));
    }

    public function show()
    {
        if (is_null(request('date'))) {
            abort(404);
        }

        $dateAttended = Carbon::parse(request('date'))->format('Y-m-d');

        $oncall = OnCallAutomation::query()
            ->whereDate('date_attend', $dateAttended)
            ->firstOrFail();

        return view('oncalldetail', compact('oncall'));
    }

    public function store(Request $request)
    {
        $dateAttended = Carbon::parse($request->attended)->format('Y-m-d');

        if ($request->hasFile('file')) {
            $filename = Str::random() . '.' . $request->file('file')->getClientOriginalExtension();

            $request->file('file')->storePubliclyAs('public/oncall', $filename);
        }

        OnCallAutomation::query()
            ->updateOrCreate([
                'date_attend' => $dateAttended
            ], [
                'user_id' => $request->user_id,
                'title' => $request->title,
                'description' => $request->description,
                'file' => $request->hasFile('file') ?  : null
            ]);

        return response()->json(['message' => 'success']);
    }

    public function update(Request $request, OnCallAutomation $oncall)
    {
        $oncall->update($request->only('title', 'description'));

        return back()->with('success', 'Data Saved!');
    }

    public function upload(Request $request, OnCallAutomation $oncall)
    {
        if ($request->hasFile('file')) {
            $filename = Str::random() . '.' . $request->file('file')->getClientOriginalExtension();

            $request->file('file')->storePubliclyAs('public/oncall', $filename);

            $oncall->update(['file' => 'storage/oncall/' . $filename]);

            return back()->with('success', 'File Saved!');
        }

        return back()->with('fail', 'Please input file!');
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

            $oncall->updateOrCreate(['date_attend' => Carbon::parse($week)->setYear($year)->toDateString()], ['user_id' => $oncall->user_id]);
        }

        $oncall = OnCallAutomation::query()
            ->with('employee')
            ->whereYear('date_attend', today()->year)
            ->take(52)
            ->get()
            ->transform(function ($value) {
                return [
                    'title' => $value->employee->initial ?? "-",
                    'start' => $value->date_attend,
                    'end' => $value->date_attend
                ];
            })
            ->toArray();

        return response()->json($oncall);
    }
}
