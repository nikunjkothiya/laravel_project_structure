<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('battles', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('monsterA');
            $table->unsignedInteger('monsterB');
            $table->unsignedInteger('winner');
            $table->timestamps();

            // Add foreign key constraints
            $table->foreign('monsterA')->references('id')->on('monsters')->onDelete('cascade');
            $table->foreign('monsterB')->references('id')->on('monsters')->onDelete('cascade');
            $table->foreign('winner')->references('id')->on('monsters')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('battles');
    }
};
