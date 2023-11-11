<?php

namespace App\Http\Controllers;

use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Http\Request;
use App\Models\mcu;
use App\Models\User;

class mcucontroller extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    
    public function index()
    {
        $data = mcu::with("employee")->get();
        return view('mcu')->with('data', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $employees = User::pluck("name", "id");
        return view('tambahmcu')->with(["employees"=> $employees]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $mcu = new mcu;
        $mcu ->employee_id = $request->input('employee'); 
        $mcu ->lastmcu = $request->input('lastmcu');
        $mcu ->duedate = $request->input('duedate');
        $mcu ->status = " ";
        $mcu ->save();

        return redirect('/mcu')->with('success', 'success');
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    public function status(Request $request, $id)
    {
        $mcu = mcu::find($id);
        $mcu ->status = "DONE";
        
        $mcu ->save();

        Alert::success('Data Updated!');

        return redirect('/mcu')->with('done', 'done');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = mcu::with("employee")->where("id_mcu", $id)->first();
        return view('editmcu')->with('data', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        
        $mcu = mcu::find($id);
        $mcu ->lastmcu = $request->input('lastmcu');
        $mcu ->duedate = $request->input('duedate');
        $mcu ->save();

        return redirect('/mcu')->with('success', 'success');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post = mcu::find($id); 
        $post->delete();
        return redirect('/mcu')->with('deleted', 'Data telah dihapus.'); 
    }
}
