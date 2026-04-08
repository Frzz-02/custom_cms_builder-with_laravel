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
        Schema::create('section_teams', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('position')->nullable();
            $table->string('image')->nullable();

            $table->string('status'); // NOT NULL

            $table->string('link_profile_1')->nullable();
            $table->string('link_profile_2')->nullable();
            $table->string('link_profile_3')->nullable();
            $table->string('link_profile_4')->nullable();

            $table->timestamps();
            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('section_teams');
    }
};
