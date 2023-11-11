<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class cruduser extends Model
{
    use HasFactory;

    protected $table = "cruduser";
    protected $primaryKey = "id_pegawai";
    public $timestamps = true;


}
