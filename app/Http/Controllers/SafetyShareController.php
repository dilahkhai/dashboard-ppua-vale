<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Area;
use App\Models\User;
use App\Models\SafetyShare;
use App\Models\ManPower;
use App\Models\FmdsSchedule;
use Carbon\Carbon;

class SafetyShareController extends Controller
{

    public function index()
    {
        $safetyShares = SafetyShare::all();
        $areas = Area::all();
        $manpowers = ManPower::query()
            ->with(['user'])
            ->get()
            ->groupBy('area_id')
            ->map(function ($manpower) {
                return $manpower->last();
            });

        $fmdsSchedules = FmdsSchedule::all(); 

        $users = User::query()
            ->with('area')
            ->get()
            ->groupBy('area_id');
        
        return view('fmds.index', compact('safetyShares', 'manpowers', 'areas', 'fmdsSchedules', 'users'));
    }

    public function show(SafetyShare $safetyShare)
    {
        return response()->json([
            'id' => $safetyShare->id,
            'name' => $safetyShare->name,
            'date' => $safetyShare->safetydate,
        ]);   
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required',
            'safetydate' => 'required|date',
        ]);
        
        $safetyShare = new SafetyShare();
        $safetyShare->name = $validatedData['name'];
        $safetyShare->safetydate = $validatedData['safetydate'];
        $safetyShare->save();
        
        return redirect()->route('fmds.index')->with('success', 'Safety share schedule added successfully!');
    }

    public function source()
    {
        $events = SafetyShare::all()->map(function ($safetyShare) {
            return [
                'title' => $safetyShare->name,
                'start' => $safetyShare->safetydate,
                'allDay' => true
            ];
        });

        return response()->json($events);
    }

    public function edit($id)
    {
        $safetyShare = SafetyShare::find($id);
        return view('safety-shares.edit', compact('safetyShare'));
    }


    public function destroy($id)
    {
        $safetyShare = SafetyShare::findOrFail($id);
        $safetyShare->delete();
    
        return redirect()->route('fmds.index')->with('success', 'Schedule deleted successfully.');
    }

    public function showManPower(Request $request)
    {
        $startDate = $request->input('start_date', now()->startOfMonth()->toDateString());
        $endDate = $request->input('end_date', now()->endOfMonth()->toDateString());

        if ($startDate && $endDate) {
            $manpowers = ManPower::whereBetween('date', [$startDate, $endDate])->get();
        } else {
            $manpowers = collect();
        }

        $safetyShares = SafetyShare::all();
        $fmdsSchedules = FmdsSchedule::all();
        $areas = Area::all();
        

        return view('fmds.index', compact('manpowers', 'startDate', 'endDate', 'safetyShares', 'areas', 'fmdsSchedules'));
    }

    public function fmdsSource()
    {
        $events = FmdsSchedule::all()->map(function ($fmdsSchedule) {
            return [
                'title' => $fmdsSchedule->area->area,
                'start' => $fmdsSchedule->fmds_date,
                'allDay' => true,
            ];
        });

        return response()->json($events);
    }

    public function fmdsCreate()
    {
        $areas = Area::all();
        return view('fmds.create', compact('areas'));
    }

    public function fmdsStore(Request $request)
    {
        $validatedData = $request->validate([
            'fmds_date' => 'required|date',
            'area_id' => 'required|exists:areas,id',
        ]);

        \Log::info('FmdsStore Data:', $validatedData); 
        FmdsSchedule::create($validatedData);

        return redirect()->route('fmds.index')->with('success', 'Schedule created successfully.');
    }

    public function fmdsShow(FmdsSchedule $fmdsSchedule)
{
    return response()->json([
        'id' => $fmdsSchedule->id,
        'area_id' => $fmdsSchedule->area->area,
        'fmds_date' => $fmdsSchedule->fmds_date,
    ]);   
}


    public function fmdsEdit(FmdsSchedule $fmdsSchedule)
    {
        $areas = Area::all();
        return view('fmds.edit', compact('fmdsSchedule', 'areas'));
    }

    public function fmdsUpdate(Request $request, FmdsSchedule $fmdsSchedule)
    {
        $request->validate([
            'fmds_date' => 'required|date',
            'area_id' => 'required|exists:areas,id',
        ]);

        $fmdsSchedule->update($request->all());

        return redirect()->route('fmds.index')->with('success', 'Schedule updated successfully.');
    }
    

    public function fmdsDestroy($id)
    {
        $fmdsSchedule = FmdsSchedule::findOrFail($id);
        $fmdsSchedule->delete();
        
        return redirect()->route('fmds.index')->with('success', 'Schedule deleted successfully.');
    }
}
