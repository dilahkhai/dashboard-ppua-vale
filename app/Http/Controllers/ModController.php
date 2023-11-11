<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Mod;

class ModController extends Controller
{
    public function index(){
        $Mod = Mod::orderBy('id', 'desc')->first();
        return view('mod')->with('mod', $Mod);
    }

    public function upload(Request $request){
        $fileextension = $request->file('fileupload')->getClientOriginalExtension();
        $filename = time().".". $fileextension;
        // $filename = "splashscreencustomer". $fileextension;
        $request->file('fileupload')->move(public_path('/upload'), $filename);

        $Mod = new Mod;
        $Mod->file = asset("upload/$filename");
        $Mod->save();

        return redirect('/mod');
    }
}
