<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    //
    use HasFactory;

    protected $table = 'attendance';

    // pk
    protected $primaryKey = 'id';

    //auto increament 여부
    public $incrementing = true;

    protected $fillable = [
        'study_id',
        'member_id',
        'schedule_id',
        'status',
        'checked_datetime'
    ];

    protected $casts = [
        'study_id' => 'integer',
        'member_id' => 'integer',
        'schedule_id' => 'integer',
        'checked_datetime' => 'datetime'
    ];


    public function study(): BelogsTo
}
