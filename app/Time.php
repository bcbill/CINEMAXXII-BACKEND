<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Time extends Model
{
    protected $table = "times";
    protected $fillable = ['time','theatre_id'];
    protected $casts = [
    	'id' => 'string'
    ];
    protected $primaryKey = "id";



    public $incrementing = false;

    public function theatres()
    {
        return $this->belongsTo('App\Theatre','theatre_id');
    }

    public function seats()
    {
        return $this->hasMany('App\Seats','time_id');
    }

}