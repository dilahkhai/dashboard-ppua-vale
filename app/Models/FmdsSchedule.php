<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FmdsSchedule extends Model
{
    use HasFactory;

    protected $table = 'table_fmds_schedule';

    protected $fillable = [
        'fmds_date',
        'area_id',
    ];

    public function area()
    {
        return $this->belongsTo(Area::class);
    }
}
