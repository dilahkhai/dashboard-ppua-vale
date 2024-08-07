<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SafetyShare extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'safetydate'
    ];
}
