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
        $trainings = Simper::query()->with('employee.area')->get();

        return view('simper.index', compact('trainings'));
    }

    public function create()
    {
        $areas = Area::query()
            ->get(['area', 'id']);

        return view('simper.create', compact('areas'));
    }

    public function edit(Simper $simper)
    {
        $employees = User::query()
            ->where('role', 'user')
            ->get();

        $areas = Area::query()
            ->get();

        return view('simper.edit', compact('simper', 'employees', 'areas'));
    }

    public function store(Request $request)
    {
        $training = Simper::query()
            ->create($request->except('_token', 'area_id') + ['status' => 1]);

        $superadmin = User::query()
            ->where('role', 'admin')
            ->get();

        $due = $training->certif_date;

        $certifAge = Carbon::parse($due)->addDays(299);
        $certifExpired = Carbon::parse($due)->addYear();

        if (now()->isAfter($certifAge)) {
            $training->update(['status' => 2]);

            Notification::query()
                ->create(['receiver_id' => $training->user_id, 'title' => 'Certif Date Warning', 'content' => 'Your certification is close to expiration!']);

            foreach ($superadmin as $admin) {
                Notification::query()
                    ->create(['receiver_id' => $admin->id, 'title' => 'Certif Date Warning', 'content' => 'An User Certification\'s need an update, please update training schedule!']);
            }
        }

        if (now()->isAfter($certifExpired)) {
            $training->update(['status' => 3]);

            Notification::query()
                ->create(['receiver_id' => $training->user_id, 'title' => 'Certif Date Expired', 'content' => 'Your certification is expired!']);

            foreach ($superadmin as $admin) {
                Notification::query()
                    ->create(['receiver_id' => $admin->id, 'title' => 'Certif Date Expired', 'content' => 'An User Certification\'s need an update, please update training schedule!']);
            }
        }

        return redirect()->route('simper.index')->with('success', 'Success create training status!');
    }

    public function update(Request $request, Simper $simper)
    {
        $simper->update($request->except('_token', 'area_id') + ['status' => 1]);

        if (!is_null($simper->training_schedule)) {
            Notification::query()
                    ->create(['receiver_id' => $simper->user_id, 'title' => 'Training Schedule Updated', 'content' => 'You have new Training Schedule!']);
        }

        $superadmin = User::query()
            ->where('role', 'admin')
            ->get();

        $due = $simper->certif_date;

        $certifAge = Carbon::parse($due)->addDays(299);
        $certifExpired = Carbon::parse($due)->addYear();

        if (now()->isAfter($certifAge)) {
            $simper->update(['status' => 2]);

            Notification::query()
                ->create(['receiver_id' => $simper->user_id, 'title' => 'Certif Date Warning', 'content' => 'Your certification is close to expiration!']);

            foreach ($superadmin as $admin) {
                Notification::query()
                    ->create(['receiver_id' => $admin->id, 'title' => 'Certif Date Warning', 'content' => 'An User Certification\'s need an update, please update training schedule!']);
            }
        }

        if (now()->isAfter($certifExpired)) {
            $simper->update(['status' => 3]);

            Notification::query()
                ->create(['receiver_id' => $simper->user_id, 'title' => 'Certif Date Expired', 'content' => 'Your certification is expired!']);

            foreach ($superadmin as $admin) {
                Notification::query()
                    ->create(['receiver_id' => $admin->id, 'title' => 'Certif Date Expired', 'content' => 'An User Certification\'s need an update, please update training schedule!']);
            }
        }

        return redirect()->route('simper.index')->with('success', 'Success updating training status!');
    }

    public function destroy(Simper $simper)
    {
        $simper->delete();

        return back()->with('success', 'Success deleting training status!');
    }
}
