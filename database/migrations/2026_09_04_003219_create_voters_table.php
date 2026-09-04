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
        Schema::create('voters', function (Blueprint $table) {
            $table->id();
            $table->string('nis')->nullable(); // Optional if they use access code primarily
            $table->string('name');
            $table->string('class_name')->nullable();
            $table->string('gender', 1)->nullable(); // L / P
            $table->string('access_code')->unique(); // The specific and flexible code
            $table->boolean('has_voted')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('voters');
    }
};
