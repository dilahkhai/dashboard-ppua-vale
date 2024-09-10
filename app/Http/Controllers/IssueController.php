<?php

namespace App\Http\Controllers;

use App\Models\Issue;
use App\Models\User;
use App\Models\Area;
use Illuminate\Http\Request;

class IssueController extends Controller
{
    public function index()
    {
        $areas = Area::all();
        
        $users = User::query()
        ->with('area')
        ->get()
        ->groupBy('area_id');

        return view('issue', compact('users', 'areas'));
    }
    
    public function store(Request $request)
    {
        \Log::info('Store Request Data: ', $request->all());

        $validated = $request->validate([
            'issue' => 'required|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
            'user_id' => 'required|integer',
            'area_id' => 'required|integer',
            'progress' => 'required|numeric',
            'action' => 'required|string', 
        ]);
    
        $issue = new Issue($validated);
        $issue->save();
    
        return response()->json([
            "action"=> "inserted",
            "tid" => $issue->id
        ]);
    }

    public function update(Request $request, $id)
    {
        $issue = Issue::find($id);
    
        if (!$issue) {
            return response()->json(['error' => 'Issue not found'], 404);
        }
    
        $validated = $request->validate([
            'issue' => 'required|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
            'user_id' => 'required|integer',
            'progress' => 'required|numeric',
            'action' => 'required|string', 
        ]);
    
        $issue->issue = $validated['issue'];
        $issue->start_date = $validated['start_date'];
        $issue->end_date = $validated['end_date'];
        $issue->user_id = $validated['user_id'];
        $issue->progress = $validated['progress'];
        $issue->action = $validated['action'];
        
        if ($request->has('target')) {
            $this->updateOrder($id, $request->target);
        }
        
        $issue->save();
    
        return response()->json(['action' => 'updated']);
    }

    public function destroy($id)
    {
        $issue = Issue::findOrFail($id);
        $issue->delete();

        return response()->json(['message' => 'Issue deleted successfully.']);
    }

    private function updateOrder($id, $target)
    {
        // Implement order update logic if necessary
    }
}
