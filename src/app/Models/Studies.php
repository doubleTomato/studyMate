<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Studies extends Model
{
    //
    protected $table = 'studies';

    // pk
    protected $primaryKey = 'id';

    //auto increament 여부
    public $incrementing = true;

    protected $fillable = [
        'owner_id',
        'title',
        'description',
        'category_id',
        'is_offline',
        'region_id',
        'location',
        'start_date',
        'end_date',
        'views',
        'max_members',
        'deadline'
    ];

    protected $casts = [
        'max_members' => 'integer',
        'end_dateitme' => 'datetime',
    ];

    public $timestamaps = false;
}
