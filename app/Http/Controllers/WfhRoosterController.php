<?php

namespace App\Http\Controllers;

use App\Models\WorkFromHomeRooster;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class WfhRoosterController extends Controller
{
    public function index()
    {
        $users = User::all();
        $usersWithInitial = User::query()
        ->whereHas('wfh')
        ->get();

        return view('wfhrooster', compact('users', 'usersWithInitial'));
    }

    public function show()
    {
        if (is_null(request('date'))) {
            abort(404);
        }

        $dateAttended = Carbon::parse(request('date'))->format('Y-m-d');

        $oncall = WorkFromHomeRooster::query()
            ->whereDate('date_attend', $dateAttended)
            ->firstOrFail();

        return view('wfhrooster-detail', compact('oncall'));
    }

    public function store(Request $request)
    {
        $dateAttended = Carbon::parse($request->attended)->format('Y-m-d');

        WorkFromHomeRooster::updateOrCreate(
            ['date_attend' => $dateAttended, 'initial' => $request->initial],
            []
        );

        return response()->json(['message' => 'success']);
    }

    public function source()
    {
        $nowYear = now()->year;
        $year = request('year') ?? $nowYear;

        for ($i = 1; $i <= Carbon::create($nowYear)->weeksInYear; $i++) {
            $this->weeks[] = Carbon::create($nowYear)->week($i)->format('Y-m-d');
        }

        $this->update($year);

        $wfhRooster = WorkFromHomeRooster::query()
        ->with(['employee'])
        ->whereYear('date_attend', today()->year)
        ->take(52)
        ->get();

        $data = $wfhRooster->transform(function ($value) {
            return [
                'title' => $value->employee->initial ?? "-",
                'start' => $value->date_attend,
                'end' => $value->date_attend
            ];
        })->toArray();

        return response()->json($data);
    }

    private function update($year)
    {
        foreach ($this->weeks as $week) {
            $wfhRooster = WorkFromHomeRooster::firstOrCreate([
                'date_attend' => Carbon::parse($week)->setYear($year)->toDateString()
            ]);

            $userExists = User::whereHas('leaves', function ($query) use ($wfhRooster) {
                $query->whereDate('date_start', '>=', $wfhRooster->date_attend);
            })->where('id', $wfhRooster->initial)->exists();

            if ($userExists) {
                $updates = WorkFromHomeRooster::whereDate('date_attend', '>', $wfhRooster->date_attend)
                    ->whereYear('date_attend', $year)
                    ->get();

                foreach ($updates as $record) {
                    WorkFromHomeRooster::updateOrCreate(
                        ['date_attend' => Carbon::parse($record->date_attend)->subDays(7)->toDateString()],
                        ['initial' => $record->initial]
                    );
                }
            } else {
                WorkFromHomeRooster::updateOrCreate(
                    ['date_attend' => Carbon::parse($week)->setYear($year)->toDateString()],
                    ['initial' => $wfhRooster->initial]
                );
            }
        }
    }
}
