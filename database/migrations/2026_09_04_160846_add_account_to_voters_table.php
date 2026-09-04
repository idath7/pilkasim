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
        Schema::table('voters', function (Blueprint $table) {
            $table->string('username')->nullable()->unique()->after('access_code');
            $table->string('password')->nullable()->after('username');
            
            // Allow access_code to be nullable if we use username/password
            $table->string('access_code')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('voters', function (Blueprint $table) {
            $table->dropColumn(['username', 'password']);
            $table->string('access_code')->nullable(false)->change();
        });
    }
};
