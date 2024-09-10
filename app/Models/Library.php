<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Library extends Model
{
    use HasFactory;

    protected $table = 'library';

    protected $fillable = [
        'bn',
        'name',
        'book',
        'status',
        'borrow_date',
        'return_date',
    ];

    protected $dates = ['borrow_date', 'return_date'];

    // Set return_date automatically
    public static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            // Set return_date to one month after borrow_date
            if ($model->borrow_date) {
                $model->return_date = Carbon::parse($model->borrow_date)->addMonth();
            }
        });
    }
}
