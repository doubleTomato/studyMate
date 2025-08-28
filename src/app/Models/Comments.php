<?php

namespace App\Models;

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
        'post_id',
        'user_id',
        'content',
        'type',
    ];

    protected $casts = [
        'post_id' => 'integer',
        'user_id' => 'integer',
    ];


    public function study(): BelogsTo
}
