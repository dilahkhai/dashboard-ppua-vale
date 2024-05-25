<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Auth;

class KeyPerformanceIndex extends Model
{
    use HasFactory;

    protected $table = 'key_performance_indexes';
    protected $guarded = [];

    public function area(): BelongsTo
    {
        return $this->belongsTo(Area::class, 'area_id');
    }

    public function details(): HasMany
    {
        return $this->hasMany(KeyPerformanceIndexDetail::class, 'index_id');
    }

    public function allowed(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => explode(',', $value),
            set: fn ($value) => implode(',', $value)
        );
    }

    public function isOwner(): Attribute
    {
        return Attribute::get(function () {
            return (Auth::user()->area_id == $this->area_id && in_array(Auth::user()->position, $this->allowed)) || Auth::user()->role == 'admin';
        });
    }
}
