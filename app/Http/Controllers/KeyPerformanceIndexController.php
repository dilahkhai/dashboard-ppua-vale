<?php

namespace App\Http\Controllers;

use App\Models\Area;
use App\Models\KeyPerformanceIndex;
use App\Models\KeyPerformanceIndexDetail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KeyPerformanceIndexController extends Controller
{
    public function index()
    {
        $indexes = KeyPerformanceIndex::query()
            ->get();

        return view('kpi.index', compact('indexes'));
    }

    public function create()
    {
        $areas = Area::all();

        return view('kpi.create', compact('areas'));
    }

    public function input(KeyPerformanceIndex $keyPerformanceIndex)
    {
        $users = User::query()
            ->whereBelongsTo($keyPerformanceIndex->area)
            ->get()
            ->filter(function ($user) use ($keyPerformanceIndex) {
                return in_array($user->position, $keyPerformanceIndex->allowed);
            });

        $details = KeyPerformanceIndexDetail::query()
            ->whereBelongsTo($keyPerformanceIndex, 'key_performance_index')
            ->get()
            ->mapWithKeys(function ($detail) {
                return [$detail->user_id => $detail];
            });

        return view('kpi.input', compact('users', 'keyPerformanceIndex', 'details'));
    }

    public function storeInput(Request $request, KeyPerformanceIndex $keyPerformanceIndex)
    {
        foreach($request->except('_token') as $user => $datas) {
            if (Auth::user()->id == $user || Auth::user()->role == 'admin') {
                if (Auth::user()->is_admin) {
                    $keyPerformanceIndex->details()->updateOrCreate(['user_id' => $user], [
                        'plan' => $datas['plan'],
                        'actual' => $datas['actual'],
                        'remark' => $datas['remark'],
                    ]);
                } else {
                    $keyPerformanceIndex->details()->updateOrCreate(['user_id' => $user], [
                        // 'plan' => $datas['plan'],
                        'actual' => $datas['actual'],
                        'remark' => $datas['remark'],
                    ]);
                }
            }
        }

        return back()->with('success')->with('success', 'Data saved!');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'area_id' => 'required|exists:areas,id',
            'allowed' => 'array|required|min:1'
        ]);

        KeyPerformanceIndex::query()
            ->create($request->except('_token'));

        return redirect()->route('key-performance-index.index')->with('success', 'Data Saved!');
    }

    public function update(Request $request, KeyPerformanceIndex $keyPerformanceIndex)
    {
        $request->validate([
            'title' => 'required',
            'area_id' => 'required|exists:areas,id',
            'allowed' => 'array|required|min:1'
        ]);

        $keyPerformanceIndex
            ->update($request->except('_token'));

        return redirect()->route('key-performance-index.index')->with('success', 'Data Saved!');
    }

    public function edit(KeyPerformanceIndex $keyPerformanceIndex)
    {
        $areas = Area::all();

        return view('kpi.edit', compact('keyPerformanceIndex', 'areas'));
    }

    public function destroy(KeyPerformanceIndex $keyPerformanceIndex)
    {
        $keyPerformanceIndex->delete();

        return back()->with('success', 'Data deleted!');
    }
}
