<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Issue;
use App\Models\Link;

class IssueGanttController extends Controller
{
    public function get()
    {
        $issue = Issue::all();
        $links = Link::all();

        return response()->json([
            "data" => $issue,
            "links" => $links
        ]);
    }
}
