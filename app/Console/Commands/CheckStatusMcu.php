<?php

namespace App\Console\Commands;

use App\Models\mcu;
use App\Models\Notification;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Console\Command;

class CheckStatusMcu extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mcu:check-status';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check for next mcu';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $mcu = mcu::all();
        $superadmin = User::query()
            ->where('role', 'admin')
            ->get();

        foreach($mcu as $value) {
            $due = $value->duedate;
            $nextmcu = $value->nextmcu;

            $monthBeforeDueDate = Carbon::parse($due)->subMonth();

            if (now()->isAfter($monthBeforeDueDate)) {
                $value->update(['is_due' => true]);

                Notification::query()
                    ->create(['receiver_id' => $value->employee_id, 'title' => 'Due Date User', 'content' => 'Your MCU is on Due Date! Please update next MCU!']);

                foreach($superadmin as $admin) {
                    Notification::query()
                        ->create(['receiver_id' => $admin->id, 'title' => 'Due Date Superadmin', 'content' => 'An User MCU\'s need an update, please update next MCU!']);
                }
            }

            if (now()->isAfter($nextmcu)) {
                $value->update(['status' => 'DONE', 'is_due' => false, 'nextmcu' => null]);
            }
        }

        return Command::SUCCESS;
    }
}
