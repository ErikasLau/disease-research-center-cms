<?php

namespace App\Models;

use Database\Factories\ExaminationFactory;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Examination extends Model
{
    /** @use HasFactory<ExaminationFactory> */
    use HasFactory, HasUlids;

    protected $fillable = [
        'type',
        'status',
        'comment',
        'patient_id',
        'visit_id'
    ];

    public function patient(): HasOne
    {
        return $this->hasOne(Patient::class, 'id', 'patient_id')->withTrashed();
    }

    public function result(): BelongsTo
    {
        return $this->belongsTo(Result::class, 'id', 'examination_id');
    }

    public function visit(): HasOne
    {
        return $this->hasOne(Visit::class, 'id', 'visit_id');
    }

    public $timestamps = true;
}
