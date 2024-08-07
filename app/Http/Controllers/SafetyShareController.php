<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Area;
use App\Models\User;
use App\Models\SafetyShare;
use App\Models\ManPower;
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

        $users = User::query()
            ->with('area')
            ->get()
            ->groupBy('area_id');
        return view('fmds.index', compact('safetyShares', 'manpowers', 'areas', 'users'));
    }

    public function show(SafetyShare $safetyShare)
    {
        return view('fmds.index', compact('safetyShare'));
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
                'end' => $safetyShare->safetydate,
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
        $safetyShare = SafetyShare::find($id);
        $safetyShare->delete();
        return redirect()->route('fmds.index')->with('success', 'Safety Share schedule deleted successfully!');
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
    return view('fmds.index', compact('manpowers', 'startDate', 'endDate'));
}

}
