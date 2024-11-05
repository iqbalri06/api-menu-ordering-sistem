<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{

    protected $table = 'role';
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'name',
        'description',
    ];

    protected static function booted() {
        static::creating(function ($model) {
            $model->id = Str::uuid();
        });
    }
}
