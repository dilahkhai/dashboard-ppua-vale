<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Models\Area;
use App\Models\WorkingTimePerWeek;
use App\Models\statusperday;
use App\Models\ManHour;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function area()
    {
        return $this->belongsTo(Area::class, "area_id");
    }

    public function tasks(): HasMany
    {
        return $this->hasMany(Task::class);
    }

    public function safety_reports()
    {
        return $this->hasMany(SafetyReport::class, "employee_id");
    }

    public function today_safety_report()
    {
        return $this->hasOne(SafetyReport::class, "employee_id")->whereDate("created_at", Carbon::now());
    }

    public function working_time_per_week()
    {
        return $this->hasMany(WorkingTimePerWeek::class, "employee_id");
    }

    public function manhours()
    {
        return $this->hasMany(ManHour::class, "employee_id");
    }

    public function today_manhours()
    {
        return $this->hasMany(ManHour::class, "employee_id")->whereDate("created_at", Carbon::now());
    }

    public function today_working_time_per_week()
    {
        return $this->hasOne(WorkingTimePerWeek::class, "employee_id")->whereDate("created_at", Carbon::now());
    }

    public function statusperday()
    {
        return $this->hasMany(statusperday::class, "employee_id");
    }
    public function todaystatusperday()
    {
        return $this->hasOne(statusperday::class, "employee_id")->whereDate("created_at", Carbon::now());
    }

    public function overtime_hours(): HasMany
    {
        return $this->hasMany(OvertimeHour::class);
    }

    public function man_powers(): HasMany
    {
        return $this->hasMany(ManPower::class);
    }
}
