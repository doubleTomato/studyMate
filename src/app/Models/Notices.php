<?php
// 공지
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notices extends Model
{
    use HasFactory;

    protected $table = 'notices';

    // pk
    protected $primaryKey = 'id';

    //auto increament 여부
    public $incrementing = true;

    protected $fillable = [
        'study_id',
        'member_id',
        'title',
        'content',
        'is_crucial'
    ];

    protected $casts = [
    ];

    public $timestamaps = false;


    public function study(): BelogsTo
}
