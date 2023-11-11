<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\productivity;
use Carbon\Carbon;

class Department extends Model
{
    use HasFactory;
    public function productivity(){
        return $this->hasMany(productivity::class, "department_id");
    }

    public function today_productivity(){
        return $this->hasOne(productivity::class, "department_id")->whereDate("created_at", Carbon::now());
    }
}
