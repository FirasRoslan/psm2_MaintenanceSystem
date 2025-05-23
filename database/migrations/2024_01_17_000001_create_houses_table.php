<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('houses', function (Blueprint $table) {
            $table->bigIncrements('houseID');
            $table->unsignedBigInteger('userID');
            $table->string('house_address');
            $table->integer('house_number_room');
            $table->integer('house_number_toilet');
            $table->string('house_image');
            $table->timestamps();

            $table->foreign('userID')
                  ->references('userID')
                  ->on('users')
                  ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('houses');
    }
};