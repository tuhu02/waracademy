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
        Schema::create('tournaments', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->dateTime('date')->nullable();
            $table->integer('duration')->default(45);
            $table->integer('max_participants')->default(30);
            $table->text('description')->nullable();
            $table->integer('point_per_question')->default(10);
            $table->integer('bonus_exp')->default(0);
            $table->string('room_code')->unique();
            $table->json('questions')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
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
        Schema::dropIfExists('tournaments');
    }
};
