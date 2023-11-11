<?php

namespace App\Http\Controllers;

use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Area;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class crudusercontroller extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = User::with("area")->latest()->get();
        return view('cruduser')->with('data', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $areas = Area::pluck("area", "id");
        return view('tambahuser')->with(["areas" => $areas]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'username' => 'required|unique:users,username|max:255',
        ]);

        $cruduser = new User;
        $cruduser->username = $request->input('username');
        $cruduser->name = $request->input('name');
        $cruduser->area_id = $request->input('area');
        $cruduser->role = $request->input('role');
        $cruduser->password = Hash::make($request->input('password'));
        $cruduser->confirmpassword = $request->input('password');
        $cruduser->save();

        Alert::success('Successfull!');

        return redirect('/cruduser')->with('success', 'success');
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

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = User::find($id);
        $areas = Area::pluck("area", "id");
        return view('edituser')->with(['data' => $data, "areas" => $areas]);
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
        $request->validate([
            'username' => 'required|unique:users,username|max:255',
        ]);

        $cruduser = User::find($id);
        $cruduser->username = $request->input('username');
        $cruduser->name = $request->input('name');
        $cruduser->area_id = $request->input('area');
        $cruduser->role = $request->input('role');
        $cruduser->confirmpassword = Hash::make($request->input('password'));
        $cruduser->save();

        Alert::success('Data Saved!');

        return redirect('/cruduser')->with('success', 'success');
    }

    public function resetPassword($id)
    {
        try {
            $user = User::query()->find($id);
            $user->password = Hash::make("pcn@2022");
            $user->confirmpassword = "pcn@2022";
            $user->save();

            Alert::success("Password reset!");

            return back()->with('success', 'Success reset password!');
        } catch (Exception $e) {
            dd($e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post = User::find($id);
        $post->delete();
        return redirect('/cruduser')->with('deleted', 'Data telah dihapus.');
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/');
    }
}
