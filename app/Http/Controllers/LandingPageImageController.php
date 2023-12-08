<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LandingPageImage;

class LandingPageImageController extends Controller
{
    public function index(){
        $furconv = LandingPageImage::where('type', 'furconv')->orderBy('id', 'desc')->first();
        $dryer = LandingPageImage::where('type', 'dryer')->orderBy('id', 'desc')->first();
        $infra = LandingPageImage::where('type', 'infra')->orderBy('id', 'desc')->first();
        $util = LandingPageImage::where('type', 'util')->orderBy('id', 'desc')->first();

        return view('imagelanding', compact('furconv', 'dryer', 'infra', 'util'));
    }

    public function upload(Request $request){
        $fileextension = $request->file('fileupload')->getClientOriginalExtension();
        $filename = time().".". $fileextension;
        // $filename = "splashscreencustomer". $fileextension;
        $request->file('fileupload')->move(public_path('/upload'), $filename);

        $LandingPageImage = new LandingPageImage;
        $LandingPageImage->file = asset("upload/$filename");
        $LandingPageImage->type = $request->type;
        $LandingPageImage->save();

        return redirect('/image-landing');
    }

    public function landing(){
        $furconv = LandingPageImage::where('type', 'furconv')->orderBy('id', 'desc')->first();
        $dryer = LandingPageImage::where('type', 'dryer')->orderBy('id', 'desc')->first();
        $infra = LandingPageImage::where('type', 'infra')->orderBy('id', 'desc')->first();
        $util = LandingPageImage::where('type', 'util')->orderBy('id', 'desc')->first();

        return view('landing', compact('furconv', 'dryer', 'infra', 'util'));
    }
}
