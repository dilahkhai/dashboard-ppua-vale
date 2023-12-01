<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contractor_man_powers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('man_power_id')->constrained()->cascadeOnDelete();
            $table->integer('total')->nullable();
            $table->text('total_man')->nullable();
            $table->integer('utw')->nullable();
            $table->text('utw_man')->nullable();
            $table->integer('quarantine')->nullable();
            $table->text('quarantine_man')->nullable();
            $table->integer('leave')->nullable();
            $table->text('leave_man')->nullable();
            $table->integer('sick_leave')->nullable();
            $table->text('sick_leave_man')->nullable();
            $table->integer('mcu')->nullable();
            $table->text('mcu_man')->nullable();
            $table->integer('ot_hours')->nullable();
            $table->text('ot_hours_man')->nullable();
            $table->integer('ot')->nullable();
            $table->text('ot_man')->nullable();
            $table->integer('total_power')->nullable();
            $table->text('total_power_man')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('contractor_man_powers');
    }
};
