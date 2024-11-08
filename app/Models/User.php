<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'id',
        'name',
        'email',
        'password',
        'role_id',
        'status',
        'created_at',
        'updated_at'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    public $incrementing = false;
    protected $keyType = 'string';

    protected static function booted() {
        static::creating(function ($model) {
            $model->id = Str::uuid();
        });
    }

    // JWT Required Methods
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [
            'email' => $this->email,
            'name' => $this->name,
            'role_id' => $this->role_id
        ];
    }

    // Relationship
    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function menus()
{
    return $this->hasMany(Menu::class);
}

    // Add any additional methods you need here
}