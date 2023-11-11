<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class wta extends Model
{
    use HasFactory;

    protected $table = "wta";
    protected $primaryKey = "id_wta";
    public $timestamps = true;
}
