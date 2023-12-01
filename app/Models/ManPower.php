<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class ManPower extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function crew(): HasOne
    {
        return $this->hasOne(CrewManPower::class, 'man_power_id');
    }

    public function contractor(): HasOne
    {
        return $this->hasOne(ContractorManPower::class, 'man_power_id');
    }
}
