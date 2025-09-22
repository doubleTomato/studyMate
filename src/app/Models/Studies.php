<?php

namespace App\Models;

use App\Models\Category;
use App\Models\Regions;
use App\Models\Members;
use App\Models\Study_members;
use Illuminate\Database\Eloquent\Model;

class Studies extends Model
{

    // 관계정의
    // 1:1
    // category
    public function category(){
        return $this -> belongsTo(Category::class);
    }
    //지역
    public function region(){
        return $this -> belongsTo(Regions::class,'region_id');
    }
    //멤버
    public function leader(){
        return $this -> belongsTo(Members::class, 'owner_id');
    }
    // == 1:1 end
    // 스터디 멤버 N:M
    public function members(){
        return $this -> belongsToMany(Members::class, 'study_members', 'study_id','member_id') -> withPivot('rank');
    }
    


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
