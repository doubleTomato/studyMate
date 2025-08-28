<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Posts extends Model
{
    use HasFactory;

    protected $table = 'posts';

    // pk
    protected $primaryKey = 'id';

    //auto increament 여부
    public $incrementing = true;

    protected $fillable = [
        'study_id',
        'member_id',
        'title',
        'content',
    ];

    protected $casts = [
        'checked_datetime' => 'datetime'
    ];

    public $timestamaps = false;


    public function study(): BelogsTo
}
