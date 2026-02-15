<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Contract;
use App\Models\User;

class Client extends Model
{
    protected $fillable = [
        'name',
        'phone',
        'email',
        'source',
        'status',
        'assigned_to',

        // الحقول الجديدة
        'building_name',
        'district',
        'building_owner',
    ];

    public function assignedTo()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    public function notes()
    {
        return $this->hasMany(\App\Models\ClientNote::class);
    }

    public function contracts()
    {
        return $this->hasMany(Contract::class);
    }
}
