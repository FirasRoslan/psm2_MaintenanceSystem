<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Check if approval column doesn't exist before adding it
            if (!Schema::hasColumn('users', 'approval')) {
                $table->boolean('approval')->default(false);
            }
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Only drop if the column exists
            if (Schema::hasColumn('users', 'approval')) {
                $table->dropColumn('approval');
            }
        });
    }
};