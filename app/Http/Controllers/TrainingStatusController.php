<?php

namespace App\Http\Controllers;

use App\Models\Area;
use App\Models\employee;
use App\Models\TrainingStatus;
use App\Models\User;
use Illuminate\Http\Request;

class TrainingStatusController extends Controller
{
    public function index()
    {
        $trainings = TrainingStatus::query()->with('employee.area')->get();

        return view('training-status.index', compact('trainings'));
    }

    public function create()
    {
        $areas = Area::query()
            ->get(['area', 'id']);

        return view('training-status.create', compact('areas'));
    }

    public function edit(TrainingStatus $trainingStatus)
    {
        $employees = User::query()
            ->where('role', 'user')
            ->get();

        $areas = Area::query()
            ->get();

        return view('training-status.edit', compact('trainingStatus', 'employees', 'areas'));
    }

    public function store(Request $request)
    {
        TrainingStatus::query()
            ->create($request->except('_token', 'area_id'));

        return redirect()->route('training-status.index')->with('success', 'Success create training status!');
    }

    public function update(Request $request, TrainingStatus $trainingStatus)
    {
        $trainingStatus->update($request->except('_token', 'area_id'));

        return redirect()->route('training-status.index')->with('success', 'Success updating training status!');
    }

    public function destroy(TrainingStatus $trainingStatus)
    {
        $trainingStatus->delete();

        return back()->with('success', 'Success deleting training status!');
    }
}
