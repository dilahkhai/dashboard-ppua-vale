<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\knowledge;

class knowledgecontroller extends Controller
{
    public function index(){
        $knowledge = knowledge::orderBy('id_knowledge', 'desc')->first();
        return view('knowledge')->with('knowledge', $knowledge);


    }

    public function upload(Request $request){
        $fileextension = $request->file('fileupload')->getClientOriginalExtension();
        $filename = time().".". $fileextension;
        // $filename = "splashscreencustomer". $fileextension;
        $request->file('fileupload')->move(public_path('/upload'), $filename);
        
        $knowledge = new knowledge;
        $knowledge->file = asset("upload/$filename"); 
        $knowledge->save();
        
        return redirect('/knowledge');


    }
}
