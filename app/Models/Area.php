<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Area extends Model
{
    use HasFactory;

    public function key_performance_indexes(): HasMany
    {
        return $this->hasMany(KeyPerformanceIndex::class, 'area_id');
    }

    public function employees(){
        return $this->hasMany(User::class, "area_id");
    }

    public function mcus(): HasMany
    {
        return $this->hasMany(mcu::class);
    }

    public function OrganizationStructures(): HasMany
    {
        return $this->hasMany(OrganizationStructure::class);
    }
}
