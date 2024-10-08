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
        Schema::create('status_mcus', function (Blueprint $table) {
            $table->id();
            $table->integer("value");
            $table->unsignedBigInteger("area_id");
            $table->timestamps();

            $table->foreign("area_id")
                ->references("id")
                ->on("areas")
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
        Schema::dropIfExists('status_mcus');
    }
};
