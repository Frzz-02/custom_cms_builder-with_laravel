<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductCategory extends Model
{
    /** @use HasFactory<\Database\Factories\ProductCategoryFactory> */
    use HasFactory;

    protected $fillable = [
        'status',
        'slug',
        'name',
        'description',
        'meta_title',
        'meta_description',
        'meta_keywords',
    ];

    public function products()
    {
        return $this->hasMany(Product::class, 'product_categories_id');
    }
}
