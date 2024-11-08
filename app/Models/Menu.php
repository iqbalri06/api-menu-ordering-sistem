<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Menu extends Model
{
    protected $fillable = [
        'name', 
        'description', 
        'normal_price', 
        'discount_price', 
        'users_id', 
        'status', 
        'category', 
        'image'
    ];

    protected static function booted()
    {
        static::creating(function ($model) {
            $model->id = Str::uuid();
        });
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'users_id');
    }
    
}
