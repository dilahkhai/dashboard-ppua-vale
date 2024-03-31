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
    public function index()
    {
        $training = TrainingStatus::query()->findOrFail(request('training_status'));

        $trainings = SubTraining::query()->whereBelongsTo($training, 'training')->with('employee.area')->get();

        return view('sub-training.index', compact('trainings', 'training'));
    }

    public function create()
    {
        $training = TrainingStatus::query()->find(request('training_status'));

        if (!$training) {
            return redirect()->route('training-status.index')->with('fail', 'Please select training first!');
        }

        $areas = Area::query()
            ->get(['area', 'id']);

        return view('sub-training.create', compact('areas'));
    }

    public function edit(SubTraining $subTraining)
    {
        $training = TrainingStatus::query()->find(request('training_status'));

        if (!$training) {
            return redirect()->route('training-status.index')->with('fail', 'Please select training first!');
        }

        $employees = User::query()
            ->where('role', 'user')
            ->get();

        $areas = Area::query()
            ->get();

        return view('sub-training.edit', compact('subTraining', 'employees', 'areas'));
    }

    public function store(Request $request)
    {
        $training = SubTraining::query()
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

        return redirect()->route('sub-training.index', ['training_status' => $request->training_status])->with('success', 'Success create training status!');
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

        return redirect()->route('sub-training.index', ['training_status' => $subTraining->training_status_id])->with('success', 'Success updating training status!');
    }

    public function destroy(SubTraining $subTraining)
    {
        $subTraining->delete();

        return back()->with('success', 'Success deleting training status!');
    }
}
