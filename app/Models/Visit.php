<?php

namespace App\Models;

use Database\Factories\VisitFactory;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Visit extends Model
{
    /** @use HasFactory<VisitFactory> */
    use HasFactory, HasUlids;

    protected $fillable = [
        'visit_date',
        'status',
    ];

    public function doctor(): HasOne
    {
        return $this->hasOne(Doctor::class, 'id', 'doctor_id');
    }

    public function patient(): HasOne
    {
        return $this->hasOne(Patient::class, 'id', 'patient_id');
    }

    public function examination(): BelongsTo
    {
        return $this->belongsTo(Examination::class);
    }

    public function doctorAppointmentSlot(): HasOne
    {
        return $this->HasOne(DoctorAppointmentSlot::class);
    }

    public $timestamps = true;
}
