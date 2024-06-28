<?php

namespace App\Http\Controllers;

use App\Models\Area;
use App\Models\EmployeeLeave;
use App\Models\ManPower;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EmployeeLeaveController extends Controller
{
    public function index(ManPower $manPower)
    {
        $leaves = EmployeeLeave::query()
            ->with('employee')
            ->whereBelongsTo($manPower)
            ->paginate(10);

        $employees = User::query()
            ->whereBelongsTo($manPower->area)
            ->get();

        return view('manpower.input-leave', compact('leaves', 'employees', 'manPower'));
    }

    public function store(Request $request, ManPower $manPower)
    {
        if (Auth::user()->role == 'admin') {
            EmployeeLeave::query()
                ->create($request->validate([
                    'user_id' => 'required|exists:users,id',
                    'type' => 'required',
                    'date_start' => 'required',
                    'date_end' => 'required'
                ]) + ['man_power_id' => $manPower->id]);
        } else {
            EmployeeLeave::query()
                ->create($request->validate([
                    'type' => 'required',
                    'date_start' => 'required',
                    'date_end' => 'required'
                ]) + ['man_power_id' => $manPower->id, 'user_id' => Auth::user()->id]);
        }

        return back()->with('success', 'Success!');
    }
}
