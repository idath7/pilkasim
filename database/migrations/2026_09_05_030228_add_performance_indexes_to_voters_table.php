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
            $table->index('access_code');
            $table->index('username');
            $table->index('type');
            $table->index('has_voted');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('voters', function (Blueprint $table) {
            $table->dropIndex(['access_code']);
            $table->dropIndex(['username']);
            $table->dropIndex(['type']);
            $table->dropIndex(['has_voted']);
        });
    }
};
