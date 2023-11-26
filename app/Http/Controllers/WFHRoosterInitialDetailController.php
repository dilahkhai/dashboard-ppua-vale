<?php

namespace App\Http\Controllers;

use App\Models\WFHInitialDetail;
use Illuminate\Http\Request;

class WFHRoosterInitialDetailController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'initial' => 'required',
            'detail' => 'required'
        ]);

        WFHInitialDetail::query()
            ->create($request->only('initial', 'detail'));

        return back()->with('success', 'Initial saved successfully');
    }

    public function destroy(WFHInitialDetail $initialDetail)
    {
        $initialDetail->delete();

        return back()->with('sucess', 'Initial deleted successfully');
    }
}
