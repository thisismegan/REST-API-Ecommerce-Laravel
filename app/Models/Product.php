<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Product extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $hidden = ['created_at', 'updated_at'];


    public function scopeSearch(Builder $query, array $filter)
    {
        if ($filter['keyword'] ?? false) {
            return $query->where('productName', 'like', '%' . $filter['keyword'] . '%')->orWhere('description', 'like', '%' . $filter['keyword'] . '%');
        }
    }

    public function scopeCategory(Builder $query, array $filter)
    {
        if ($filter['category'] ?? false) {
            return $query->where('category_id', $filter);
        }
    }

    public function image()
    {
        return $this->hasMany(Image::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function cart()
    {
        return $this->hasMany(Cart::class);
    }

    public function order_detail()
    {
        return $this->hasMany(Order_detail::class);
    }
}
