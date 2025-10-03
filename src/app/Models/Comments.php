<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use App\Models\Members;

class Comments extends Model
{

    public function members(){
        return $this -> belongsTo(Members::class, 'user_id');
    }

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
