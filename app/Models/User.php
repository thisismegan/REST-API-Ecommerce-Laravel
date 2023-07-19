<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;


class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable;


    protected $fillable = [
        'role_id',
        'firstName',
        'lastName',
        'email',
        'email_verified_at',
        'password',
        'gender',
        'remember_token',
        'userImage'
    ];


    protected $hidden = [
        'password',
        'created_at',
        'updated_at'
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    public function address()
    {
        return $this->hasMany(Address::class);
    }

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function product()
    {
        return $this->belongsToMany(Product::class);
    }

    public function order()
    {
        return $this->hasMany(Order::class);
    }

    public function order_status()
    {
        return $this->hasOne(Order_status::class);
    }
}
