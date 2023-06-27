<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $guarded = [];
    public $timestamps = false;

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function order_detail()
    {
        return $this->hasMany(Order_detail::class);
    }

    public function order_status()
    {
        return $this->belongsTo(Order_status::class);
    }

    public function address()
    {
        return $this->belongsTo(Address::class);
    }
}
