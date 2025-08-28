<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Member_fields extends Model
{
    //
    use HasFactory;

    protected $table = 'member_fields';

    // pk
    protected $primaryKey = 'id';

    //auto increament 여부
    public $incrementing = true;

    protected $fillable = [
        'member_id',
        'field_id'
    ];

    protected $casts = [
        'member_id' => 'integer',
        'field_id' => 'integer'
    ];

    public timestamps = false;

}
