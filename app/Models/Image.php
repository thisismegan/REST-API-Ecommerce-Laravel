<?php

namespace App\Models;

use App\Models\Product;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Image extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $hidden = ['created_at', 'updated_at'];

    public $timestamps = false; 

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
