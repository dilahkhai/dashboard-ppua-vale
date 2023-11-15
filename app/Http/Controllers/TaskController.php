<?php

namespace App\Http\Controllers;

use App\Models\Area;
use Illuminate\Http\Request;
use App\Models\Task;
use App\Models\User;
use Carbon\Carbon;

class TaskController extends Controller
{
    public function index(){
        return view("MainProject");
    }

    public function get(){
        $tasks = Task::with("owner")->get();

        return response()->json([
            "data" => $tasks->all()
        ]);
    }

    public function manageTask(){
        $task = Task::with("owner")->get();
        $list_user = User::pluck("name", "id");
        $areas = Area::all();

        return view("ManageMainProject")->with([
            "tasks" => $task,
            "list_user" => $list_user,
            'areas' => $areas
        ]);
    }

    public function storeTask(Request $request){
        $task = new Task;
        $task->name = $request->get("name") ;
        $task->area_id = $request->get('area_id');
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
        // dd($request->all());

        foreach ($request->get("id") as $index => $task_id) {
            Task::where("id", $task_id)->update([
                "name"  => $request->get("name")[$index],
                "area_id" => $request->get("area_id")[$index],
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
