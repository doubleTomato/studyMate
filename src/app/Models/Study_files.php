<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Study_files extends Model
{
   //
    use HasFactory;

    protected $table = 'study_files';

    // pk
    protected $primaryKey = 'id';

    //auto increament 여부
    public $incrementing = true;

    protected $fillable = [
        'study_id',
        'member_id',
        'file_url',
        'upload_datetime'
    ];

    protected $casts = [
        'study_id' => 'integer',
        'member_id' => 'integer',
        'upload_datetime' => 'datetime'
    ];

    public $timestamps = false;


}
