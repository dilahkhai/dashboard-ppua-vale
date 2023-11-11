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
        Schema::create('statusperday', function (Blueprint $table) {
            $table->id('id_status');
            $table->unsignedBigInteger('employee_id')->nullable();
            $table->integer('office')->nullable();
            $table->integer('ho')->nullable();
            $table->integer('training')->nullable();
            $table->integer('sick_leave')->nullable();
            $table->integer('annual_leave')->nullable();
            $table->integer('emergency_leave')->nullable();
            $table->integer('medical_leave')->nullable();
            $table->integer('maternity_leave')->nullable();
            $table->integer('wta')->nullable();
            $table->timestamps();

            $table->foreign("employee_id")
                ->references("id")
                ->on("users")
                ->onDelete("cascade")
                ->onUpdate("cascade");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('statusperday');
    }
};
