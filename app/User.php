<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'phone', 'dob',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        /*'password',*/ 'remember_token',
    ];
    protected $casts = [
        'id' => 'string'
    ];
    protected $primaryKey = "id";

    public $incrementing = false;

    public function transaction()
    {
        return $this->hasMany('App\Transaction','user_id');
    }



    // public function getDobAttribute($value)
    // {
    //     $value->format('d/m/Y');
    // }
    
}
