<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Study_schedules extends Model
{
      //
    use HasFactory;

    protected $table = 'study_schedules';

    // pk
    protected $primaryKey = 'id';

    //auto increament 여부
    public $incrementing = true;

    protected $fillable = [
        'study_id',
        'type',
        'interval_days',
        'start_datetime',
        'end_datetime'
    ];

    protected $casts = [
        'study_id' => 'integer',
        'type' => 'integer',
        'start_datetime' => 'datetime',
        'end_datetime' => 'datetime'
    ];


    public function study(): BelongsTo
}
