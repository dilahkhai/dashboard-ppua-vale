<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class oncall extends Model
{
    use HasFactory;

    protected $table = "oncall";
    protected $primaryKey = "id_oncall";
    public $timestamps = true;

}
