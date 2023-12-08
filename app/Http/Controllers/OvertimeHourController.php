<?php

namespace App\Http\Controllers;

use App\Exports\OvertimeHourExport;
use App\Models\Area;
use App\Models\OvertimeHour;
use App\Models\User;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class OvertimeHourController extends Controller
{
    public function index()
    {
        $furnanceUser = User::query()
            ->withSum('overtime_hours', 'hour')
            ->where('area_id', 1)
            ->get(['name', 'overtime_hours_sum_hour']);

        $dryerUser = User::query()
            ->withSum('overtime_hours', 'hour')
            ->where('area_id', 2)
            ->get(['name', 'overtime_hours_sum_hour']);

        $infraUser = User::query()
            ->withSum('overtime_hours', 'hour')
            ->where('area_id', 3)
            ->get(['name', 'overtime_hours_sum_hour']);

        $utlUser = User::query()
            ->withSum('overtime_hours', 'hour')
            ->where('area_id', 4)
            ->get(['name', 'overtime_hours_sum_hour']);

        $data['furnanceUser'] = $furnanceUser
            ->map
            ->name
            ->toArray();

        $data['dryerUser'] = $dryerUser
            ->map
            ->name
            ->toArray();

        $data['infraUser'] = $infraUser
            ->map
            ->name
            ->toArray();

        $data['utlUser'] = $utlUser
            ->map
            ->name
            ->toArray();

        $data['furnanceHours'] = $furnanceUser
            ->map
            ->overtime_hours_sum_hour
            ->toArray();

        $data['dryerHours'] = $dryerUser
            ->map
            ->overtime_hours_sum_hour
            ->toArray();

        $data['infraHours'] = $infraUser
            ->map
            ->overtime_hours_sum_hour
            ->toArray();

        $data['utlHours'] = $utlUser
            ->map
            ->overtime_hours_sum_hour
            ->toArray();

        $data['areas'] = Area::all();

        $data['overtimes'] = OvertimeHour::query()
            ->when(auth()->user()->role != 'admin', function ($query) {
                $query->whereBelongsTo(auth()->user());
            })
            ->when(request('name'), function ($query) {
                $query->whereRelation('user', 'name', 'like', '%' . request('name') . '%');
            })
            ->when(request('from'), function ($query) {
                $query->whereDate('date', '>=', request('from'));
            })
            ->when(request('to'), function ($query) {
                $query->whereDate('date', '<=', request('to'));
            })
            ->get();

        return view('overtime.index', $data);
    }

    public function store(Request $request)
    {
        OvertimeHour::query()
            ->create([
                'user_id' => auth()->user()->role == 'admin' ? $request->employee : auth()->user()->id,
                'hour' => $request->hour,
                'date' => $request->date
            ]);

        return back()->with('success', 'Data saved successfully');
    }

    public function update(Request $request, OvertimeHour $overtimeHour)
    {
        $overtimeHour->update([
            'hour' => $request->hour,
            'date' => $request->date
        ]);

        return back()->with('success', 'Data saved successfully');
    }

    public function destroy(OvertimeHour $overtimeHour)
    {
        $overtimeHour->delete();

        return back()->with('success', 'Data deleted successfully');
    }

    public function export(Request $request)
    {
        $now = now()->toDateTimeString();

        return Excel::download(new OvertimeHourExport($request->from, $request->to), "overtime_hours_{$now}.xlsx");
    }
}
