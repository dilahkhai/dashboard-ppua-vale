<?php

namespace App\Http\Controllers;

use App\Models\Area;
use App\Models\ManPower;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ManPowerController extends Controller
{
    public function index()
    {
        $areas = Area::all();
        $today = today()->toDateString();

        foreach ($areas as $area) {
            $existingManPower = ManPower::query()
                ->where('area_id', $area->id)
                ->whereDate('date', $today)
                ->exists();
        }

        $manpowers = ManPower::query()
            ->with(['user'])
            ->whereDate('date', $today)
            ->get()
            ->groupBy('area_id')
            ->map(function ($manpower) {
                return $manpower->last();
            });

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
                $query->where('area_id', request('area_id'));
            })
            ->when(request('employee'), function ($query) {
                $query->where('user_id', request('employee'));
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
                'date' => today()->toDateString(),
                'area_id' => $request->area_id,
                'crew_total' => $request->crew_total,
                'crew_total_man' => $request->crew_total_man,
                'crew_leave' => $request->crew_leave,
                'crew_leave_man' => $request->crew_leave_man,
                'crew_sick_leave' => $request->crew_sick_leave,
                'crew_sick_leave_man' => $request->crew_sick_leave_man,
                'crew_mcu' => $request->crew_mcu,
                'crew_mcu_man' => $request->crew_mcu_man,
                'crew_total_power' => $request->crew_total_power,
                'crew_total_power_man' => $request->crew_total_power_man,
                'contractor_total' => $request->contractor_total,
                'contractor_total_man' => $request->contractor_total_man,
                'contractor_leave' => $request->contractor_leave,
                'contractor_leave_man' => $request->contractor_leave_man,
                'contractor_sick_leave' => $request->contractor_sick_leave,
                'contractor_sick_leave_man' => $request->contractor_sick_leave_man,
                'contractor_mcu' => $request->contractor_mcu,
                'contractor_mcu_man' => $request->contractor_mcu_man,
                'contractor_total_power' => $request->contractor_total_power,
                'contractor_total_power_man' => $request->contractor_total_power_man,
            ]);

        return redirect()->route('man-power.index')->with('success', 'Data saved!');
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
            'date' => $request->date,
            'area_id' => $request->area_id,
            'crew_total' => $request->crew_total,
            'crew_total_man' => $request->crew_total_man,
            'crew_leave' => $request->crew_leave,
            'crew_leave_man' => $request->crew_leave_man,
            'crew_sick_leave' => $request->crew_sick_leave,
            'crew_sick_leave_man' => $request->crew_sick_leave_man,
            'crew_mcu' => $request->crew_mcu,
            'crew_mcu_man' => $request->crew_mcu_man,
            'crew_total_power' => $request->crew_total_power,
            'crew_total_power_man' => $request->crew_total_power_man,
            'contractor_total' => $request->contractor_total,
            'contractor_total_man' => $request->contractor_total_man,
            'contractor_leave' => $request->contractor_leave,
            'contractor_leave_man' => $request->contractor_leave_man,
            'contractor_sick_leave' => $request->contractor_sick_leave,
            'contractor_sick_leave_man' => $request->contractor_sick_leave_man,
            'contractor_mcu' => $request->contractor_mcu,
            'contractor_mcu_man' => $request->contractor_mcu_man,
            'contractor_total_power' => $request->contractor_total_power,
            'contractor_total_power_man' => $request->contractor_total_power_man,
        ]);

        return redirect()->route('man-power.index')->with('success', 'Data saved!');
    }

    public function destroy($id)
    {
        $manPower = ManPower::findOrFail($id);
        $manPower->delete();

        return redirect()->route('man-power.history')->with('success', 'Man Power deleted successfully');
    }

}
