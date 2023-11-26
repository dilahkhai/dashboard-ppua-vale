<?php

namespace App\Http\Controllers;

use App\Models\Area;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Http\Request;
use App\Models\mcu;
use App\Models\Notification;
use App\Models\User;
use Carbon\Carbon;

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
        if (request()->wantsJson()) {
            return response()->json(User::query()->where('area_id', request('id'))->get(['id', 'name']));
        }

        $areas = Area::all();

        return view('tambahmcu')->with(["areas" => $areas]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $superadmin = User::query()
            ->where('role', 'admin')
            ->get();

        $mcu = new mcu;
        $mcu->area_id = $request->input('area_id');
        $mcu->employee_id = $request->input('employee');
        $mcu->lastmcu = $request->input('lastmcu');
        $mcu->duedate = $request->input('duedate');
        $mcu->status = " ";

        $monthBeforeDueDate = Carbon::parse($mcu->duedate)->subMonth();

        if (now()->isAfter($monthBeforeDueDate)) {
            $mcu->is_due = 1;

            Notification::query()
                ->create(['receiver_id' => $mcu->employee_id, 'title' => 'Next MCU', 'content' => 'Your MCU is on Due Date! Please update next MCU!']);

            foreach($superadmin as $admin) {
                Notification::query()
                    ->create(['receiver_id' => $admin->id, 'title' => 'Next MCU', 'content' => 'An User MCU\'s need an update, please update next MCU!']);
            }
        }

        $mcu->save();

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

    public function done(Request $request, $id)
    {
        $mcu = mcu::find($id);
        $mcu->status = "DONE";
        $mcu->is_due = 0;
        $mcu->save();

        Alert::success('Data Updated!');

        return redirect('/mcu')->with('done', 'done');
    }
    public function undone(Request $request, $id)
    {
        $superadmin = User::query()
            ->where('role', 'admin')
            ->get();

        $mcu = mcu::find($id);
        $mcu->status = "";

        $monthBeforeDueDate = Carbon::parse($mcu->duedate)->subMonth();

        if (now()->isAfter($monthBeforeDueDate)) {
            $mcu->is_due = 1;

            Notification::query()
                ->create(['receiver_id' => $mcu->employee_id, 'title' => 'Next MCU', 'content' => 'Your MCU is on Due Date! Please update next MCU!']);

            foreach($superadmin as $admin) {
                Notification::query()
                    ->create(['receiver_id' => $admin->id, 'title' => 'Next MCU', 'content' => 'An User MCU\'s need an update, please update next MCU!']);
            }
        }

        $mcu->save();

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
        $superadmin = User::query()
            ->where('role', 'admin')
            ->get();

        $mcu = mcu::find($id);
        $mcu->lastmcu = $request->input('lastmcu');
        $mcu->duedate = $request->input('duedate');
        $mcu->nextmcu = $request->input('nextmcu');

        $monthBeforeDueDate = Carbon::parse($mcu->duedate)->subMonth();

        if (now()->isAfter($monthBeforeDueDate)) {
            $mcu->is_due = 1;

            Notification::query()
                ->create(['receiver_id' => $mcu->employee_id, 'title' => 'Next MCU', 'content' => 'Your MCU is on Due Date! Please update next MCU!']);

            foreach($superadmin as $admin) {
                Notification::query()
                    ->create(['receiver_id' => $admin->id, 'title' => 'Next MCU', 'content' => 'An User MCU\'s need an update, please update next MCU!']);
            }
        }

        if ($mcu->nextmcu != null || $mcu->nextmcu != '') {
            $mcu->is_due = 0;

            Notification::query()
                ->create(['receiver_id' => $mcu->employee_id, 'title' => 'Next MCU', 'content' => 'You have next MCU updated! Please check!']);
        }

        $mcu->save();

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
