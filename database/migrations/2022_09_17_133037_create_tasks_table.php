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
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("area_id")->nullable();
            $table->string('name');
            $table->unsignedBigInteger('user_id');
            $table->enum('priority', ["Low","Med","High"]);
            $table->integer('duration');
            $table->dateTime('start_date');
            $table->enum('status', ["Not Started","In Progress", "Complete", "Overdue"]);
            $table->timestamps();


            $table->foreign("area_id")
                ->references("id")
                ->on("areas")
                ->onDelete("cascade")
                ->onUpdate("cascade");

            $table->foreign("user_id")
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
        Schema::dropIfExists('tasks');
    }
};
