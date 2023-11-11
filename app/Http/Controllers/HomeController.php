<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\cruduser;
use App\Models\User;
use App\Models\Area;
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $user = User::count();

        $area = Area::with(["employees"])->get();
        $listArea = [];
        $listAreaValue = [];
        foreach ($area as $key => $value) {
            array_push($listArea, $value->area);
            array_push($listAreaValue, count($value->employees));
        }


        return view('home')->with([
            "user"  => $user,
            "list_area" => $listArea,
            "area_value"=> $listAreaValue
        ]);
    }

    public function importExcel(){
        return view('import');
    }
}
