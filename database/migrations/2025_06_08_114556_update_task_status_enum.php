<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // SQLite doesn't support ENUM or MODIFY COLUMN
        // We need to recreate the table with the new structure
        
        // Drop temp table if it exists from previous failed attempts
        Schema::dropIfExists('tasks_temp');
        
        // First, create a temporary table with the new structure
        Schema::create('tasks_temp', function (Blueprint $table) {
            $table->id('taskID');
            $table->foreignId('reportID')->constrained('reports', 'reportID')->onDelete('cascade');
            $table->unsignedBigInteger('userID');
            $table->string('task_status'); // Changed from enum to string
            $table->string('task_type');
            $table->string('completion_image')->nullable();
            $table->text('completion_notes')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->timestamp('submitted_at')->nullable();
            $table->timestamps();

            $table->foreign('userID')
                  ->references('userID')
                  ->on('users')
                  ->onDelete('cascade');
        });
        
        // Check if completion_image column exists in the original table
        $columns = Schema::getColumnListing('tasks');
        $hasCompletionFields = in_array('completion_image', $columns);
        
        if ($hasCompletionFields) {
            // Copy data including completion fields if they exist
            DB::statement('INSERT INTO tasks_temp (taskID, reportID, userID, task_status, task_type, completion_image, completion_notes, completed_at, submitted_at, created_at, updated_at) SELECT taskID, reportID, userID, task_status, task_type, completion_image, completion_notes, completed_at, submitted_at, created_at, updated_at FROM tasks');
        } else {
            // Copy data without completion fields if they don't exist
            DB::statement('INSERT INTO tasks_temp (taskID, reportID, userID, task_status, task_type, created_at, updated_at) SELECT taskID, reportID, userID, task_status, task_type, created_at, updated_at FROM tasks');
        }
        
        // Drop the old table
        Schema::dropIfExists('tasks');
        
        // Rename the temporary table
        Schema::rename('tasks_temp', 'tasks');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Drop temp table if it exists
        Schema::dropIfExists('tasks_temp');
        
        // Create temporary table with old structure
        Schema::create('tasks_temp', function (Blueprint $table) {
            $table->id('taskID');
            $table->foreignId('reportID')->constrained('reports', 'reportID')->onDelete('cascade');
            $table->unsignedBigInteger('userID');
            $table->string('task_status'); // Keep as string since SQLite doesn't support enum
            $table->string('task_type');
            $table->timestamps();

            $table->foreign('userID')
                  ->references('userID')
                  ->on('users')
                  ->onDelete('cascade');
        });
        
        // Copy data back (excluding new columns)
        DB::statement('INSERT INTO tasks_temp (taskID, reportID, userID, task_status, task_type, created_at, updated_at) SELECT taskID, reportID, userID, task_status, task_type, created_at, updated_at FROM tasks');
        
        // Drop current table
        Schema::dropIfExists('tasks');
        
        // Rename temp table
        Schema::rename('tasks_temp', 'tasks');
    }
};