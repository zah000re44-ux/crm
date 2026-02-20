<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Contract extends Model
{
    protected $fillable = [
        'client_id',
        'agent_id',
        'unit_id',        // إذا موجود عندك في الجدول (أنت قلت أضفته)
        'contract_no',
        'type',
        'status',
        'starts_at',
        'ends_at',

        // الموجود عندك سابقًا
        'amount',
        'notes',

        // ✅ حقول التحصيل الجديدة (بنضيفها بالـ migration)
        'rent_amount',
        'payment_type',   // monthly|quarterly|semiannually|annually
        'water_amount',
    ];

    protected $casts = [
        'starts_at'    => 'date',
        'ends_at'      => 'date',

        // الموجود عندك
        'amount'       => 'decimal:2',

        // ✅ الجديد
        'rent_amount'  => 'decimal:2',
        'water_amount' => 'decimal:2',
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function agent()
    {
        return $this->belongsTo(User::class, 'agent_id');
    }

    // ✅ علاقة الدفعات المرتبطة بالعقد
    public function payments(): HasMany
    {
        return $this->hasMany(ContractPayment::class);
    }
}
