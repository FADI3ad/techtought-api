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
        Schema::create('instructor_accout_requests', function (Blueprint $table) {
            $table->id();
            $table->string('slug', 150)->unique();
            $table->string('full_name');
            $table->string('email')->unique();
            $table->string('country');
            $table->char('phone' , 20)->unique();
            $table->integer('age');
            $table->string('cv_link');
            $table->string('national_id_front_image');
            $table->string('national_id_back_image');
            $table->integer('experience_years');
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('instructor_accout_requests');
    }
};
