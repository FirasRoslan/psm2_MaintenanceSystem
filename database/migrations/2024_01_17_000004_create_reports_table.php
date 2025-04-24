<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reports', function (Blueprint $table) {
            $table->id('reportID');
            $table->unsignedBigInteger('userID');
            $table->foreignId('itemID')->nullable()->constrained('items', 'itemID');
            $table->foreignId('roomID')->constrained('rooms', 'roomID');
            $table->text('report_desc');
            $table->string('report_image');
            $table->timestamps();

            $table->foreign('userID')
                  ->references('userID')
                  ->on('users')
                  ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reports');
    }
};