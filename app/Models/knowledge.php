<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class knowledge extends Model
{
    use HasFactory;

    protected $table = "knowledge";
    protected $primaryKey = "id_knowledge";
    public $timestamps = true;

}
