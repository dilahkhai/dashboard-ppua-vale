<?php

namespace App\Http\Controllers;

use App\Models\Area;
use App\Models\SubTraining;
use App\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon;

class SubTrainingController extends Controller
{
    public function index()
    {
        
        $trainings = SubTraining::all();
        return view('sub-training.index', compact('trainings'));
    }

    public function create()
    {
        $areas = Area::all();
        return view('sub-training.create', compact('areas'));
    }

    public function edit(SubTraining $subTraining)
    {
        $employees = User::where('role', 'user')->get();
        $areas = Area::all();
        return view('sub-training.edit', compact('subTraining', 'employees', 'areas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'training' => 'required|string',
            'area_id' => 'required|integer',
            'user_id' => 'required|integer',
            'certif_date' => 'required|date',
        ]);

        $subTraining = new SubTraining();
        $subTraining->training = $request->training;
        $subTraining->area_id = $request->area_id;
        $subTraining->user_id = $request->user_id;
        $subTraining->certif_date = $request->certif_date;

        $certifExpired = Carbon::parse($subTraining->certif_date);
        $oneMonthBeforeExpiration = $certifExpired->subMonth();
        $oneYearAfterCertification = $certifExpired->addYear();

        if (now()->greaterThanOrEqualTo($oneYearAfterCertification)) {
            $subTraining->status = 3; // Expired
        } elseif (now()->greaterThanOrEqualTo($oneMonthBeforeExpiration)) {
            $subTraining->status = 2; // Warning
        } else {
            $subTraining->status = 1; // Active
        }

        $subTraining->save();
        return redirect()->route('sub-training.index')->with('success', 'Success create training status!');
    }

    public function update(Request $request, SubTraining $subTraining)
{
    // Debugging line to see what data is being received

    // Validate data
    $request->validate([
        'training' => 'required|string',
        'area_id' => 'required|integer',
        'user_id' => 'required|integer',
        'certif_date' => 'required|date',
        'training_schedule' => 'required|date',
    ]);

    // Update sub-training data
    $subTraining->training = $request->training;
    $subTraining->area_id = $request->area_id;
    $subTraining->user_id = $request->user_id;
    $subTraining->certif_date = $request->certif_date;
    $subTraining->training_schedule = $request->training_schedule;

    $certifExpired = Carbon::parse($subTraining->certif_date);
    $oneMonthBeforeExpiration = $certifExpired->subMonth();
    $oneYearAfterCertification = $certifExpired->addYear();

    if (now()->greaterThanOrEqualTo($oneYearAfterCertification)) {
        $subTraining->status = 3; // Expired
    } elseif (now()->greaterThanOrEqualTo($oneMonthBeforeExpiration)) {
        $subTraining->status = 2; // Warning
    } else {
        $subTraining->status = 1; // Active
    }

    $subTraining->save();

    return redirect()->route('sub-training.index')->with('success', 'Success updating training status!');
}

public function show($id)
{
    $subTraining = SubTraining::findOrFail($id);
    return view('sub-training.show', compact('subTraining'));
}

    public function destroy(SubTraining $subTraining)
    {
        $subTraining->delete();
        return redirect()->route('sub-training.index')->with('success', 'Success deleting training status!');
    }
}
