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
        Schema::create('mcu', function (Blueprint $table) {
            $table->id('id_mcu');
            $table->unsignedBigInteger("employee_id");
            $table->String('lastmcu');
            $table->String('duedate');
            $table->String('status')->nullable();
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
        Schema::dropIfExists('mcu');
    }
};
