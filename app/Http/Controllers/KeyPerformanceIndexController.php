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
    public function home()
    {
        $areas = Area::all();

        return view('kpi.home', compact('areas'));
    }

    public function index(Area $area)
    {
        $indexes = KeyPerformanceIndex::query()
            ->whereBelongsTo($area)
            ->with('details')
            ->get();

        $details = KeyPerformanceIndexDetail::query()
            ->whereHas('key_performance_index', function ($query) use ($area) {
                $query->where('area_id', $area->id);
            })
            ->get()
            ->groupBy(function ($detail) {
                return $detail->key_performance_index->id;
            })
            ->map
            ->mapWithKeys(function ($detail) {
                return [$detail->user_id => $detail];
            })
            ->toArray();

        $newArray = [];

        foreach ($indexes->map->allowed->toArray() as $arrays) {
            foreach ($arrays as $array) {
                $newArray[] = $array;
            }
        }

        $users = User::query()
            ->whereBelongsTo($area)
            ->whereIn('position', array_unique($newArray))
            ->get();

        return view('kpi.index', compact('indexes', 'area', 'users', 'details'));
    }

    public function create(Area $area)
    {
        return view('kpi.create', compact('area'));
    }

    public function input(KeyPerformanceIndex $keyPerformanceIndex)
    {
        $users = User::query()
            ->when(Auth::user()->role === 'user', function ($query) {
                $query->where('id', Auth::id());
            }, function ($query) use ($keyPerformanceIndex) {
                $query->whereBelongsTo($keyPerformanceIndex->area);
            })
            ->get()
            ->filter(function ($user) use ($keyPerformanceIndex) {
                return in_array($user->position, $keyPerformanceIndex->allowed);
            });

        $details = KeyPerformanceIndexDetail::query()
            ->whereBelongsTo($keyPerformanceIndex, 'key_performance_index')
            ->when(Auth::user()->role === 'user', function ($query) {
                $query->where('user_id', Auth::id());
            })
            ->get()
            ->mapWithKeys(function ($detail) {
                return [$detail->user_id => $detail];
            });

        return view('kpi.input', compact('users', 'keyPerformanceIndex', 'details'));
    }

    public function storeInput(Request $request, KeyPerformanceIndex $keyPerformanceIndex)
    {
        foreach ($request->except('_token') as $user => $datas) {
            if (Auth::user()->id == $user || Auth::user()->role == 'admin') {
                if (Auth::user()->is_admin) {
                    $keyPerformanceIndex->details()->updateOrCreate(['user_id' => $user, 'index_id' => $keyPerformanceIndex->id], [
                        'plan' => $datas['plan'],
                        'actual' => $datas['actual'],
                        'remark' => $datas['remark'],
                    ]);
                } else {
                    $keyPerformanceIndex->details()->updateOrCreate(['user_id' => $user, 'index_id' => $keyPerformanceIndex->id], [
                        // 'plan' => $datas['plan'],
                        'actual' => $datas['actual'],
                        'remark' => $datas['remark'],
                    ]);
                }
            }
        }

        return redirect()->route('key-performance-index.index', $keyPerformanceIndex->area_id)->with('success', 'Data saved!');
    }

    public function store(Request $request, Area $area)
    {
        $request->validate([
            'title' => 'required',
            'allowed' => 'array|required|min:1'
        ]);

        KeyPerformanceIndex::query()
            ->create($request->except('_token') + ['area_id' => $area->id]);

        return redirect()->route('key-performance-index.index', $area->id)->with('success', 'Data Saved!');
    }

    public function update(Request $request, KeyPerformanceIndex $keyPerformanceIndex)
    {
        $request->validate([
            'title' => 'required',
            'allowed' => 'array|required|min:1'
        ]);

        $keyPerformanceIndex
            ->update($request->except('_token'));

        return redirect()->route('key-performance-index.index', $keyPerformanceIndex->area->id)->with('success', 'Data Saved!');
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
