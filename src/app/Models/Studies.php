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
        'category',
        'is_offline',
        'location',
        'end_dateitme',
        'views',
        'max_members'
    ];

    protected $casts = [
        'max_members' => 'integer',
        'views' => 'integer',
        'end_dateitme' => 'datetime',
    ];

    public $timestamaps = false;
}
