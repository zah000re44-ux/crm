<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Client;
use App\Models\User;

class Contract extends Model
{
    protected $fillable = [
        'client_id','agent_id','contract_no','type','status',
        'starts_at','ends_at','amount','notes'
    ];

    protected $casts = [
        'starts_at' => 'date',
        'ends_at'   => 'date',
        'amount'    => 'decimal:2',
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function agent()
    {
        return $this->belongsTo(User::class, 'agent_id');
    }
}
