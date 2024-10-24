<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkSchedule extends Model
{
    /** @use HasFactory<\Database\Factories\WorkScheduleFactory> */
    use HasFactory;

    protected $fillable = [
        'shift_start_time',
        'shift_end_time',
        'frequency',
        'days_of_week',
    ];

    public $timestamps = true;

    public function doctor(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Doctor::class);
    }
}
