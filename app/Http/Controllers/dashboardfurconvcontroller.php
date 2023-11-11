<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SafetyReport;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Department;
use App\Models\OrganizationStructure;
use App\Models\Kaizen;
use App\Models\StatusMcu;
use App\Models\Task;

class dashboardfurconvcontroller extends Controller
{
    public function index(Request $request)
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
            ->whereHas("area", function ($query) {
                $query->where("area", "Furnace-Converter");
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

            if (count($value->working_time_per_week) > 0) {
                array_push($listWorkingTimePerWeek, [$value->working_time_per_week[0]->update, $value->working_time_per_week[0]->selisih]);
            } else {
                array_push($listWorkingTimePerWeek, [0, 100]);
            }

            if (count($value->manhours) > 0) {
                array_push($listManHours, $value->manhours[0]->update);
            } else {
                array_push($listManHours, 0);
            }

            if (count($value->statusperday) > 0) {
                array_push($listOffice, $value->statusperday->sum('office'));
                array_push($listHo, $value->statusperday->sum('ho'));
                array_push($listTraining, $value->statusperday->sum('training'));
                array_push($listSickLeave, $value->statusperday->sum('sick_leave'));
                array_push($listAnnualLeave, $value->statusperday->sum('annual_leave'));
                array_push($listEmergencyLeave, $value->statusperday->sum('emergency_leave'));
                array_push($listMedicalLeave, $value->statusperday->sum('medical_leave'));
                array_push($listMaternityLeave, $value->statusperday->sum('maternity_leave'));
                array_push($listWta, $value->statusperday->sum('wta'));
            } else {
                array_push($listOffice, 0);
                array_push($listHo, 0);
                array_push($listTraining, 0);
                array_push($listSickLeave, 0);
                array_push($listAnnualLeave, 0);
                array_push($listEmergencyLeave, 0);
                array_push($listMedicalLeave, 0);
                array_push($listMaternityLeave, 0);
                array_push($listWta, 0);
            }
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
                    $query->where("area", "Furnace-Converter");
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

        $organization = OrganizationStructure::where("area_id", 1)
            ->when(request('from'), function ($query) {
                $query->whereDate('created_at', '>=', request('from'));
            }, function ($query) {
                $query->whereDate('created_at', '>=', now()->startOfDay());
            })
            ->first();


        $Kaizen = Kaizen::where("area_id", 1)
            ->when(request('from'), function ($query) {
                $query->whereDate('created_at', '>=', request('from'));
            }, function ($query) {
                $query->whereDate('created_at', '>=', now()->startOfDay());
            })->first();


        $StatusMcu = StatusMcu::where("area_id", 1)
            ->when(request('from'), function ($query) {
                $query->whereDate('created_at', '>=', request('from'));
            }, function ($query) {
                $query->whereDate('created_at', '>=', now()->startOfDay());
            })->first();

        return view('dashboardfurconv')->with([
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
        $tasks = Task::with("owner")
            ->where("area_id", 1)->get();

        return response()->json([
            "data" => $tasks->all()
        ]);
    }
}
