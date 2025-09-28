<?php

namespace App\Models;
use Illuminate\Contracts\Auth\MustVerifyEmail; // 

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;


class Members extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable;

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
        'region_id',
        'category_id',
        'preferred_time_slot',
        'self_introduce',
        'profile_url',
        'remember_token',
        'email_verified_datetime',
        'provider',
        'provider_id'
    ];

    protected $attributes = [
        'nickname' => '',
        'location' => '',
        'provider' => '',
        'provider_id' => ''
    ];

    protected $casts = [
        'email_verified_datetime' => 'datetime'
    ];

    public $timestamaps = false;
}
