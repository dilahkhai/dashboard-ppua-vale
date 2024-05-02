<?php

namespace App\Http\Controllers;

use App\Models\Area;
use App\Models\ManPower;
use App\Models\OnCallAutomation;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

use function Ramsey\Uuid\v1;

class ManPowerController extends Controller
{
    public function index()
    {
        $manpowers = ManPower::query()
            ->with(['crew', 'contractor', 'user'])
            ->whereDate('date', today()->toDateString())
            ->get()
            ->groupBy(function ($manpower) {
                return $manpower->user->area_id;
            })
            ->map(function ($manpower) {
                return $manpower->last();
            });

        $areas = Area::all();
        $users = User::query()
            ->with('area')
            ->get()
            ->groupBy('area_id');

        return view('manpower.index', compact('manpowers', 'areas', 'users'));
    }

    public function history()
    {
        $manpowers = ManPower::query()
            ->when(request('area_id'), function ($query) {
                $query->whereRelation('user', 'area_id', request('area_id'));
            })
            ->when(request('employee'), function ($query) {
                $query->whereRelation('user', 'id', request('employee'));
            })
            ->when(request('from'), function ($query) {
                $query->whereDate('date', '>=', request('from'));
            })
            ->when(request('to'), function ($query) {
                $query->whereDate('date', '<=', request('to'));
            })
            ->with(['user'])
            ->orderBy('date', 'desc')
            ->paginate(10);

        $areas = Area::all();

        return view('manpower.history', compact('manpowers', 'areas'));
    }

    public function create()
    {
        $areas = Area::all();

        return view('manpower.create', compact('areas'));
    }

    public function store(Request $request)
    {
        $manpower = ManPower::query()
            ->create([
                'user_id' => $request->employee,
                'date' => today()->toDateString()
            ]);

        $crewLeaveDates = explode(' - ', $request->crew_date_leave);

        $manpower->leave()->create([
            'user_id' => $request->crew_leave,
            'date_start' => Carbon::parse($crewLeaveDates[0])->toDateString(),
            'date_end' => Carbon::parse($crewLeaveDates[1])->toDateString(),
            'type' => 'leave'
        ]);

        $manpower->crew()->create([
            'total' => $request->crew_total,
            'total_man' => $request->crew_total_man,
            'utw' => $request->crew_utw,
            'utw_man' => $request->crew_utw_man,
            'quarantine' => $request->crew_quarantine,
            'quarantine_man' => $request->crew_quarantine_man,
            'leave' => 0,
            'leave_man' => 0,
            'sick_leave' => $request->crew_sick_leave,
            'sick_leave_man' => $request->crew_sick_leave_man,
            'mcu' => $request->crew_mcu,
            'mcu_man' => $request->crew_mcu_man,
            'ot_hours' => $request->crew_ot_hours,
            'ot_hours_man' => $request->crew_ot_hours_man,
            'ot' => $request->crew_ot,
            'ot_man' => $request->crew_ot_man,
            'total_power' => $request->crew_total_power,
            'total_power_man' => $request->crew_total_power_man,
        ]);

        $manpower->contractor()->create([
            'total' => $request->contractor_total,
            'total_man' => $request->contractor_total_man,
            'utw' => $request->contractor_utw,
            'utw_man' => $request->contractor_utw_man,
            'quarantine' => $request->contractor_quarantine,
            'quarantine_man' => $request->contractor_quarantine_man,
            'leave' => $request->contractor_leave,
            'leave_man' => $request->contractor_leave_man,
            'sick_leave' => $request->contractor_sick_leave,
            'sick_leave_man' => $request->contractor_sick_leave_man,
            'mcu' => $request->contractor_mcu,
            'mcu_man' => $request->contractor_mcu_man,
            'ot_hours' => $request->contractor_ot_hours,
            'ot_hours_man' => $request->contractor_ot_hours_man,
            'ot' => $request->contractor_ot,
            'ot_man' => $request->contractor_ot_man,
            'total_power' => $request->contractor_total_power,
            'total_power_man' => $request->contractor_total_power_man,
        ]);

        return redirect()->route('man-power.index')->with('success', 'Data saved!');
    }

    public function show(ManPower $manPower)
    {
        return view('manpower.show', compact('manPower'));
    }

    public function edit(ManPower $manPower)
    {
        $areas = Area::all();

        return view('manpower.edit', compact('manPower', 'areas'));
    }

    public function update(Request $request, ManPower $manPower)
    {
        $request->validate([
            'employee' => 'required|exists:users,id',
            'date' => 'required'
        ]);

        $manPower->update([
            'user_id' => $request->employee,
            'date' => $request->date
        ]);

        $manPower->crew()->update([
            'total' => $request->crew_total,
            'total_man' => $request->crew_total_man,
            'utw' => $request->crew_utw,
            'utw_man' => $request->crew_utw_man,
            'quarantine' => $request->crew_quarantine,
            'quarantine_man' => $request->crew_quarantine_man,
            'leave' => $request->crew_leave,
            'leave_man' => $request->crew_leave_man,
            'sick_leave' => $request->crew_sick_leave,
            'sick_leave_man' => $request->crew_sick_leave_man,
            'mcu' => $request->crew_mcu,
            'mcu_man' => $request->crew_mcu_man,
            'ot_hours' => $request->crew_ot_hours,
            'ot_hours_man' => $request->crew_ot_hours_man,
            'ot' => $request->crew_ot,
            'ot_man' => $request->crew_ot_man,
            'total_power' => $request->crew_total_power,
            'total_power_man' => $request->crew_total_power_man,
        ]);

        $manPower->contractor()->update([
            'total' => $request->contractor_total,
            'total_man' => $request->contractor_total_man,
            'utw' => $request->contractor_utw,
            'utw_man' => $request->contractor_utw_man,
            'quarantine' => $request->contractor_quarantine,
            'quarantine_man' => $request->contractor_quarantine_man,
            'leave' => $request->contractor_leave,
            'leave_man' => $request->contractor_leave_man,
            'sick_leave' => $request->contractor_sick_leave,
            'sick_leave_man' => $request->contractor_sick_leave_man,
            'mcu' => $request->contractor_mcu,
            'mcu_man' => $request->contractor_mcu_man,
            'ot_hours' => $request->contractor_ot_hours,
            'ot_hours_man' => $request->contractor_ot_hours_man,
            'ot' => $request->contractor_ot,
            'ot_man' => $request->contractor_ot_man,
            'total_power' => $request->contractor_total_power,
            'total_power_man' => $request->contractor_total_power_man,
        ]);

        return redirect()->route('man-power.index')->with('success', 'Data saved!');
    }

    public function destroy(ManPower $manPower)
    {
        $manPower->delete();

        return back()->with('success', 'Data deleted!');
    }
}
