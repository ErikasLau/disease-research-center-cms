<?php

namespace App\Models;

use Database\Factories\DoctorFactory;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Doctor extends Model
{
    /** @use HasFactory<DoctorFactory> */
    use HasFactory, HasUlids;

    protected $fillable = [
        'license_number',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function workSchedules(): HasMany
    {
        return $this->hasMany(WorkSchedule::class);
    }

    public function doctorAppointmentSlots(): HasMany
    {
        return $this->hasMany(DoctorAppointmentSlot::class);
    }

    public function specialization(): HasOne
    {
        return $this->HasOne(DoctorSpecialization::class, 'id', 'doctor_specialization_id');
    }
}
