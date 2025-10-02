<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comments extends Model
{
    use HasFactory;

    protected $table = 'comments';

    // pk
    protected $primaryKey = 'id';

    //auto increament 여부
    public $incrementing = true;

    protected $fillable = [
        'study_post_id',
        'user_id',
        'parent_id',
        'content',
        'status',
    ];

    protected $casts = [
        'study_post_id' => 'integer',
        'user_id' => 'integer',
    ];


}
