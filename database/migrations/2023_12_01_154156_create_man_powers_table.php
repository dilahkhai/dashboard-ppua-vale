<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateManPowersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('man_powers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('area_id')->constrained('areas');
            $table->foreignId('user_id')->constrained('users');
            $table->date('date');
            
            // Crew data
            $table->unsignedInteger('crew_total')->nullable();
            $table->unsignedInteger('crew_total_man')->nullable();
            $table->unsignedInteger('crew_leave')->nullable();
            $table->unsignedInteger('crew_leave_man')->nullable();
            $table->unsignedInteger('crew_sick_leave')->nullable();
            $table->unsignedInteger('crew_sick_leave_man')->nullable();
            $table->unsignedInteger('crew_mcu')->nullable();
            $table->unsignedInteger('crew_mcu_man')->nullable();
            $table->unsignedInteger('crew_total_power')->nullable();
            $table->unsignedInteger('crew_total_power_man')->nullable();
            
            // Contractor data
            $table->unsignedInteger('contractor_total')->nullable();
            $table->unsignedInteger('contractor_total_man')->nullable();
            $table->unsignedInteger('contractor_leave')->nullable();
            $table->unsignedInteger('contractor_leave_man')->nullable();
            $table->unsignedInteger('contractor_sick_leave')->nullable();
            $table->unsignedInteger('contractor_sick_leave_man')->nullable();
            $table->unsignedInteger('contractor_mcu')->nullable();
            $table->unsignedInteger('contractor_mcu_man')->nullable();
            $table->unsignedInteger('contractor_total_power')->nullable();
            $table->unsignedInteger('contractor_total_power_man')->nullable();

            $table->timestamps();

            $table->unique(['area_id', 'user_id', 'date']); // Ensure no duplicate entries
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('man_powers');
    }
}
