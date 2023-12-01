<?php

namespace App\Http\Controllers;

use App\Models\Area;
use App\Models\ManPower;
use Illuminate\Http\Request;

use function Ramsey\Uuid\v1;

class ManPowerController extends Controller
{
    public function index()
    {
        $manpowers = ManPower::query()->with(['user'])->paginate(10);

        return view('manpower.index', compact('manpowers'));
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
                'date' => $request->date
            ]);

        $manpower->crew()->create([
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
