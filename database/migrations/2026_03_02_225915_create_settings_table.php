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
            $table->id(); // BIGINT auto increment primary key

            $table->string('site_title')->nullable();
            $table->string('site_subtitle')->nullable();
            $table->string('time_zone')->nullable();
            $table->string('locale_language')->nullable();
            $table->text('site_description')->nullable();
            $table->string('site_keywords')->nullable();
            $table->string('site_url')->nullable();
            $table->string('site_logo')->nullable();
            $table->string('site_logo_2')->nullable();
            $table->string('favicon')->nullable();
            $table->string('preloader')->nullable();

            $table->timestamps(); // created_at & updated_at (nullable by default di PG)
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