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
        Schema::create('video_sessions', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->foreignId('room_id')->constrained()->cascadeOnDelete();
            $table->string('api_session_id');
            $table->timestamp('started_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('video_sessions');
    }
};
