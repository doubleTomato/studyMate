<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Study_members extends Model
{
    use HasFactory;

    protected $table = 'study_members';

    // pk
    protected $primaryKey = 'id';

    //auto increament 여부
    public $incrementing = true;

    protected $fillable = [
        'study_id',
        'member_id',
        'rank',
        'join_datetime'
    ];

    protected $casts = [
        'study_id' => 'integer',
        'member_id' => 'integer',
        'join_datetime' => 'datetime'
    ];

    public $timestamaps = false;


    public function study(): BelogsTo
}
