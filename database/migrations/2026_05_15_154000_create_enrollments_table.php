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
        Schema::create('enrollments', function (Blueprint $user_course) {
            $user_course->id();
            $user_course->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $user_course->foreignId('course_id')->constrained('courses')->onDelete('cascade');
            $user_course->timestamps();

            // Prevent duplicate enrollments
            $user_course->unique(['user_id', 'course_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('enrollments');
    }
};
