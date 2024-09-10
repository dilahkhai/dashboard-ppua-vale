<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\User;
use App\Models\Area;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function index()
    {
        $areas = Area::all();

        $users = User::query()
            ->with('area')
            ->get()
            ->groupBy('area_id');

        return view('MainProject', compact('users', 'areas'));
    }
    
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
            'user_id' => 'required|integer',
            'area_id' => 'required|integer',
            'progress' => 'required|numeric',
            'parent' => 'nullable|integer', 
        ]);
    
        $task = new Task($validated);
        $task->sortorder = Task::max("sortorder") + 1;
        $task->save();
    
        return response()->json([
            "action"=> "inserted",
            "tid" => $task->id
        ]);
    }
    

    public function update(Request $request, $id)
    {
        $task = Task::find($id);
    
        if (!$task) {
            return response()->json(['error' => 'Task not found'], 404);
        }
    
        $validated = $request->validate([
            'name' => 'required|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
            'user_id' => 'required|integer',
            'progress' => 'required|numeric',
            'parent' => 'nullable|integer', 
        ]);
    
        $task->name = $validated['name'];
        $task->start_date = $validated['start_date'];
        $task->end_date = $validated['end_date'];
        $task->user_id = $validated['user_id'];
        $task->progress = $validated['progress'];
        if($request->has("target")){
            $this->updateOrder($id, $request->target);
        }
        $task->save();
    
        return response()->json(['action' => 'updated']);
    }

    private function updateOrder($taskId, $target){
        $nextTask = false;
        $targetId = $target;
     
        if(strpos($target, "next:") === 0){
            $targetId = substr($target, strlen("next:"));
            $nextTask = true;
        }
     
        if($targetId == "null")
            return;
     
        $targetOrder = Task::find($targetId)->sortorder;
        if($nextTask)
            $targetOrder++;
     
        Task::where("sortorder", ">=", $targetOrder)->increment("sortorder");
     
        $updatedTask = Task::find($taskId);
        $updatedTask->sortorder = $targetOrder;
        $updatedTask->save();
    }

    public function destroy($id)
    {
        $task = Task::findOrFail($id);
        $task->delete();

        return response()->json(['message' => 'Task deleted successfully.']);
    }
}
