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
        Schema::create('rooms', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('skill_to_learn_id')->constrained('skills')->cascadeOnDelete();
            $table->foreignId('skill_to_teach_id')->constrained('skills')->cascadeOnDelete();
            $table->integer('max_attendees')->default(5);
            $table->string('name');
            $table->string('description')->nullable();
            $table->string('image');
            $table->string('access_code')->nullable();
            $table->text('requirements')->nullable();
            $table->text('learning_outcomes')->nullable();
            $table->boolean('is_resources_provided')->default(false);
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_private')->default(false);
            $table->boolean('is_active')->default(true);
            $table->timestamp('featured_expires_at')->nullable();           
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rooms');
    }
};
