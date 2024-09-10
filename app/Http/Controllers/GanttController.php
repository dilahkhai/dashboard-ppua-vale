<?php


namespace App\Http\Controllers;

use App\Models\Link;
use App\Models\Task;

class GanttController extends Controller
{
    public function get()
    {
        $tasks = Task::all();
        $links = Link::all();
 
        return response()->json([
            "data" => $tasks,
            "links" => $links
        ]);
    }

}
