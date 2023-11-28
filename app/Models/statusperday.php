<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class statusperday extends Model
{
    use HasFactory;

    protected $table = "statusperday";
    protected $primaryKey = "id_status";
    public $timestamps = true;

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'employee_id');
    }
}
