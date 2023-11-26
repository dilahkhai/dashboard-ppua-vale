<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SafetyReport;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Department;
use App\Models\OrganizationStructure;
use App\Models\Kaizen;

use App\Models\Task;
use App\Models\Link;
use App\Models\mcu;
use App\Models\StatusMcu;

class dashboarddryerkilncontroller extends Controller
{
    public function index()
    {
        $employee = User::query()
            ->with(["safety_reports" => function ($query) {
                $query
                    ->when(request('from'), function ($query) {
                        $query->whereDate('created_at', '>=', request('from'));
                    }, function ($query) {
                        $query->whereDate('created_at', '>=', now()->startOfDay());
                    })
                    ->when(request('to'), function ($query) {
                        $query->whereDate('created_at', '<=', request('to'));
                    }, function ($query) {
                        $query->whereDate('created_at', '<=', now()->endOfDay());
                    });
            }, "working_time_per_week" => function ($query) {
                $query
                    ->when(request('from'), function ($query) {
                        $query->whereDate('created_at', '>=', request('from'));
                    }, function ($query) {
                        $query->whereDate('created_at', '>=', now()->startOfDay());
                    })
                    ->when(request('to'), function ($query) {
                        $query->whereDate('created_at', '<=', request('to'));
                    }, function ($query) {
                        $query->whereDate('created_at', '<=', now()->endOfDay());
                    });
            }, "statusperday" => function ($query) {
                $query
                    ->when(request('from'), function ($query) {
                        $query->whereDate('created_at', '>=', request('from'));
                    }, function ($query) {
                        $query->whereDate('created_at', '>=', now()->startOfDay());
                    })
                    ->when(request('to'), function ($query) {
                        $query->whereDate('created_at', '<=', request('to'));
                    }, function ($query) {
                        $query->whereDate('created_at', '<=', now()->endOfDay());
                    });
            }, "manhours" => function ($query) {
                $query
                    ->when(request('from'), function ($query) {
                        $query->whereDate('created_at', '>=', request('from'));
                    }, function ($query) {
                        $query->whereDate('created_at', '>=', now()->startOfDay());
                    })
                    ->when(request('to'), function ($query) {
                        $query->whereDate('created_at', '<=', request('to'));
                    }, function ($query) {
                        $query->whereDate('created_at', '<=', now()->endOfDay());
                    });
            }])
            ->withCount(['tasks as finished_tasks' => function ($query) {
                $query->where('status', 'Complete');
            }])
            ->withCount(['tasks as unfinished_tasks' => function ($query) {
                $query->whereNot('status', 'Complete');
            }])
            ->whereHas("area", function ($query) {
                $query->where("area", "Dryer-Kiln");
            })->get();

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

        foreach ($employee as $key => $value) {
            array_push($listSafetyEmployee, $value->name);
            if (count($value->safety_reports) > 0) {
                array_push($listSafetyValue, $value->safety_reports[0]->count);
            } else {
                array_push($listSafetyValue, 0);
            }

            if ($value->finished_tasks > 0) {
                array_push($listWorkingTimePerWeek, [$value->finished_tasks, $value->unfinished_tasks]);
            } else {
                array_push($listWorkingTimePerWeek, [null, $value->unfinished_tasks]);
            }

            if (count($value->statusperday) > 0) {
                $tempOffice = $value->statusperday->sum('office');
                $tempHo = $value->statusperday->sum('ho');
                $tempTraining = $value->statusperday->sum('training');
                $tempSickLeave = $value->statusperday->sum('sick_leave');
                $tempAnnualLeave = $value->statusperday->sum('annual_leave');
                $tempEmergencyLeave = $value->statusperday->sum('emergency_leave');
                $tempMedicalLeave = $value->statusperday->sum('medical_leave');
                $tempMaternityLeave = $value->statusperday->sum('maternity_leave');

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
        $department = Department::with(["productivity" => function ($query) {
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
                ->whereHas("area", function ($query) {
                    $query->where("area", "Dryer-Kiln");
                });
        }])->get();

        $listDepartment = [];
        $listDepartmentValue = [];
        foreach ($department as $key => $value) {
            array_push($listDepartment, $value->name);
            if (count($value->productivity) > 0) {
                array_push($listDepartmentValue, $value->productivity[0]->update);
            } else {
                array_push($listDepartmentValue, 0);
            }
        }
        // End Productivity

        $organization = OrganizationStructure::where("area_id", 2)
            ->when(request('from'), function ($query) {
                $query->whereDate('created_at', '>=', request('from'));
            }, function ($query) {
                $query->whereDate('created_at', '>=', now()->startOfDay());
            })
            ->first();


        $Kaizen = Kaizen::where("area_id", 2)
            ->when(request('from'), function ($query) {
                $query->whereDate('created_at', '>=', request('from'));
            }, function ($query) {
                $query->whereDate('created_at', '>=', now()->startOfDay());
            })->first();


        $mcu = mcu::query()
            ->whereHas('employee', function ($query) {
                $query->where("area_id", 2);
            })
            ->get();

        $mcuDone = $mcu->filter(fn ($data) => $data->status == "DONE")->count();
        $mcuCount = $mcu->count() == 0 ? 1 : $mcu->count();

        $StatusMcu = ($mcuDone / $mcuCount) * 100;

        return view('dashboarddryerkiln')->with([
            "kaizen"    => $Kaizen,
            "statusMcu" => $StatusMcu,
            "employees" => $employee,
            "safety_employees"  => $listSafetyEmployee,
            "safety_values" => $listSafetyValue,
            // Department
            "departments"  => $listDepartment,
            "department_values" => $listDepartmentValue,
            // listWorkingTimePerWeek
            "working_time_per_week" => $listWorkingTimePerWeek,
            "offices"   => $listOffice,
            "ho"    => $listHo,
            "trainings" => $listTraining,
            "sick_leaves"   => $listSickLeave,
            "annual_leaves" => $listAnnualLeave,
            "emergency_leaves"  => $listEmergencyLeave,
            "medical_leaves"    => $listMedicalLeave,
            "maternity_leaves"  => $listMaternityLeave,
            "wta"       => $listWta,
            "manhours"  => $listManHours,
            "organization"  => $organization
        ]);
    }

    public function get()
    {
        $tasks = Task::with("owner.area")
            ->where("area_id", 2)->get();

        return response()->json([
            "data" => $tasks->all()
        ]);
    }
}
