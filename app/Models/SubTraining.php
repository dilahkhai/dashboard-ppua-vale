<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SubTraining extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'certif_date' => 'datetime',
        'training_schedule' => 'datetime'
    ];

    public function training(): BelongsTo
    {
        return $this->belongsTo(TrainingStatus::class, 'training_status_id');
    }

    public function employee(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function statusText(): Attribute
    {
        return Attribute::get(function ($value, $attributes) {
            switch($attributes['status']) {
                case 1:
                    return 'Active';
                case 2:
                    return 'Warning';
                case 3:
                    return 'Expired';
                default:
                    return '';
            }
        });
    }
}
