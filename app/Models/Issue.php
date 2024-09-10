<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Issue extends Model
{
    use HasFactory;

    protected $fillable = [
        'issue',
        'start_date',
        'end_date',
        'user_id',
        'progress',
        'action',
        'area_id', 
    ];

    // Relasi ke model User
    public function pic()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Relasi ke model Area
    public function area()
    {
        return $this->belongsTo(Area::class, 'area_id');
    }
}

