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
        Schema::create('products', function (Blueprint $table) {
            $table->id();                                       // BIGINT auto increment PK

            $table->string('products_code', 255)->unique();     // kode produk unik
            $table->double('stock')->default(0);                // DOUBLE default 0
            $table->double('price')->nullable();                // DOUBLE
            $table->double('sale_price')->nullable();           // DOUBLE

            $table->string('is_featured')->nullable();          // VARCHAR 255 (bisa 'yes'/'no' atau '1'/'0')

            $table->string('status')->nullable();               // status produk
            $table->foreignId('product_categories_id')          // relasi ke categories
                  ->constrained('product_categories')
                  ->onDelete('cascade');

            $table->string('slug')->unique();                   // slug unik untuk URL
            $table->string('title');                            // judul produk
            $table->text('content')->nullable();            // isi/konten lengkap
            $table->text('overview')->nullable();               // ringkasan singkat

            $table->string('image')->nullable();                // nama file gambar / path
            $table->string('image_title')->nullable();          // judul gambar (alt text)

            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->string('meta_keywords')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
