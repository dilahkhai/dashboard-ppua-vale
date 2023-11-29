<?php

namespace App\Http\Controllers;

use App\Models\Area;
use Illuminate\Http\Request;

class ManPowerController extends Controller
{
    public function index()
    {
        $areas = Area::all();

        return view('manpower.index', compact('areas'));
    }
}
