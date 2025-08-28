<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Members extends Model
{
    protected $table = 'members';
    // pk
    protected $primaryKey = 'id';

    //auto increament 여부
    public $incrementing = true;

    protected $fillable = [
        'name',
        'nickname',
        'email',
        'password',
        'location',
        'profile_url',
        'remember_token',
        'email_verified_datetime',
        'provider',
        'provider_id'
    ];

    protected $casts = [
        'email_verified_datetime' => 'datetime'
    ];

    public $timestamaps = false;
}
