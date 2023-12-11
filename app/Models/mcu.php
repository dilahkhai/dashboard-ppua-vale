<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class mcu extends Model
{
    use HasFactory;

    protected $table = "mcu";
    protected $primaryKey = "id_mcu";
    public $timestamps = true;

    protected $guarded = [];

    public function employee(){
        return $this->belongsTo(User::class, "employee_id");
    }

    public function area(): BelongsTo
    {
        return $this->belongsTo(Area::class);
    }

    public function getNextMcuStatusAttribute()
    {
        $nextMcu = isset($this->attributes['nextmcu']) ? Carbon::parse($this->attributes['nextmcu']) : null;

        return !is_null($nextMcu) ? today()->isAfter($nextMcu) : false;
    }
}
