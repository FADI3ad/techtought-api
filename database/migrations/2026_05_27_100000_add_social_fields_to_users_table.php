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
        Schema::table('users', function (Blueprint $table) {
            // Make existing fields nullable to support OAuth users without pre-existing phone/passwords
            $table->string('phone')->nullable()->change();
            $table->string('password')->nullable()->change();
            
            // Add provider specific fields
            $table->string('provider_name')->nullable()->after('password');
            $table->string('provider_id')->nullable()->after('provider_name');
            $table->text('provider_token')->nullable()->after('provider_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('phone')->nullable(false)->change();
            $table->string('password')->nullable(false)->change();
            $table->dropColumn(['provider_name', 'provider_id', 'provider_token']);
        });
    }
};
