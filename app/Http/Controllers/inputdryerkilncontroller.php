<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SafetyReport;
use App\Models\User;
use App\Models\Department;
use App\Models\productivity;
use App\Models\statusperday;
use App\Models\ManHour;
use App\Models\Kaizen;
use App\Models\StatusMcu;
use App\Models\Task;
use Carbon\Carbon;
use App\Models\WorkingTimePerWeek;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use App\Models\OrganizationStructure;
use Illuminate\Support\Str;

class inputdryerkilncontroller extends Controller
{
    public function index()
    {
        $user = User::with([
            "today_safety_report",
            "today_working_time_per_week",
            "todaystatusperday"
        ])
            ->whereHas("area", function ($query) {
                $query->where("area", "Process Plant Automation");
            })->get();
        $department = Department::with(["today_productivity" => function ($query) {
            $query->whereHas("area", function ($query) {
                $query->where("area", "Process Plant Automation");
            });
        }])->get();

        $organization = OrganizationStructure::where("area_id", 2)
            ->whereDate("created_at", Carbon::now())
            ->first();


        $Kaizen = Kaizen::where("area_id", 2)
            ->whereDate("created_at", Carbon::now())->first();


        $StatusMcu = StatusMcu::where("area_id", 2)
            ->whereDate("created_at", Carbon::now())->first();

        $task = Task::with("owner")->where("area_id", 2)->get();
        $list_user = User::where("area_id", 2)->pluck("name", "id");
        // return $task;
        return view('inputdryerkiln')->with([
            "user"   =>  $user,
            "departments"    => $department,
            "organization"  => $organization,
            "kaizen"        => $Kaizen,
            "mcu"   => $StatusMcu,
            "tasks" => $task,
            "list_user" => $list_user
        ]);
    }

    public function store(Request $request)
    {
        $employee_list = $request->get("employee");
        $count_list = $request->get("count");

        foreach ($employee_list as $index => $employee_id) {
            $safety_report = SafetyReport::where("employee_id", $employee_id)
                ->whereDate("created_at", Carbon::now())
                ->first();

            if (is_null($safety_report)) {
                $safety_report = new SafetyReport;
            }

            $safety_report->employee_id = $employee_id;
            $safety_report->count = $count_list[$index];
            $safety_report->created_at = $request->datestatus;
            $safety_report->save();
        }
        return redirect()->back()->with('success', 'success');
    }

    public function storeProductivity(Request $request)
    {
        $department_list = $request->get("department");
        $value_list = $request->get("departmentValue");

        foreach ($department_list as  $index => $department_id) {
            $productivity = productivity::where("department_id", $department_id)
                ->whereDate("created_at", Carbon::now())
                ->where("area_id", 2)
                ->first();
            if (is_null($productivity)) {
                $productivity = new productivity;
            }
            $productivity->area_id = 2;
            $productivity->department_id = $department_id;
            $productivity->update = $value_list[$index];
            $productivity->selisih = 100 - $value_list[$index];
            $productivity->created_at = $request->datestatus;
            $productivity->save();
        }
        return redirect()->back()->with('success', 'success');
    }

    public function storeWorkingWeek(Request $request)
    {
        $employee_list = $request->get("employee");
        $count_list = $request->get("employee_value");

        foreach ($employee_list as $index => $employee_id) {
            $WorkingTimePerWeek = WorkingTimePerWeek::where("employee_id", $employee_id)
                ->whereDate("created_at", Carbon::now())
                ->first();

            if (is_null($WorkingTimePerWeek)) {
                $WorkingTimePerWeek = new WorkingTimePerWeek;
            }

            $WorkingTimePerWeek->employee_id = $employee_id;
            $WorkingTimePerWeek->update = $count_list[$index];
            $WorkingTimePerWeek->selisih = 100 - $count_list[$index];
            $WorkingTimePerWeek->created_at = $request->datestatus;
            $WorkingTimePerWeek->save();
        }
        return redirect()->back()->with('success', 'success');
    }

