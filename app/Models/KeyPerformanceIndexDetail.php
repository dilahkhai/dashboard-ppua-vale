<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class KeyPerformanceIndexDetail extends Model
{
    use HasFactory;

    protected $guarded = [];
    public $appends = ['status'];

    public function key_performance_index(): BelongsTo
    {
        return $this->belongsTo(KeyPerformanceIndex::class, 'index_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function plan(): Attribute
    {
        return Attribute::set(function ($value) {
            return is_null($value) ? 0 : $value;
        });
    }

    public function actual(): Attribute
    {
        return Attribute::set(function ($value) {
            return is_null($value) ? 0 : $value;
        });
    }

    public function status(): Attribute
    {
        return Attribute::get(function () {
            return $this->actual >= $this->plan ? 'Done' : '';
        });
    }
}
