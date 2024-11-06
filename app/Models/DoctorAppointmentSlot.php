<?php

namespace App\Models;

use Database\Factories\DoctorAppointmentSlotFactory;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class DoctorAppointmentSlot extends Model
{
    /** @use HasFactory<DoctorAppointmentSlotFactory> */
    use HasFactory, HasUlids;

    protected $fillable = [
        'start_time',
        'end_time',
        'is_available'
    ];

    public function doctors(): HasOne
    {
        return $this->HasOne(Doctor::class);
    }

    public function visit(): BelongsTo
    {
        return $this->BelongsTo(Visit::class);
    }

    public $timestamps = true;
}