<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\oncall;

class oncallcontroller extends Controller
{
    public function index(){
        $oncall = oncall::orderBy('id_oncall', 'desc')->first();
        return view('oncall')->with('oncall', $oncall);


    }

    public function upload(Request $request){
        $fileextension = $request->file('fileupload')->getClientOriginalExtension();
        $filename = time().".". $fileextension;
        // $filename = "splashscreencustomer". $fileextension;
        $request->file('fileupload')->move(public_path('/upload'), $filename);
        
        $oncall = new oncall;
        $oncall->file = asset("upload/$filename"); 
        $oncall->save();
        
        return redirect('/oncall');


    }
}
