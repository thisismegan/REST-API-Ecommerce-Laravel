<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order_status extends Model
{
    use HasFactory;

    protected $table = 'order_status';

    protected $fillable = ['orderStatusName'];

    public function order()
    {
        return $this->hasMany(Order::class);
    }
}
