<?php

namespace App\Http\Controllers;

use App\Models\Area;
use Illuminate\Http\Request;
use App\Models\Task;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    public function index()
    {
        return view("MainProject");
    }

    public function get()
    {
        $user = User::find(request('user_id'));
        $tasks = Task::with("owner")
            ->when($user->role != 'admin', function ($query) use ($user) {
                $query->whereBelongsTo($user, 'owner');
            })
            ->get();

        return response()->json([
            "data" => $tasks->all()
        ]);
    }

    public function manageTask()
    {
        $task = Task::with("owner")
            ->when(Auth::user()->role != 'admin', function ($query) {
                $query->whereBelongsTo(Auth::user(), 'owner');
            })->get();

        $list_user = User::pluck("name", "id");
        $areas = Area::all();

        return view("ManageMainProject")->with([
            "tasks" => $task,
            "list_user" => $list_user,
            'areas' => $areas
        ]);
    }

    public function storeTask(Request $request)
    {
        $task = new Task;
        $task->name = $request->get("name");
        $task->area_id = Auth::user()->role == 'admin' ? $request->get('area_id') : Auth::user()->area_id;
        $task->user_id = Auth::user()->role == 'admin' ? $request->get("owner") : Auth::user()->id;
        $task->priority = $request->get("priority");
        $task->duration = $request->get("duration");
        $task->start_date = $request->get("start_date");
        $task->status = $request->get("status");
        $task->progress = $request->get("progress", 0);
        $task->created_at = Carbon::now();
        $task->save();
        return redirect()->route('tasks.manage')->with('success', 'Task Added Successfully!');
    }

    public function updateTask(Request $request)
    {
    // Check if 'id' is an array and not null
    if (is_array($request->get("id"))) {
        foreach ($request->get("id") as $index => $task_id) {
            Task::where("id", $task_id)->update([
                "name" => $request->get("name")[$index],
                "area_id" => Auth::user()->role == 'admin' ? $request->get("area_id")[$index] : Auth::user()->area_id,
                "user_id" => Auth::user()->role == 'admin' ? $request->get("owner")[$index] : Auth::user()->id,
                "priority" => $request->get("priority")[$index],
                "duration" => $request->get("duration")[$index],
                "start_date" => $request->get("start_date")[$index],
                "status" => $request->get("status")[$index],
                "progress" => $request->get("progress")[$index],
                "updated_at" => Carbon::now(),
            ]);
        }
        return redirect()->route('tasks.index')->with('success', 'Tasks Updated Successfully!');
    } else {
        return redirect()->route('tasks.index')->with('error', 'Invalid data provided.');
    }
}

}
