<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Department;
use App\Models\OrganizationStructure;
use App\Models\Kaizen;
use App\Models\mcu;
use App\Models\StatusMcu;
use App\Models\Task;

class DashboardUtLController extends Controller
{
    public function index(Request $request)
    {
        $users = User::query()
            ->with('area')
            ->get()
            ->groupBy('area_id');

        // Ambil data employee berdasarkan area_id
        $employees = User::with(['safety_reports', 'working_time_per_week', 'statusperday', 'manhours'])
            ->whereHas('area', function ($query) {
                $query->where('id', 4); // Pastikan menggunakan kolom ID jika area_id adalah ID
            })
            ->withCount(['tasks as finished_tasks' => function ($query) {
                $query->where('progress', 1);
            }])
            ->withCount(['tasks as unfinished_tasks' => function ($query) {
                $query->whereNot('progress', 1);
            }])
            ->get();

        $listSafetyEmployee = [];
        $listSafetyValue = [];
        $listWorkingTimePerWeek = [];
        $listOffice = [];
        $listHo = [];
        $listTraining = [];
        $listSickLeave = [];
        $listAnnualLeave = [];
        $listEmergencyLeave = [];
        $listMedicalLeave = [];
        $listMaternityLeave = [];
        $listWta = [];
        $listManHours = [];

        foreach ($employees as $employee) {
            array_push($listSafetyEmployee, $employee->name);
            if ($employee->safety_reports->count() > 0) {
                array_push($listSafetyValue, $employee->safety_reports->first()->count);
            } else {
                array_push($listSafetyValue, 0);
            }

            if ($employee->finished_tasks > 0) {
                array_push($listWorkingTimePerWeek, [$employee->finished_tasks, $employee->unfinished_tasks]);
            } else {
                array_push($listWorkingTimePerWeek, [null, $employee->unfinished_tasks]);
            }

            if ($employee->statusperday->count() > 0) {
                $tempOffice = $employee->statusperday->sum('office');
                $tempHo = $employee->statusperday->sum('ho');
                $tempTraining = $employee->statusperday->sum('training');
                $tempSickLeave = $employee->statusperday->sum('sick_leave');
                $tempAnnualLeave = $employee->statusperday->sum('annual_leave');
                $tempEmergencyLeave = $employee->statusperday->sum('emergency_leave');
                $tempMedicalLeave = $employee->statusperday->sum('medical_leave');
                $tempMaternityLeave = $employee->statusperday->sum('maternity_leave');

                array_push($listOffice, $tempOffice);
                array_push($listHo, $tempHo);
                array_push($listTraining, $tempTraining);
                array_push($listSickLeave, $tempSickLeave);
                array_push($listAnnualLeave, $tempAnnualLeave);
                array_push($listEmergencyLeave, $tempEmergencyLeave);
                array_push($listMedicalLeave, $tempMedicalLeave);
                array_push($listMaternityLeave, $tempMaternityLeave);
                $tempManHours = $tempOffice + $tempHo + $tempSickLeave + $tempAnnualLeave + $tempTraining + $tempEmergencyLeave + $tempMedicalLeave + $tempMaternityLeave;
            } else {
                array_push($listOffice, 0);
                array_push($listHo, 0);
                array_push($listTraining, 0);
                array_push($listSickLeave, 0);
                array_push($listAnnualLeave, 0);
                array_push($listEmergencyLeave, 0);
                array_push($listMedicalLeave, 0);
                array_push($listMaternityLeave, 0);
                $tempManHours = 0;
            }

            array_push($listManHours, $tempManHours);
        }

        // Productivity
        $departments = Department::with(['productivity' => function ($query) {
            $query->when(request('from'), function ($query) {
                $query->whereDate('created_at', '>=', request('from'));
            }, function ($query) {
                $query->whereDate('created_at', '>=', now()->startOfDay());
            })
            ->when(request('to'), function ($query) {
                $query->whereDate('created_at', '<=', request('to'));
            }, function ($query) {
                $query->whereDate('created_at', '<=', now()->endOfDay());
            })
            ->whereHas('area', function ($query) {
                $query->where('id', 4);
            });
        }])->get();

        $listDepartment = [];
        $listDepartmentValue = [];
        foreach ($departments as $department) {
            array_push($listDepartment, $department->name);
            if ($department->productivity->count() > 0) {
                array_push($listDepartmentValue, $department->productivity->first()->update);
            } else {
                array_push($listDepartmentValue, 0);
            }
        }

        // Other Data
        $organization = OrganizationStructure::where('area_id', 4)
            ->when(request('from'), function ($query) {
                $query->whereDate('created_at', '>=', request('from'));
            }, function ($query) {
                $query->whereDate('created_at', '>=', now()->startOfDay());
            })
            ->first();

        $Kaizen = Kaizen::where('area_id', 4)
            ->when(request('from'), function ($query) {
                $query->whereDate('created_at', '>=', request('from'));
            }, function ($query) {
                $query->whereDate('created_at', '>=', now()->startOfDay());
            })
            ->first();

        $mcus = mcu::query()
            ->whereHas('employee', function ($query) {
                $query->where('area_id', 4);
            })
            ->get();

        $mcuDone = $mcus->filter(fn ($data) => $data->status === 'DONE')->count();
        $mcuCount = $mcus->count() == 0 ? 1 : $mcus->count();

        $statusMcu = ($mcuDone / $mcuCount) * 100;

        return view('dashboardutl')->with([
            'users' => $users,
            'kaizen' => $Kaizen,
            'statusMcu' => $statusMcu,
            'employees' => $employees,
            'safety_employees' => $listSafetyEmployee,
            'safety_values' => $listSafetyValue,
            'departments' => $listDepartment,
            'department_values' => $listDepartmentValue,
            'working_time_per_week' => $listWorkingTimePerWeek,
            'offices' => $listOffice,
            'ho' => $listHo,
            'trainings' => $listTraining,
            'sick_leaves' => $listSickLeave,
            'annual_leaves' => $listAnnualLeave,
            'emergency_leaves' => $listEmergencyLeave,
            'medical_leaves' => $listMedicalLeave,
            'maternity_leaves' => $listMaternityLeave,
            'wta' => $listWta,
            'manhours' => $listManHours,
            'organization' => $organization
        ]);
    }

    public function get()
    {
        $tasks = Task::with('owner.area')
            ->where('area_id', 4)
            ->get();

        return response()->json([
            'data' => $tasks->all()
        ]);
    }
}
