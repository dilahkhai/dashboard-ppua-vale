<?php

namespace App\Console\Commands;

use App\Models\Notification;
use App\Models\TrainingStatus;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Console\Command;

class CheckTrainingStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'training-status:check';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check Training Status';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $trainings = TrainingStatus::query()
            ->get();
        $superadmin = User::query()
            ->where('role', 'admin')
            ->get();

        foreach ($trainings as $value) {
            $due = $value->certif_date;

            $certifAge = Carbon::parse($due)->addDays(299);
            $certifExpired = Carbon::parse($due)->addYear();

            if (now()->isAfter($certifAge)) {
                $value->update(['status' => 2]);

                Notification::query()
                    ->create(['receiver_id' => $value->employee_id, 'title' => 'Certif Date Warning', 'content' => 'Your certification is close to expiration!']);

                foreach ($superadmin as $admin) {
                    Notification::query()
                        ->create(['receiver_id' => $admin->id, 'title' => 'Certif Date Warning', 'content' => 'An User Certification\'s need an update, please update training schedule!']);
                }
            } else if (now()->isAfter($certifExpired)) {
                $value->update(['status' => 2]);

                Notification::query()
                    ->create(['receiver_id' => $value->employee_id, 'title' => 'Certif Date Warning', 'content' => 'Your certification is expired!']);

                foreach ($superadmin as $admin) {
                    Notification::query()
                        ->create(['receiver_id' => $admin->id, 'title' => 'Certif Date Warning', 'content' => 'An User Certification\'s need an update, please update training schedule!']);
                }
            }
        }

        return Command::SUCCESS;
    }
}
