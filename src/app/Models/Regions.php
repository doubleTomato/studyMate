<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Regions extends Model
{
    //
    protected $table = 'regions';
        // pk
    protected $primaryKey = 'id';

    //auto increament 여부
    public $incrementing = true;


    protected $casts = [
    ];

}
