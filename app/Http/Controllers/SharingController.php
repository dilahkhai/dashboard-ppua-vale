<?php

namespace App\Http\Controllers;

use App\Models\Area;
use App\Models\Sharing;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class SharingController extends Controller
{
    public function index()
    {
        $areas = Area::query()
            ->get();

        $sharings = Sharing::with('employee')->get();

        return view('sharing.index', compact('areas', 'sharings'));
    }

    public function store(Request $request)
    {
        Sharing::query()
            ->create($request->except('_token', 'area_id'));

        return back()->with('success', 'Schedule saved!');
    }

    public function storeFile(Request $request)
    {
        $sharing = Sharing::where('sharing_date', $request->sharing_date)->firstOrFail();
        
        if ($request->hasFile('file')) {
            if ($sharing->file && Storage::exists($sharing->file)) {
                Storage::delete($sharing->file);
            }

            $filename = Str::snake($sharing->employee->name . Carbon::parse($request->sharing_date)->toDateString()) . '.' . $request->file('file')->getClientOriginalExtension();
            $path = $request->file('file')->storePubliclyAs('public/sharing_file', $filename);
            
            $sharing->update([
                'file' => Storage::url($path),
            ]);
        }

        return redirect()->route('sharing-schedule.index')->with('success', 'File uploaded successfully.');
    }

    public function destroy(Sharing $sharing)
    {
        if ($sharing->file && Storage::exists($sharing->file)) {
            Storage::delete($sharing->file);
        }

        $sharing->delete();

        return back()->with('success', 'Sharing date deleted!');
    }

    public function source()
    {
        $oncall = Sharing::query()
            ->with('employee')
            ->get()
            ->transform(function ($value) {
                return [
                    'title' => $value->employee->name ?? "-",
                    'start' => $value->sharing_date,
                    'end' => $value->sharing_date
                ];
            })
            ->toArray();

        return response()->json($oncall);
    }

    public function sourceDetail(Request $request)
    {
        $sharingDate = $request->query('sharing_date');
        $sharing = Sharing::with('employee')->where('sharing_date', $sharingDate)->first();
        $isOwner = auth()->user()->role == 'admin';
         
        return response()->json([
            'isOwner' => $isOwner,
            'employee' => $sharing ? $sharing->employee : null,
        ]);
    }
}
