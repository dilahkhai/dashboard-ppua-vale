<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\WfhRooster;

class WfhRoosterController extends Controller
{
    public function index(){
        $WfhRooster = WfhRooster::orderBy('id', 'desc')->first();
        return view('wfhrooster')->with('wfh', $WfhRooster);


    }

    public function upload(Request $request){
        $fileextension = $request->file('fileupload')->getClientOriginalExtension();
        $filename = time().".". $fileextension;
        // $filename = "splashscreencustomer". $fileextension;
        $request->file('fileupload')->move(public_path('/upload'), $filename);

        $WfhRooster = new WfhRooster;
        $WfhRooster->file = asset("upload/$filename");
        $WfhRooster->save();

        return redirect('/wfhrooster');
    }
}