    public function storeStatusPerDay(Request $request)
    {
        $employee_list = $request->get("employee");
        $offices = $request->get("offices");
        $hos = $request->get("hos");
        $trainings = $request->get("trainings");
        $sick_leaves = $request->get("sick_leaves");
        $annual_leaves = $request->get("annual_leaves");
        $emergency_leaves = $request->get("emergency_leaves");
        $medical_leaves = $request->get("medical_leaves");
        $maternity_leaves = $request->get("maternity_leaves");

        foreach ($employee_list as $index => $employee_id) {
            $statusperday = statusperday::where("employee_id", $employee_id)
                ->whereDate("created_at", Carbon::now())
                ->first();

            if (is_null($statusperday)) {
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
            $statusperday->created_at = $request->datestatus;
            $statusperday->save();
        }
        return redirect()->back()->with('success', 'success');
    }

    public function storeOrganization(Request $request)
    {
        $organization = OrganizationStructure::where("area_id", 2)
            ->whereDate("created_at", Carbon::now())->first();

        if (is_null($organization)) {
            $organization = new OrganizationStructure;
        }

        $organization->value = $request->get("value");
        $organization->area_id = 2;
        $organization->created_at = $request->datestatus;
        $organization->save();

        return redirect()->back()->with('success', 'success');
    }

    public function import(Request $request)
    {
        $file = $request->file('file');
        $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
        $spreadsheet = $reader->load($file->getRealPath());
        $sheet = $spreadsheet->getActiveSheet();

        $sheet_count = $spreadsheet->getSheetCount();
        $latest_week = null;
        $latest_week_sheet = null;
        $auto_project_sheet = null;
        $manhours_sheet = null;

        for ($i = 0; $i < $sheet_count; $i++) {
            $current_sheet = $spreadsheet->getSheet($i);
            $sheet_name = $spreadsheet->getSheetNames()[$i];

            if (str_contains($sheet_name, "Week")) {
                $weekNumber = str_replace("Week", "", $sheet_name);
                if ($latest_week == null || $latest_week < $weekNumber) {
                    if (is_numeric($weekNumber)) {
                        $latest_week = $weekNumber;
                        $latest_week_sheet = $current_sheet;
                    }
                }
            } else if (str_contains($sheet_name, "AutoProject")) {
                $auto_project_sheet = $current_sheet;
            } else if (str_contains($sheet_name, "Manhours monthly")) {
                $manhours_sheet = $current_sheet;
            }

            // $result[] = [
            //     "name"  => ,
            //     "value" => $current_sheet->getCell('A1')->getValue()
            // ];
        }


        // Auto Project
        // if(!is_null($auto_project_sheet)){
        //     $department_list = [
        //         "RND"   => [
        //             "id"    => 1,
        //             "cell"  => 367
        //         ],
        //         "Automation_Project"   => [
        //             "id"    => 2,
        //             "cell"  => 368
        //         ],
        //         "Tech_Support"   => [
        //             "id"    => 3,
        //             "cell"  => 369
        //         ],
        //         "Management"   => [
        //             "id"    => 4,
        //             "cell"  => 370
        //         ],
        //         "Maintenance"   => [
        //             "id"    => 5,
        //             "cell"  => 371
        //         ]
        //     ];

        //     foreach ($department_list as $key => $value) {
        //         $productivity = productivity::where("department_id", $value["id"])
        //                             ->whereDate("created_at", Carbon::now())
        //                             ->where("area_id", 2)
        //                             ->first();
        //         if(is_null($productivity)){
        //             $productivity = new productivity;
        //         }
        //         $data = str_replace("%","",$auto_project_sheet->getCell("B".$value["cell"])->getFormattedValue());

        //         $productivity->area_id = 2;
        //         $productivity->department_id = $value["id"];
        //         $productivity->update = $data;
        //         $productivity->selisih = 100 - $data;
        //         $productivity->created_at = $request->datestatus;
        //         $productivity->save();
        //     }
        // }

        // input week
        if (!is_null($latest_week_sheet)) {
            $rows = $latest_week_sheet->toArray();
            $list_name = array_slice($rows[5], 3);
            $list_value = array_slice($rows[7], 3);
        }

        foreach ($list_name as $index => $username) {
            $WorkingTimePerWeek = WorkingTimePerWeek::whereHas("employee", function ($query) use ($username) {
                $query->where("username", $username);
            })->whereDate("created_at", Carbon::now())
                ->first();

            if (is_null($WorkingTimePerWeek)) {
                $WorkingTimePerWeek = new WorkingTimePerWeek;
            }

            $employee  = User::where("username", $username)->first();
            if (!is_null($employee)) {
                $WorkingTimePerWeek->employee_id = $employee->id;
                $WorkingTimePerWeek->update = $list_value[$index];
                $WorkingTimePerWeek->selisih = 100 - $list_value[$index];
                $WorkingTimePerWeek->created_at = $request->datestatus;
                $WorkingTimePerWeek->save();
            }
        }

        //  input manhours
        if (!is_null($manhours_sheet)) {
            $rows = $manhours_sheet->toArray();
            $list_name = array_slice($rows[5], 3);
            $list_value = array_slice($rows[7], 3);

            $listUsername = [];
            foreach ($list_name as $index => $name) {
                $slice = Str::between($name, '(', ')');
                $listUsername[] = $slice;
            }

            foreach ($listUsername as $index => $username) {
                $manhour = ManHour::whereHas("employee", function ($query) use ($username) {
                    $query->where("username", $username);
                })->whereDate("created_at", Carbon::now())
                    ->first();

                if (is_null($manhour)) {
                    $manhour = new ManHour;
                }

                $employee  = User::where("username", $username)->first();
                if (!is_null($employee)) {
                    $manhour->employee_id = $employee->id;
                    $manhour->update = $list_value[$index];
                    $manhour->created_at = $request->datestatus;
                    $manhour->save();
                }
            }
        }



        return redirect()->back()->with('success', 'success');
    }

    public function storeKaizen(Request $request)
    {
        $Kaizen = Kaizen::where("area_id", 2)
            ->whereDate("created_at", Carbon::now())->first();

        if (is_null($Kaizen)) {
            $Kaizen = new Kaizen;
        }

        $Kaizen->value = $request->get("value");
        $Kaizen->area_id = 2;
        $Kaizen->created_at = $request->datestatus;
        $Kaizen->save();

        return redirect()->back()->with('success', 'success');
    }

    public function storeMcu(Request $request)
    {
        $StatusMcu = StatusMcu::where("area_id", 2)
            ->whereDate("created_at", Carbon::now())->first();

        if (is_null($StatusMcu)) {
            $StatusMcu = new StatusMcu;
        }

        $StatusMcu->value = $request->get("value");
        $StatusMcu->area_id = 2;
        $StatusMcu->created_at = $request->datestatus;
        $StatusMcu->save();

        return redirect()->back()->with('success', 'success');
    }

    public function storeTask(Request $request)
    {
        $task = new Task;
        $task->name = $request->get("name");
        $task->area_id = 2;
        $task->user_id = $request->get("owner");
        $task->priority = $request->get("priority");
        $task->duration = $request->get("duration");
        $task->start_date = $request->get("start_date");
        $task->status = $request->get("status");
        $task->created_at = $request->datestatus;
        $task->save();
        return redirect()->back()->with('success', 'success');
    }

    public function deleteTask($id)
    {
        Task::where("id", $id)->delete();
        return redirect()->back()->with('success', 'success');
    }

    public function updateTask(Request $request)
    {
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
