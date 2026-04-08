<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    /** @use HasFactory<\Database\Factories\ProductFactory> */
    use HasFactory;

    protected $fillable = [
        'products_code',
        'stock',
        'price',
        'sale_price',
        'show_price',
        'is_featured',
        'status',
        'product_categories_id',
        'slug',
        'title',
        'content',
        'overview',
        'image',
        'image_title',
        'meta_title',
        'meta_description',
        'meta_keywords',
    ];

    public function category()
    {
        return $this->belongsTo(ProductCategory::class, 'product_categories_id');
    }
}
