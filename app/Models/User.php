<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'confirmpassword'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function area()
    {
        return $this->belongsTo(Area::class, 'area_id');
    }

    public function tasks(): HasMany
    {
        return $this->hasMany(Task::class);
    }

    public function safety_reports()
    {
        return $this->hasMany(SafetyReport::class, 'employee_id');
    }

    public function today_safety_report()
    {
        return $this->hasOne(SafetyReport::class, 'employee_id')->whereDate('created_at', Carbon::now());
    }

    public function working_time_per_week()
    {
        return $this->hasMany(WorkingTimePerWeek::class, 'employee_id');
    }

    public function manhours()
    {
        return $this->hasMany(ManHour::class, 'employee_id');
    }

    public function today_manhours()
    {
        return $this->hasMany(ManHour::class, 'employee_id')->whereDate('created_at', Carbon::now());
    }

    public function today_working_time_per_week()
    {
        return $this->hasOne(WorkingTimePerWeek::class, 'employee_id')->whereDate('created_at', Carbon::now());
    }

    public function statusperday()
    {
        return $this->hasMany(statusperday::class, 'employee_id');
    }

    public function todaystatusperday()
    {
        return $this->hasOne(statusperday::class, 'employee_id')->whereDate('created_at', Carbon::now());
    }

    public function overtime_hours(): HasMany
    {
        return $this->hasMany(OvertimeHour::class);
    }

    public function man_powers(): HasMany
    {
        return $this->hasMany(ManPower::class);
    }

    public function oncalls(): HasMany
    {
        return $this->hasMany(OnCallAutomation::class, 'user_id');
    }

    public function leaves(): HasMany
    {
        return $this->hasMany(EmployeeLeave::class, 'user_id');
    }

    public function position(): Attribute
    {
        return Attribute::get(function ($value) {
            return ucwords($value);
        });
    }

    public function initial(): Attribute
    {
        return Attribute::get(function ($value, $attributes) {
            return $value ?? implode("", json_decode(\Illuminate\Support\Str::initials($attributes['name'])));
        });
    }

    public function isAdmin(): Attribute
    {
        return Attribute::get(function () {
            return $this->role == 'admin';
        });
    }
}
