<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TrainingStatus extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function subTrainings(): HasMany
    {
        return $this->hasMany(SubTraining::class, 'training_status_id');
    }
}
