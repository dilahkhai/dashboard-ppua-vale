<?php

namespace App\Http\Controllers;

use App\Models\InitialDetail;
use Illuminate\Http\Request;

class InitialDetailController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'initial' => 'required',
            'detail' => 'required'
        ]);

        InitialDetail::query()
            ->create($request->only('initial', 'detail'));

        return back()->with('success', 'Initial saved successfully');
    }

    public function destroy(InitialDetail $initialDetail)
    {
        $initialDetail->delete();

        return back()->with('sucess', 'Initial deleted successfully');
    }
}
