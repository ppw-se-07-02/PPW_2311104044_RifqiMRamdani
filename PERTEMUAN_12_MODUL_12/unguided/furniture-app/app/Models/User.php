<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;
    
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'address'
    ];
    
    protected $hidden = [
        'password',
        'remember_token',
    ];
    
    public function carts()
    {
        return $this->hasMany(Cart::class);
    }
    
    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}