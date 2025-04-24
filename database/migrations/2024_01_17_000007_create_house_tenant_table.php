<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('house_tenant', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('userID');
            $table->unsignedBigInteger('houseID');
            $table->timestamps();

            $table->foreign('userID')
                  ->references('userID')
                  ->on('users')
                  ->onDelete('cascade');
            $table->foreign('houseID')
                  ->references('houseID')
                  ->on('houses')
                  ->onDelete('cascade');

            $table->unique(['userID', 'houseID']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('house_tenant');
    }
};