<?php

namespace App\Models;

use Database\Factories\DoctorSpecializationFactory;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class DoctorSpecialization extends Model
{
    /** @use HasFactory<DoctorSpecializationFactory> */
    use HasFactory, HasUlids;

    protected $fillable = [
        'name',
        'description',
    ];

    public $timestamps = true;

    public function doctors(): BelongsTo
    {
        return $this->BelongsTo(Doctor::class, 'doctor_specialization_id', 'id');
    }
}
