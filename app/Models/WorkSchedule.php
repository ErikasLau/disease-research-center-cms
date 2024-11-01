<?php

namespace App\Models;

use Database\Factories\WorkScheduleFactory;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class WorkSchedule extends Model
{
    /** @use HasFactory<WorkScheduleFactory> */
    use HasFactory, HasUlids;

    protected $fillable = [
        'shift_start_time',
        'shift_end_time',
        'shift_start_date',
        'shift_end_date',
        'days_of_week',
    ];

    public $timestamps = true;

    public function doctor(): BelongsTo
    {
        return $this->belongsTo(Doctor::class);
    }
}
