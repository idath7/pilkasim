<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Optimasi Index:
     * 1. Hapus index duplikat pada access_code & username (UNIQUE sudah otomatis membuat index)
     * 2. Tambah composite index [type, class_name] untuk query filter+sort yang paling sering
     * 3. Tambah index pada voted_candidate_id untuk lookup saat reset suara
     */
    public function up(): void
    {
        // Hapus index duplikat secara aman (mungkin sudah terhapus dari percobaan sebelumnya)
        try { Schema::table('voters', fn($t) => $t->dropIndex('voters_access_code_index')); } catch (\Exception $e) {}
        try { Schema::table('voters', fn($t) => $t->dropIndex('voters_username_index')); } catch (\Exception $e) {}

        Schema::table('voters', function (Blueprint $table) {
            // Composite index untuk query paling sering: WHERE type = ? ORDER BY class_name
            $table->index(['type', 'class_name'], 'voters_type_class_name_index');

            // Index untuk lookup voted_candidate_id saat reset suara
            $table->index('voted_candidate_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('voters', function (Blueprint $table) {
            $table->dropIndex('voters_type_class_name_index');
            $table->dropIndex(['voted_candidate_id']);

            // Kembalikan index duplikat
            $table->index('access_code');
            $table->index('username');
        });
    }
};
