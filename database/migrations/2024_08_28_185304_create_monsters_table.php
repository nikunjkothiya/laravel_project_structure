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
        Schema::create('monsters', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 50);
            $table->string('imageUrl')->nullable();
            $table->unsignedSmallInteger('attack')->default(0);
            $table->unsignedSmallInteger('defense')->default(0);
            $table->unsignedSmallInteger('hp')->default(0);
            $table->unsignedSmallInteger('speed')->default(0);
            $table->timestamps();

            // Add indexes for better query performance
            $table->index(['attack', 'defense', 'hp', 'speed']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('monsters');
    }
};
