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
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('school_name')->nullable();
            $table->text('instructions')->nullable();
            $table->string('osim_logo')->nullable();
            $table->string('school_logo')->nullable();
            $table->string('main_image')->nullable();
            $table->string('theme_color_1')->default('#2db8a6');
            $table->string('theme_color_2')->default('#1b9282');
            $table->string('theme_color_3')->default('#f59e0b');
            $table->string('theme_color_4')->default('#ffffff');
            $table->boolean('use_gradient')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
