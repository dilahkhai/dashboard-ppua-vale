<?php

namespace App\Http\Controllers;

use App\Models\Area;
use App\Models\employee;
use App\Models\Notification;
use App\Models\TrainingStatus;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class TrainingStatusController extends Controller
{
    public function index()
    {
        $trainings = TrainingStatus::query()->with('employee.area')->get();

        return view('training-status.index', compact('trainings'));
    }

    public function create()
    {
        $areas = Area::query()
            ->get(['area', 'id']);

        return view('training-status.create', compact('areas'));
    }

    public function edit(TrainingStatus $trainingStatus)
    {
        $employees = User::query()
            ->where('role', 'user')
            ->get();

        $areas = Area::query()
            ->get();

        return view('training-status.edit', compact('trainingStatus', 'employees', 'areas'));
    }

    public function store(Request $request)
    {
        $training = TrainingStatus::query()
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

        return redirect()->route('training-status.index')->with('success', 'Success create training status!');
    }

    public function update(Request $request, TrainingStatus $trainingStatus)
    {
        $trainingStatus->update($request->except('_token', 'area_id') + ['status' => 1]);

        if (!is_null($trainingStatus->training_schedule)) {
            Notification::query()
                    ->create(['receiver_id' => $trainingStatus->user_id, 'title' => 'Training Schedule Updated', 'content' => 'You have new Training Schedule!']);
        }

        $superadmin = User::query()
            ->where('role', 'admin')
            ->get();

        $due = $trainingStatus->certif_date;

        $certifAge = Carbon::parse($due)->addDays(299);
        $certifExpired = Carbon::parse($due)->addYear();

        if (now()->isAfter($certifAge)) {
            $trainingStatus->update(['status' => 2]);

            Notification::query()
                ->create(['receiver_id' => $trainingStatus->user_id, 'title' => 'Certif Date Warning', 'content' => 'Your certification is close to expiration!']);

            foreach ($superadmin as $admin) {
                Notification::query()
                    ->create(['receiver_id' => $admin->id, 'title' => 'Certif Date Warning', 'content' => 'An User Certification\'s need an update, please update training schedule!']);
            }
        }

        if (now()->isAfter($certifExpired)) {
            $trainingStatus->update(['status' => 3]);

            Notification::query()
                ->create(['receiver_id' => $trainingStatus->user_id, 'title' => 'Certif Date Expired', 'content' => 'Your certification is expired!']);

            foreach ($superadmin as $admin) {
                Notification::query()
                    ->create(['receiver_id' => $admin->id, 'title' => 'Certif Date Expired', 'content' => 'An User Certification\'s need an update, please update training schedule!']);
            }
        }

        return redirect()->route('training-status.index')->with('success', 'Success updating training status!');
    }

    public function destroy(TrainingStatus $trainingStatus)
    {
        $trainingStatus->delete();

        return back()->with('success', 'Success deleting training status!');
    }
}
