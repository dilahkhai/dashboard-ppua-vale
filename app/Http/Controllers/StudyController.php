<?php

namespace App\Http\Controllers;

use App\Models\Area;
use App\Models\Study;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class StudyController extends Controller
{
    public function index()
    {
        $areas = Area::query()
            ->get();

        return view('study.index', compact('areas'));
    }

    public function store(Request $request)
    {
        Study::query()
            ->create($request->except('_token', 'area_id'));

        return back()->with('success', 'Schedule saved!');
    }

    public function storeFile(Request $request)
    {
        $study = Study::query()
            ->where('study_date', Carbon::parse($request->study_date)->toDateString())
            ->firstOr(function () {
                return back()->with('error', 'Sharing Schedule not Found!');
            });

        if ($study->file) {
            Storage::delete($study->file);
        }

        $filename = Str::snake($study->employee->name . Carbon::parse($request->study_date)->toDateString()) . '.' . $request->file('file')->getClientOriginalExtension();

        $request->file('file')->storePubliclyAs('public/study_file', $filename);

        $study->update(['file' => 'storage/study_file/' . $filename, 'name' => $request->name]);

        return back()->with('success', 'File saved!');
    }

    public function source()
    {
        $oncall = Study::query()
            ->with('employee')
            ->get()
            ->transform(function ($value) {
                return [
                    'title' => $value->employee->name ?? "-",
                    'start' => $value->study_date,
                    'end' => $value->study_date
                ];
            })
            ->toArray();

        return response()->json($oncall);
    }

    public function sourceDetail()
    {
        $study = Study::query()
            ->where('study_date', Carbon::parse(request('study_date'))->format('Y-m-d'))
            ->first();

        $isOwner = Auth::user()->id === $study?->user_id || Auth::user()->role === 'admin';

        return response()->json(['study' => $study, 'isOwner' => $isOwner]);
    }
}
