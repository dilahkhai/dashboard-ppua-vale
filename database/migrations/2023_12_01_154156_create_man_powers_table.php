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
            $table->integer('crew_total')->nullable();
            $table->string('crew_total_man')->nullable();
            $table->integer('crew_leave')->nullable();
            $table->string('crew_leave_man')->nullable();
            $table->integer('crew_sick_leave')->nullable();
            $table->string('crew_sick_leave_man')->nullable();
            $table->integer('crew_mcu')->nullable();
            $table->string('crew_mcu_man')->nullable();
            $table->integer('crew_total_power')->nullable();
            $table->string('crew_total_power_man')->nullable();
            
            // Contractor data
            $table->integer('contractor_total')->nullable();
            $table->string('contractor_total_man')->nullable();
            $table->string('contractor_leave')->nullable();
            $table->string('contractor_leave_man')->nullable();
            $table->integer('contractor_sick_leave')->nullable();
            $table->string('contractor_sick_leave_man')->nullable();
            $table->integer('contractor_mcu')->nullable();
            $table->Istring('contractor_mcu_man')->nullable();
            $table->integer('contractor_total_power')->nullable();
            $table->string('contractor_total_power_man')->nullable();

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
