<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('phases', function (Blueprint $table) {
            $table->id('phaseID');
            $table->foreignId('taskID')->constrained('tasks', 'taskID')->onDelete('cascade');
            $table->integer('arrangement_number');
            $table->enum('phase_status', ['pending', 'in_progress', 'completed']);
            $table->timestamp('start_timestamp')->nullable();
            $table->timestamp('end_timestamp')->nullable();
            $table->string('phase_image')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('phases');
    }
};