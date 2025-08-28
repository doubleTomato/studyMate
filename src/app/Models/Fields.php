<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Fields extends Model
{
    //
    use HasFactory;

    protected $table = 'fields';

    // pk
    protected $primaryKey = 'id';

    //auto increament 여부
    public $incrementing = true;

    protected $fillable = [
        'name'
    ];

    protected $casts = [
    ];


}
