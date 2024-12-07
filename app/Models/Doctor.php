<?php

namespace App\Models;

use Database\Factories\DoctorFactory;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Doctor extends Model
{
    /** @use HasFactory<DoctorFactory> */
    use HasFactory, HasUlids, SoftDeletes;

    protected $fillable = [
        'licence_number',
        'user_id',
        'doctor_specialization_id'
    ];

    public function user(): HasOne
    {
        return $this->HasOne(User::class, 'id', 'user_id')->withTrashed();
    }

    public function specialization(): HasOne
    {
        return $this->HasOne(DoctorSpecialization::class, 'id', 'doctor_specialization_id');
    }

    public function workSchedules(): HasMany
    {
        return $this->HasMany(WorkSchedule::class);
    }

    public function doctorAppointmentSlots(): HasMany
    {
        return $this->HasMany(DoctorAppointmentSlot::class);
    }
}
