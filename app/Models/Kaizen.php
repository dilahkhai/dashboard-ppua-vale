<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kaizen extends Model
{
    use HasFactory;
    protected $table = "kaizen";

    protected $guarded = [];
}
