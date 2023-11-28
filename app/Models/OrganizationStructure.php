<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrganizationStructure extends Model
{
    use HasFactory;

    public function area(): BelongsTo
    {
        return $this->belongsTo(Area::class);
    }
}
