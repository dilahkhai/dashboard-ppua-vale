<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class statusperday extends Model
{
    use HasFactory;

    protected $table = "statusperday";
    protected $primaryKey = "id_status";
    public $timestamps = true;
}
