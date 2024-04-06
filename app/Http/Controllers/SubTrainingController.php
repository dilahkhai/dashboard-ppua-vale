<?php

namespace App\Http\Controllers;

use App\Models\Area;
use App\Models\Notification;
use App\Models\SubTraining;
use App\Models\TrainingStatus;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class SubTrainingController extends Controller
{
    public function index(TrainingStatus $trainingStatus)
    {
        $trainings = SubTraining::query()->whereBelongsTo($trainingStatus, 'training')->with('employee.area')->get();

        return view('sub-training.index', compact('trainings', 'trainingStatus'));
    }

    public function create(TrainingStatus $trainingStatus)
    {
        $areas = Area::query()
            ->get(['area', 'id']);

        return view('sub-training.create', compact('areas', 'trainingStatus'));
    }

    public function edit(TrainingStatus $trainingStatus, SubTraining $subTraining)
    {
        $employees = User::query()
            ->where('role', 'user')
            ->get();

        $areas = Area::query()
            ->get();

        return view('sub-training.edit', compact('subTraining', 'employees', 'areas', 'trainingStatus'));
    }

    public function store(Request $request, TrainingStatus $trainingStatus)
    {
        $training = $trainingStatus->subTrainings()
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

        return redirect()->route('sub-training.index', ['trainingStatus' => $trainingStatus->id])->with('success', 'Success create training status!');
    }

    public function update(Request $request, SubTraining $subTraining)
    {
        $subTraining->update($request->except('_token', 'area_id') + ['status' => 1]);

        if (!is_null($subTraining->training_schedule)) {
            Notification::query()
                    ->create(['receiver_id' => $subTraining->user_id, 'title' => 'Training Schedule Updated', 'content' => 'You have new Training Schedule!']);
        }

        $superadmin = User::query()
            ->where('role', 'admin')
            ->get();

        $due = $subTraining->certif_date;

        $certifAge = Carbon::parse($due)->addDays(299);
        $certifExpired = Carbon::parse($due)->addYear();

        if (now()->isAfter($certifAge)) {
            $subTraining->update(['status' => 2]);

            Notification::query()
                ->create(['receiver_id' => $subTraining->user_id, 'title' => 'Certif Date Warning', 'content' => 'Your certification is close to expiration!']);

            foreach ($superadmin as $admin) {
                Notification::query()
                    ->create(['receiver_id' => $admin->id, 'title' => 'Certif Date Warning', 'content' => 'An User Certification\'s need an update, please update training schedule!']);
            }
        }

        if (now()->isAfter($certifExpired)) {
            $subTraining->update(['status' => 3]);

            Notification::query()
                ->create(['receiver_id' => $subTraining->user_id, 'title' => 'Certif Date Expired', 'content' => 'Your certification is expired!']);

            foreach ($superadmin as $admin) {
                Notification::query()
                    ->create(['receiver_id' => $admin->id, 'title' => 'Certif Date Expired', 'content' => 'An User Certification\'s need an update, please update training schedule!']);
            }
        }

        return redirect()->route('sub-training.index', ['trainingStatus' => $subTraining->training->id])->with('success', 'Success updating training status!');
    }

    public function destroy(SubTraining $subTraining)
    {
        $subTraining->delete();

        return back()->with('success', 'Success deleting training status!');
    }
}
