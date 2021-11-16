<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class UserOTP extends Model
{


    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */

    protected $table = 'otps' ;

    protected $fillable = [
        'user_id',
        'token',
        'expires',
    ];

    public function owner()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function getIsValidAttribute()
    {
        $dt      = Carbon::now();
        $future  = Carbon::createFromDate($this->expires) ;
        return $future->gte($dt) ;
    }


}
