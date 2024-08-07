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
        // Mengambil semua data Simper dengan relasi employee dan area
        $trainings = Simper::query()->with('employee.area')->get();

        // Mengembalikan view dengan data $trainings
        return view('simper.index', compact('trainings'));
    }

    public function create()
    {
        // Mengambil data Area untuk form pembuatan
        $areas = Area::query()->get(['area', 'id']);

        // Mengembalikan view untuk pembuatan Simper dengan data $areas
        return view('simper.create', compact('areas'));
    }

    public function edit(Simper $simper)
    {
        // Mengambil data Employee dan Area untuk form edit
        $employees = User::query()->where('role', 'user')->get();
        $areas = Area::query()->get();

        // Mengembalikan view untuk edit Simper dengan data $simper, $employees, dan $areas
        return view('simper.edit', compact('simper', 'employees', 'areas'));
    }

    public function store(Request $request)
    {
        // Membuat entitas Simper baru dengan data dari request
        $training = Simper::query()->create($request->except('_token', 'area_id') + ['status' => 1]);

        // Mengambil data user dengan role 'admin'
        $superadmin = User::query()->where('role', 'admin')->get();

        // Menghitung tanggal certif expired
        $due = $training->certif_date;
        $certifAge = Carbon::parse($due)->addDays(299);
        $certifExpired = Carbon::parse($due)->addYear();

        // Cek jika tanggal sekarang sudah lewat dari certifAge
        if (now()->isAfter($certifAge)) {
            $training->update(['status' => 2]);

            Notification::query()->create([
                'receiver_id' => $training->user_id,
                'title' => 'Certif Date Warning',
                'content' => 'Your certification is close to expiration!'
            ]);

            // Kirim notifikasi ke semua admin
            $user = User::find($training->user_id);
            foreach ($superadmin as $admin) {
                Notification::query()->create([
                    'receiver_id' => $admin->id,
                    'title' => 'Certif Date Warning',
                    'content' => 'User ' . $user->name . '\'s certification is close to expiration, please update their simper update schedule!'
                ]);
            }
        }

        // Cek jika tanggal sekarang sudah lewat dari certifExpired
        if (now()->isAfter($certifExpired)) {
            $training->update(['status' => 3]);

            Notification::query()->create([
                'receiver_id' => $training->user_id,
                'title' => 'Certif Date Expired',
                'content' => 'Your certification is expired!'
            ]);

            // Kirim notifikasi ke semua admin
            $user = User::find($training->user_id);
            foreach ($superadmin as $admin) {
                Notification::query()->create([
                    'receiver_id' => $admin->id,
                    'title' => 'Certif Date Expired',
                    'content' => 'User ' . $user->name . '\'s certification is expired, please update their simper update schedule!'
                ]);
            }
        }

        // Redirect ke halaman index dengan pesan sukses
        return redirect()->route('simper.index')->with('success', 'Success create training status!');
    }

    public function update(Request $request, Simper $simper)
    {
        // Update data Simper dengan data dari request
        $simper->update($request->except('_token', 'area_id') + ['status' => 1]);

        // Cek jika ada jadwal pelatihan yang baru
        if (!is_null($simper->training_schedule)) {
            Notification::query()->create([
                'receiver_id' => $simper->user_id,
                'title' => 'Training Schedule Updated',
                'content' => 'You have new Training Schedule!'
            ]);
        }

        // Mengambil data user dengan role 'admin'
        $superadmin = User::query()->where('role', 'admin')->get();

        // Menghitung tanggal certif expired
        $due = $simper->certif_date;
        $certifAge = Carbon::parse($due)->addDays(299);
        $certifExpired = Carbon::parse($due)->addYear();

        // Cek jika tanggal sekarang sudah lewat dari certifAge
        if (now()->isAfter($certifAge)) {
            $simper->update(['status' => 2]);

            Notification::query()->create([
                'receiver_id' => $simper->user_id,
                'title' => 'Certif Date Warning',
                'content' => 'Your certification is close to expiration!'
            ]);

            // Kirim notifikasi ke semua admin
            $user = User::find($simper->user_id);
            foreach ($superadmin as $admin) {
                Notification::query()->create([
                    'receiver_id' => $admin->id,
                    'title' => 'Certif Date Warning',
                    'content' => 'User ' . $user->name . '\'s certification is close to expiration, please update their simper update schedule!'
                ]);
            }
        }

        // Cek jika tanggal sekarang sudah lewat dari certifExpired
        if (now()->isAfter($certifExpired)) {
            $simper->update(['status' => 3]);

            Notification::query()->create([
                'receiver_id' => $simper->user_id,
                'title' => 'Certif Date Expired',
                'content' => 'Your certification is expired!'
            ]);

            // Kirim notifikasi ke semua admin
            $user = User::find($simper->user_id);
            foreach ($superadmin as $admin) {
                Notification::query()->create([
                    'receiver_id' => $admin->id,
                    'title' => 'Certif Date Expired',
                    'content' => 'User ' . $user->name . '\'s certification is expired, please update their simper update schedule!'
                ]);
            }
        }

        // Redirect ke halaman index dengan pesan sukses
        return redirect()->route('simper.index')->with('success', 'Success updating training status!');
    }

    public function destroy(Simper $simper)
    {
        // Hapus entitas Simper
        $simper->delete();

        // Redirect ke halaman sebelumnya dengan pesan sukses
        return back()->with('success', 'Success deleting training status!');
    }
}
