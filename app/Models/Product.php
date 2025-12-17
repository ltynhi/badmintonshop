<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Product extends Model
{
    protected $fillable = [
        'category_id',
        'name',
        'slug',
        'description',
        'price',
        'sale_price',
        'stock',
        'image',
        'images',
        'brand',
        'is_featured',
        'is_active',
    ];

    protected $casts = [
        'price' => 'integer',
        'sale_price' => 'integer',
        'stock' => 'integer',
        'images' => 'array',
        'is_featured' => 'boolean',
        'is_active' => 'boolean',
    ];

    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($product) {
            if (empty($product->slug)) {
                $product->slug = Str::slug($product->name);
            }
        });
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function approvedReviews()
    {
        return $this->hasMany(Review::class)->where('is_approved', true);
    }

    public function getAverageRating()
    {
        return $this->approvedReviews()->avg('rating') ?? 0;
    }

    public function getTotalReviews()
    {
        return $this->approvedReviews()->count();
    }

    public function getCurrentPrice()
    {
        return $this->sale_price ?? $this->price;
    }

    public function isOnSale()
    {
        return $this->sale_price !== null && $this->sale_price < $this->price;
    }
}
