<?php

namespace App\Http\Controllers;

use App\Models\Area;
use App\Models\Sharing;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class SharingController extends Controller
{
    public function index()
    {
        $areas = Area::query()
            ->get();

        return view('sharing.index', compact('areas'));
    }

    public function store(Request $request)
    {
        Sharing::query()
            ->create($request->except('_token', 'area_id'));

        return back()->with('success', 'Schedule saved!');
    }

    public function storeFile(Request $request)
    {
        $sharing = Sharing::query()
            ->where('sharing_date', Carbon::parse($request->sharing_date)->toDateString())
            ->firstOr(function () {
                return back()->with('error', 'Sharing Schedule not Found!');
            });

        if ($sharing->file) {
            Storage::delete($sharing->file);
        }

        $filename = Str::snake($sharing->employee->name . Carbon::parse($request->sharing_date)->toDateString()) . '.' . $request->file('file')->getClientOriginalExtension();

        $request->file('file')->storePubliclyAs('public/sharing_file', $filename);

        $sharing->update(['file' => 'storage/sharing_file/' . $filename]);

        return back()->with('success', 'File saved!');
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

    public function sourceDetail()
    {
        $sharing = Sharing::query()
            ->where('sharing_date', Carbon::parse(request('sharing_date'))->format('Y-m-d'))
            ->first();

        $isOwner = Auth::user()->id === $sharing?->user_id;

        return response()->json(['sharing' => $sharing, 'isOwner' => $isOwner]);
    }
}
