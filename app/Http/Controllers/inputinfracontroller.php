<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SafetyReport;
use App\Models\User;
use App\Models\Department;
use App\Models\productivity;
use App\Models\statusperday;
use App\Models\Kaizen;
use App\Models\StatusMcu;
use Carbon\Carbon;
use App\Models\WorkingTimePerWeek;
use App\Models\OrganizationStructure;
use App\Models\Task;

class inputinfracontroller extends Controller
{
    public function index(){
        $user = User::with([
                "today_safety_report",
                "today_working_time_per_week",
                "todaystatusperday"
            ])
            ->whereHas("area", function($query){
                $query->where("area", "Infrastructure");
            })->get();
        $department = Department::with(["today_productivity" => function($query){
                    $query->whereHas("area", function($query){
                        $query->where("area", "Infrastructure");
                    });
                }])->get();

        $organization = OrganizationStructure::where("area_id", 3)
                            ->whereDate("created_at", Carbon::now())
                            ->first();


        $Kaizen = Kaizen::where("area_id", 3)
                        ->whereDate("created_at", Carbon::now())->first();


        $StatusMcu = StatusMcu::where("area_id", 3)
        ->whereDate("created_at", Carbon::now())->first();

        $task = Task::with("owner")->where("area_id", 3)->get();
        $list_user = User::where("area_id", 3)->pluck("name", "id");

        return view('inputinfra')->with([
            "user"   =>  $user,
            "departments"    => $department,
            "organization"  => $organization,
            "kaizen"        => $Kaizen,
            "mcu"   => $StatusMcu,
            "tasks" => $task,
            "list_user" => $list_user
        ]);
    }

    public function store(Request $request){
        $employee_list = $request->get("employee");
        $count_list = $request->get("count");

        foreach ($employee_list as $index => $employee_id) {
            $safety_report = SafetyReport::where("employee_id", $employee_id)
                                ->whereDate("created_at", Carbon::now())
                                ->first();

            if(is_null($safety_report)){
                $safety_report = new SafetyReport;
            }

            $safety_report->employee_id = $employee_id;
            $safety_report->count = $count_list[$index];
            $safety_report->created_at = Carbon::now();
            $safety_report->save();
        }
        return redirect()->back()->with('success', 'success');
    }

    public function storeProductivity(Request $request){
        $department_list = $request->get("department");
        $value_list = $request->get("departmentValue");

        foreach ($department_list as  $index => $department_id) {
            $productivity = productivity::where("department_id", $department_id)
                                ->whereDate("created_at", Carbon::now())
                                ->where("area_id", 3)
                                ->first();
            if(is_null($productivity)){
                $productivity = new productivity;
            }
            $productivity->area_id = 3;
            $productivity->department_id = $department_id;
            $productivity->update = $value_list[$index];
            $productivity->selisih = 100 - $value_list[$index];
            $productivity->created_at = Carbon::now();
            $productivity->save();

        }
        return redirect()->back()->with('success', 'success');
    }

    public function storeWorkingWeek(Request $request){
        $employee_list = $request->get("employee");
        $count_list = $request->get("employee_value");

        foreach ($employee_list as $index => $employee_id) {
            $WorkingTimePerWeek = WorkingTimePerWeek::where("employee_id", $employee_id)
                                ->whereDate("created_at", Carbon::now())
                                ->first();

            if(is_null($WorkingTimePerWeek)){
                $WorkingTimePerWeek = new WorkingTimePerWeek;
            }

            $WorkingTimePerWeek->employee_id = $employee_id;
            $WorkingTimePerWeek->update = $count_list[$index];
            $WorkingTimePerWeek->selisih = 100 - $count_list[$index];
            $WorkingTimePerWeek->created_at = Carbon::now();
            $WorkingTimePerWeek->save();
        }
        return redirect()->back()->with('success', 'success');
    }

    public function storeStatusPerDay(Request $request){
        $employee_list = $request->get("employee");
        $offices = $request->get("offices");
        $hos = $request->get("hos");
        $trainings = $request->get("trainings");
        $sick_leaves = $request->get("sick_leaves");
        $annual_leaves = $request->get("annual_leaves");
        $emergency_leaves = $request->get("emergency_leaves");
        $medical_leaves = $request->get("medical_leaves");
        $maternity_leaves = $request->get("maternity_leaves");
        $wta = $request->get("wta");

        foreach ($employee_list as $index => $employee_id) {
            $statusperday = statusperday::where("employee_id", $employee_id)
                                ->whereDate("created_at", Carbon::now())
                                ->first();

            if(is_null($statusperday)){
                $statusperday = new statusperday;
            }

            $statusperday->employee_id = $employee_id;
            $statusperday->office = $offices[$index];
            $statusperday->ho = $hos[$index];
            $statusperday->training = $trainings[$index];
            $statusperday->sick_leave = $sick_leaves[$index];
            $statusperday->annual_leave = $annual_leaves[$index];
            $statusperday->emergency_leave = $emergency_leaves[$index];
            $statusperday->medical_leave = $medical_leaves[$index];
            $statusperday->maternity_leave = $maternity_leaves[$index];
            $statusperday->wta = $wta[$index];
            $statusperday->created_at = Carbon::now();
            $statusperday->save();
        }
        return redirect()->back()->with('success', 'success');
    }

    public function storeOrganization(Request $request){
        $organization = OrganizationStructure::where("area_id", 3)
                        ->whereDate("created_at", Carbon::now())->first();

        if(is_null($organization)){
            $organization = new OrganizationStructure;
        }

        $organization->value = $request->get("value");
        $organization->area_id = 3;
        $organization->created_at = Carbon::now();
        $organization->save();

        return redirect()->back()->with('success', 'success');
    }

    public function storeKaizen(Request $request){
        $Kaizen = Kaizen::where("area_id", 3)
                        ->whereDate("created_at", Carbon::now())->first();

        if(is_null($Kaizen)){
            $Kaizen = new Kaizen;
        }

        $Kaizen->value = $request->get("value");
        $Kaizen->area_id = 3;
        $Kaizen->created_at = Carbon::now();
        $Kaizen->save();

        return redirect()->back()->with('success', 'success');
    }

    public function storeMcu(Request $request){
        $StatusMcu = StatusMcu::where("area_id", 3)
                        ->whereDate("created_at", Carbon::now())->first();

        if(is_null($StatusMcu)){
            $StatusMcu = new StatusMcu;
        }

        $StatusMcu->value = $request->get("value");
        $StatusMcu->area_id = 3;
        $StatusMcu->created_at = Carbon::now();
        $StatusMcu->save();

        return redirect()->back()->with('success', 'success');
    }

    public function storeTask(Request $request){
        $task = new Task;
        $task->name = $request->get("name") ;
        $task->area_id = 3;
        $task->user_id = $request->get("owner");
        $task->priority = $request->get("priority");
        $task->duration = $request->get("duration");
        $task->start_date = $request->get("start_date");
        $task->status = $request->get("status");
        $task->created_at = Carbon::now();
        $task->save();
        return redirect()->back()->with('success', 'success');
    }

    public function updateTask(Request $request){
        foreach ($request->get("id") as $index => $task_id) {
            Task::where("id", $task_id)->update([
                "name"  => $request->get("name")[$index],
                "user_id"  => $request->get("owner")[$index],
                "priority"  => $request->get("priority")[$index],
                "duration"  => $request->get("duration")[$index],
                "start_date"  => $request->get("start_date")[$index],
                "status"  => $request->get("status")[$index],
                "updated_at"  => Carbon::now(),
            ]);
        }
        return redirect()->back()->with('success', 'success');
    }
}
