<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class DoctorSpecialization extends Model
{
    /** @use HasFactory<\Database\Factories\DoctorSpecializationFactory> */
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
    ];

    public $timestamps = true;

    public function doctor(): BelongsToMany
    {
        return $this->BelongsToMany(Doctor::class);
    }
}
