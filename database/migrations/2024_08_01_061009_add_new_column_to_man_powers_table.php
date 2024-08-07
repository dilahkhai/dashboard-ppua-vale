<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNewColumnToManPowersTable extends Migration
{
    public function up()
    {
        Schema::table('man_powers', function (Blueprint $table) {
            // Tambahkan kolom baru jika belum ada
            if (!Schema::hasColumn('man_powers', 'area_id')) {
                $table->bigInteger('area_id')->unsigned()->nullable();
            }
            if (!Schema::hasColumn('man_powers', 'user_id')) {
                $table->bigInteger('user_id')->unsigned()->nullable();
            }
            if (!Schema::hasColumn('man_powers', 'date')) {
                $table->date('date')->nullable();
            }
            if (!Schema::hasColumn('man_powers', 'crew_total')) {
                $table->integer('crew_total')->unsigned()->nullable();
            }
            if (!Schema::hasColumn('man_powers', 'crew_total_man')) {
                $table->integer('crew_total_man')->unsigned()->nullable();
            }
            if (!Schema::hasColumn('man_powers', 'crew_leave')) {
                $table->integer('crew_leave')->unsigned()->nullable();
            }
            if (!Schema::hasColumn('man_powers', 'crew_leave_man')) {
                $table->integer('crew_leave_man')->unsigned()->nullable();
            }
            if (!Schema::hasColumn('man_powers', 'crew_sick_leave')) {
                $table->integer('crew_sick_leave')->unsigned()->nullable();
            }
            if (!Schema::hasColumn('man_powers', 'crew_sick_leave_man')) {
                $table->integer('crew_sick_leave_man')->unsigned()->nullable();
            }
            if (!Schema::hasColumn('man_powers', 'crew_mcu')) {
                $table->integer('crew_mcu')->unsigned()->nullable();
            }
            if (!Schema::hasColumn('man_powers', 'crew_mcu_man')) {
                $table->integer('crew_mcu_man')->unsigned()->nullable();
            }
            if (!Schema::hasColumn('man_powers', 'crew_total_power')) {
                $table->integer('crew_total_power')->unsigned()->nullable();
            }
            if (!Schema::hasColumn('man_powers', 'crew_total_power_man')) {
                $table->integer('crew_total_power_man')->unsigned()->nullable();
            }
            if (!Schema::hasColumn('man_powers', 'contractor_total')) {
                $table->integer('contractor_total')->unsigned()->nullable();
            }
            if (!Schema::hasColumn('man_powers', 'contractor_total_man')) {
                $table->integer('contractor_total_man')->unsigned()->nullable();
            }
            if (!Schema::hasColumn('man_powers', 'contractor_leave')) {
                $table->integer('contractor_leave')->unsigned()->nullable();
            }
            if (!Schema::hasColumn('man_powers', 'contractor_leave_man')) {
                $table->integer('contractor_leave_man')->unsigned()->nullable();
            }
            if (!Schema::hasColumn('man_powers', 'contractor_sick_leave')) {
                $table->integer('contractor_sick_leave')->unsigned()->nullable();
            }
            if (!Schema::hasColumn('man_powers', 'contractor_sick_leave_man')) {
                $table->integer('contractor_sick_leave_man')->unsigned()->nullable();
            }
            if (!Schema::hasColumn('man_powers', 'contractor_mcu')) {
                $table->integer('contractor_mcu')->unsigned()->nullable();
            }
            if (!Schema::hasColumn('man_powers', 'contractor_mcu_man')) {
                $table->integer('contractor_mcu_man')->unsigned()->nullable();
            }
            if (!Schema::hasColumn('man_powers', 'contractor_total_power')) {
                $table->integer('contractor_total_power')->unsigned()->nullable();
            }
            if (!Schema::hasColumn('man_powers', 'contractor_total_power_man')) {
                $table->integer('contractor_total_power_man')->unsigned()->nullable();
            }
            if (!Schema::hasColumn('man_powers', 'created_at')) {
                $table->timestamps();
            }
        });
    }

    public function down()
    {
        Schema::table('man_powers', function (Blueprint $table) {
            // Drop kolom jika ada
            if (Schema::hasColumn('man_powers', 'area_id')) {
                $table->dropColumn('area_id');
            }
            if (Schema::hasColumn('man_powers', 'user_id')) {
                $table->dropColumn('user_id');
            }
            if (Schema::hasColumn('man_powers', 'date')) {
                $table->dropColumn('date');
            }
            if (Schema::hasColumn('man_powers', 'crew_total')) {
                $table->dropColumn('crew_total');
            }
            if (Schema::hasColumn('man_powers', 'crew_total_man')) {
                $table->dropColumn('crew_total_man');
            }
            if (Schema::hasColumn('man_powers', 'crew_leave')) {
                $table->dropColumn('crew_leave');
            }
            if (Schema::hasColumn('man_powers', 'crew_leave_man')) {
                $table->dropColumn('crew_leave_man');
            }
            if (Schema::hasColumn('man_powers', 'crew_sick_leave')) {
                $table->dropColumn('crew_sick_leave');
            }
            if (Schema::hasColumn('man_powers', 'crew_sick_leave_man')) {
                $table->dropColumn('crew_sick_leave_man');
            }
            if (Schema::hasColumn('man_powers', 'crew_mcu')) {
                $table->dropColumn('crew_mcu');
            }
            if (Schema::hasColumn('man_powers', 'crew_mcu_man')) {
                $table->dropColumn('crew_mcu_man');
            }
            if (Schema::hasColumn('man_powers', 'crew_total_power')) {
                $table->dropColumn('crew_total_power');
            }
            if (Schema::hasColumn('man_powers', 'crew_total_power_man')) {
                $table->dropColumn('crew_total_power_man');
            }
            if (Schema::hasColumn('man_powers', 'contractor_total')) {
                $table->dropColumn('contractor_total');
            }
            if (Schema::hasColumn('man_powers', 'contractor_total_man')) {
                $table->dropColumn('contractor_total_man');
            }
            if (Schema::hasColumn('man_powers', 'contractor_leave')) {
                $table->dropColumn('contractor_leave');
            }
            if (Schema::hasColumn('man_powers', 'contractor_leave_man')) {
                $table->dropColumn('contractor_leave_man');
            }
            if (Schema::hasColumn('man_powers', 'contractor_sick_leave')) {
                $table->dropColumn('contractor_sick_leave');
            }
            if (Schema::hasColumn('man_powers', 'contractor_sick_leave_man')) {
                $table->dropColumn('contractor_sick_leave_man');
            }
            if (Schema::hasColumn('man_powers', 'contractor_mcu')) {
                $table->dropColumn('contractor_mcu');
            }
            if (Schema::hasColumn('man_powers', 'contractor_mcu_man')) {
                $table->dropColumn('contractor_mcu_man');
            }
            if (Schema::hasColumn('man_powers', 'contractor_total_power')) {
                $table->dropColumn('contractor_total_power');
            }
            if (Schema::hasColumn('man_powers', 'contractor_total_power_man')) {
                $table->dropColumn('contractor_total_power_man');
            }
        });
    }
}
