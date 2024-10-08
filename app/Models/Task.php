<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'start_date',
        'end_date',
        'user_id',
        'progress',
        'status',
        'parent',
        'area_id', 
    ];

    // Relasi ke model User
    public function owner()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Relasi ke model Area
    public function area()
    {
        return $this->belongsTo(Area::class, 'area_id');
    }

    // Relasi ke parent task
    public function parentTask()
    {
        return $this->belongsTo(Task::class, 'parent');
    }

}
