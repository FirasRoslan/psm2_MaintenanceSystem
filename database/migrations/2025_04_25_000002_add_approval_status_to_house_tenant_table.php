<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('house_tenant', function (Blueprint $table) {
            // Check if approval_status column doesn't exist before adding it
            if (!Schema::hasColumn('house_tenant', 'approval_status')) {
                $table->boolean('approval_status')->nullable()->after('houseID');
            }
        });
    }

    public function down()
    {
        Schema::table('house_tenant', function (Blueprint $table) {
            // Only drop if the column exists
            if (Schema::hasColumn('house_tenant', 'approval_status')) {
                $table->dropColumn('approval_status');
            }
        });
    }
};