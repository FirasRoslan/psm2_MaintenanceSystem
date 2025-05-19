<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('contractor_landlord', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('contractorID');
            $table->unsignedBigInteger('landlordID');
            $table->text('maintenance_scope');
            $table->string('specialization');
            $table->boolean('approval_status')->nullable();
            $table->timestamps();
            
            $table->foreign('contractorID')->references('userID')->on('users')->onDelete('cascade');
            $table->foreign('landlordID')->references('userID')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contractor_landlord');
    }
};