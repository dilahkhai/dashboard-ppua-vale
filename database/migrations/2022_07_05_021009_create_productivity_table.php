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
        Schema::create('productivity', function (Blueprint $table) {
            $table->id('id_productivity');
            $table->unsignedBigInteger("area_id");
            $table->unsignedBigInteger('department_id');
            $table->double('update')->nullable();
            $table->double('selisih')->nullable();
            $table->timestamps();

            $table->foreign("department_id")
                ->references("id")
                ->on("departments")
                ->onDelete("cascade")
                ->onUpdate("cascade");

            $table->foreign("area_id")
                ->references("id")
                ->on("areas")
                ->onDelete("cascade")
                ->onUpdate("cascade");
        });
    }

    /**
     * Reverse the migration
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('productivity');
    }
};
