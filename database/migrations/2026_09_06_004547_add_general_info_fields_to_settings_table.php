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
        Schema::table('settings', function (Blueprint $table) {
            $table->string('period')->nullable()->after('school_name');
            $table->string('header_title')->nullable()->default('LOGIN HAK PILIH')->after('period');
            $table->string('election_title')->nullable()->default('Pemilihan Ketua OSIS')->after('header_title');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->dropColumn(['period', 'header_title', 'election_title']);
        });
    }
};
