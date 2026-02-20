<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Building extends Model
{
    protected $fillable = [
        'name',
        'city',
        'district',
        'address',
        'notes',
    ];

    public function units()
    {
        return $this->hasMany(Unit::class);
    }
}
