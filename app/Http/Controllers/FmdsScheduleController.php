<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FmdsSchedule;
use App\Models\Area;

class FmdsScheduleController extends Controller
{
    public function index()
    {
        $areas = Area::query()
            ->get();

        return view('fmds.index', compact('schedules'));
    }

    public function create()
    {
        $areas = Area::all();
        return view('fmds.create', compact('areas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'fmds_date' => 'required|date',
            'area_id' => 'required|exists:areas,id',
        ]);

        FmdsSchedule::create($request->all());

        return redirect()->route('fmds.index')->with('success', 'Schedule created successfully.');
    }

    public function show(FmdsSchedule $fmdsSchedule)
    {
        return view('fmds.show', compact('fmdsSchedule'));
    }

    public function edit(FmdsSchedule $fmdsSchedule)
    {
        $areas = Area::all();
        return view('fmds.edit', compact('fmdsSchedule', 'areas'));
    }

    public function update(Request $request, FmdsSchedule $fmdsSchedule)
    {
        $request->validate([
            'fmds_date' => 'required|date',
            'area_id' => 'required|exists:areas,id',
        ]);

        $fmdsSchedule->update($request->all());

        return redirect()->route('fmds.index')->with('success', 'Schedule updated successfully.');
    }

    public function destroy(FmdsSchedule $fmdsSchedule)
    {
        $fmdsSchedule->delete();

        return redirect()->route('fmds.index')->with('success', 'Schedule deleted successfully.');
    }

    
}
