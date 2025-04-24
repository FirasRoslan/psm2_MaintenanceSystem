<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->id('taskID');
            $table->foreignId('reportID')->constrained('reports', 'reportID')->onDelete('cascade');
            $table->unsignedBigInteger('userID');
            $table->enum('task_status', ['pending', 'in_progress', 'completed']);
            $table->string('task_type');
            $table->timestamps();

            $table->foreign('userID')
                  ->references('userID')
                  ->on('users')
                  ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};