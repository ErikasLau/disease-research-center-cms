<?php

namespace App\Models;

use Database\Factories\PatientFactory;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Patient extends Model
{
    /** @use HasFactory<PatientFactory> */
    use HasFactory, HasUlids;

    protected $fillable = [
        'medical_history',
    ];

    public function user(): HasOne
    {
        return $this->HasOne(User::class, 'id', 'user_id');
    }

    public function examination(): BelongsToMany
    {
        return $this->belongsToMany(Examination::class);
    }

    public function visits(): BelongsToMany
    {
        return $this->belongsToMany(Visit::class);
    }
}
