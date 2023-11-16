<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;
    protected $appends = [
        "open",
        "task_owner",
        "task_owner_area"
    ];

    protected $casts = [
        "start_date"    => "datetime:d/m/Y"
    ];

    public function getOpenAttribute(){
        return true;
    }

    public function owner(){
        return $this->belongsTo(User::class, "user_id");
    }

    public function getTaskOwnerAttribute(){
        return $this->owner->name;
    }

    public function getTaskOwnerAreaAttribute()
    {
        return $this->owner->area->area;
    }
}
