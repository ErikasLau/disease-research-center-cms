<?php

namespace App\Models;

use Database\Factories\ResultFactory;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Result extends Model
{
    /** @use HasFactory<ResultFactory> */
    use HasFactory, HasUlids;

    protected $fillable = [
        'excerpt',
        'user_id',
        'examination_id'
    ];

    public function examination(): HasOne
    {
        return $this->hasOne(Examination::class, 'id', 'examination_id');
    }

    public function user(): HasOne
    {
        return $this->hasOne(User::class, 'id', 'user_id')->withTrashed()->withTrashed();
    }

    public function comment(): BelongsTo
    {
        return $this->BelongsTo(Comment::class, 'id', 'result_id');
    }

    public $timestamps = true;
}
