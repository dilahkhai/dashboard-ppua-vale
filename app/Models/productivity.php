<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Area;

class productivity extends Model
{
    use HasFactory;

    protected $table = "productivity";
    protected $primaryKey = "id_productivity";
    public $timestamps = true;

    public function area(){
        return $this->belongsTo(Area::class, "area_id");
    }
}
