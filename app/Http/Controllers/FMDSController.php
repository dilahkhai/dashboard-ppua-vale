<?php

namespace App\Http\Controllers;

use App\Models\FMDS;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class FMDSController extends Controller
{
    public function index()
    {
        $latestDocument = FMDS::query()
            ->whereDate('date', today())
            ->latest()
            ->first();

        return view('fmds.index', compact('latestDocument'));
    }

    public function upload(Request $request)
    {
        $filename = Str::random() . '.' . $request->file('file')->getClientOriginalExtension();

        $request->file('file')->storePubliclyAs('public/fmds', $filename);

        FMDS::query()
            ->create(['file' => 'storage/fmds/' . $filename, 'date' => $request->upload_date]);

        return back()->with('success', 'FMDS Document uploaded successfully.');
    }

    public function download(Request $request)
    {
        $document = FMDS::query()
            ->where('date', $request->date)
            ->latest()
            ->first();

        if (!$document) {
            return back()->with('fail', 'Document not found for the selected date!');
        }

        return Response::download($document->file);
    }
}
