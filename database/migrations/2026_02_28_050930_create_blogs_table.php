<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('blogs', function (Blueprint $table) {
            $table->id();

            $table->string('is_featured')->default('0');
            $table->string('status')->default('draft');

            $table->dateTime('publish_date')->nullable();

            $table->foreignId('blog_categories_id')
                  ->nullable()
                  ->constrained('blog_categories')
                  ->nullOnDelete();

            $table->string('image_featured')->nullable();
            $table->string('author')->nullable();

            $table->string('slug')->unique();
            $table->string('name')->nullable();
            $table->string('title');

            $table->text('content')->nullable();
            $table->string('image')->nullable();

            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->string('meta_keywords')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('blogs');
    }
};