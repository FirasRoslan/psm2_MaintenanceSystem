<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('houses', function (Blueprint $table) {
            $table->id('houseID');
            $table->foreignId('userID')->constrained('users', 'id')->onDelete('cascade');
            $table->string('house_address');
            $table->integer('house_number_room');
            $table->integer('house_number_toilet');
            $table->string('house_image');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('houses');
    }
};