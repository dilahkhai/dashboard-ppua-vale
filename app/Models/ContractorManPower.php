<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ContractorManPower extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function man_power(): BelongsTo
    {
        return $this->belongsTo(ManPower::class, 'man_power_id');
    }
}
