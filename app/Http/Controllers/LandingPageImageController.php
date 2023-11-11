<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LandingPageImage;

class LandingPageImageController extends Controller
{
    public function index(){
        $LandingPageImage = LandingPageImage::orderBy('id', 'desc')->first();
        return view('imagelanding')->with('image', $LandingPageImage);
    }

    public function upload(Request $request){
        $fileextension = $request->file('fileupload')->getClientOriginalExtension();
        $filename = time().".". $fileextension;
        // $filename = "splashscreencustomer". $fileextension;
        $request->file('fileupload')->move(public_path('/upload'), $filename);

        $LandingPageImage = new LandingPageImage;
        $LandingPageImage->file = asset("upload/$filename");
        $LandingPageImage->save();

        return redirect('/image-landing');
    }

    public function landing(){
        $LandingPageImage = LandingPageImage::orderBy('id', 'desc')->first();
        return view('landing')->with('image', $LandingPageImage);
    }
}
