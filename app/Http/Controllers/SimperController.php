<?php

namespace App\Http\Controllers;

use App\Models\Area;
use App\Models\Notification;
use App\Models\Simper;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class SimperController extends Controller
{
    public function index()
    {
        $simpers = Simper::query()->with('employee.area')->get();

        return view('simper.index', compact('simpers'));
    }

    public function create()
    {
        $areas = Area::query()->get(['area', 'id']);

        return view('simper.create', compact('areas'));
    }

    public function edit(Simper $simper)
    {
        $employees = User::query()->where('role', 'user')->get();
        $areas = Area::query()->get();

        return view('simper.edit', compact('simper', 'employees', 'areas'));
    }

    public function store(Request $request)
    {
        $simper = Simper::query()->create($request->except('_token', 'area_id') + [
            'status' => 1,
            'sim_update' => Carbon::parse($request->certif_date)->addMonths(24),
        ]);

        $superadmin = User::query()->where('role', 'admin')->get();

        $due = $simper->certif_date;
        $certifAge = Carbon::parse($due)->addDays(699);
        $certifExpired = Carbon::parse($due)->addYear();

        if (now()->isAfter($certifAge)) {
            $simper->update(['status' => 2]);

            Notification::query()->create([
                'receiver_id' => $simper->user_id,
                'title' => 'Certif Date Warning',
                'content' => 'Your certification is close to expiration!'
            ]);

            $user = User::find($simper->user_id);
            foreach ($superadmin as $admin) {
                Notification::query()->create([
                    'receiver_id' => $admin->id,
                    'title' => 'Certif Date Warning',
                    'content' => 'User ' . $user->name . '\'s certification is close to expiration, please update their simper update schedule!'
                ]);
            }
        }

        if (now()->isAfter($certifExpired)) {
            $simper->update(['status' => 3]);

            Notification::query()->create([
                'receiver_id' => $simper->user_id,
                'title' => 'Certif Date Expired',
                'content' => 'Your certification is expired!'
            ]);

            $user = User::find($simper->user_id);
            foreach ($superadmin as $admin) {
                Notification::query()->create([
                    'receiver_id' => $admin->id,
                    'title' => 'Certif Date Expired',
                    'content' => 'User ' . $user->name . '\'s certification is expired, please update their simper update schedule!'
                ]);
            }
        }

        return redirect()->route('simper.index')->with('success', 'Success create simper status!');
    }

    public function update(Request $request, Simper $simper)
    {
        $simper->update($request->except('_token', 'area_id') + [
            'status' => 1,
            'sim_update' => Carbon::parse($request->certif_date)->addMonths(23),
        ]);

        if (!is_null($simper->training_schedule)) {
            Notification::query()->create([
                'receiver_id' => $simper->user_id,
                'title' => 'Training Schedule Updated',
                'content' => 'You have new Training Schedule!'
            ]);
        }

        $superadmin = User::query()->where('role', 'admin')->get();

        $due = $simper->certif_date;
        $certifAge = Carbon::parse($due)->addDays(699);
        $certifExpired = Carbon::parse($due)->addYear();

        if (now()->isAfter($certifAge)) {
            $simper->update(['status' => 2]);

            Notification::query()->create([
                'receiver_id' => $simper->user_id,
                'title' => 'Certif Date Warning',
                'content' => 'Your certification is close to expiration!'
            ]);

            $user = User::find($simper->user_id);
            foreach ($superadmin as $admin) {
                Notification::query()->create([
                    'receiver_id' => $admin->id,
                    'title' => 'Certif Date Warning',
                    'content' => 'User ' . $user->name . '\'s certification is close to expiration, please update their simper update schedule!'
                ]);
            }
        }

        if (now()->isAfter($certifExpired)) {
            $simper->update(['status' => 3]);

            Notification::query()->create([
                'receiver_id' => $simper->user_id,
                'title' => 'Certif Date Expired',
                'content' => 'Your certification is expired!'
            ]);

            $user = User::find($simper->user_id);
            foreach ($superadmin as $admin) {
                Notification::query()->create([
                    'receiver_id' => $admin->id,
                    'title' => 'Certif Date Expired',
                    'content' => 'User ' . $user->name . '\'s certification is expired, please update their simper update schedule!'
                ]);
            }
        }

        return redirect()->route('simper.index')->with('success', 'Success updating simper status!');
    }

    public function destroy(Simper $simper)
    {
        $simper->delete();

        return back()->with('success', 'Success deleting simper status!');
    }
}
