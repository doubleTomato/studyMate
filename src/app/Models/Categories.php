<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categories extends Model
{
    use HasFactory;
    //
    protected $table = 'categories';

    // pk
    protected $primaryKey = 'id';

    //auto increament 여부
    public $incrementing = true;

    protected $casts = [
    ];

}
