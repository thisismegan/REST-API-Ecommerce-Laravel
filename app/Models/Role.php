<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    protected $fillable = ['roleName'];

    public $timestamps = false;

    public function user()
    {
        return $this->hasOne(User::class);
    }
}
