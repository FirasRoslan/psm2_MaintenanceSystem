<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('items', function (Blueprint $table) {
            $table->id('itemID');
            $table->foreignId('roomID')->constrained('rooms', 'roomID')->onDelete('cascade');
            $table->string('item_type');
            $table->string('item_name');
            $table->integer('item_quantity');
            $table->string('item_image');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('items');
    }
};