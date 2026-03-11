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
        Schema::create('section_hero', function (Blueprint $table) {
            $table->id(); // bigint unsigned + auto_increment (PRIMARY)

            $table->string('title')->nullable();
            $table->string('title_2')->nullable();
            $table->string('title_3')->nullable();
            $table->string('title_4')->nullable();
            $table->string('title_5')->nullable();
            $table->string('title_6')->nullable();


            $table->text('description')->nullable();
            $table->text('description_2')->nullable();
            $table->text('description_3')->nullable();
            $table->text('description_4')->nullable();
            $table->text('description_5')->nullable();
            $table->text('description_6')->nullable();

            // Image fields
            $table->string('image')->nullable();
            $table->string('image_2')->nullable();
            $table->string('image_3')->nullable();
            $table->string('image_4')->nullable();
            $table->string('image_5')->nullable();
            $table->string('image_6')->nullable();
            $table->string('image_7')->nullable();
            $table->string('image_8')->nullable();
            $table->string('image_9')->nullable();
            $table->string('image_10')->nullable();
            $table->string('image_11')->nullable();
            $table->string('image_12')->nullable();
            $table->string('image_13')->nullable();
            $table->string('image_14')->nullable();

            $table->string('image_background')->nullable();
            $table->string('image_background_2')->nullable();
            $table->string('image_background_3')->nullable();

            $table->string('action_label')->nullable();
            $table->string('action_label_2')->nullable();
            $table->string('action_label_3')->nullable();
            $table->string('action_label_4')->nullable();
            $table->string('action_label_5')->nullable();
            $table->string('action_label_6')->nullable();

            $table->string('action_url')->nullable();
            $table->string('action_url_2')->nullable();
            $table->string('action_url_3')->nullable();
            $table->string('action_url_4')->nullable();
            $table->string('action_url_5')->nullable();
            $table->string('action_url_6')->nullable();

            $table->string('video_url')->nullable();

            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('section_hero');
    }
};
