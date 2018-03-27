<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Seats extends Model
{
    protected $table = "seats";
    protected $fillable = ['position', 'time_id','taken'];
    protected $casts = [
    	'id' => 'string',
    	'taken' => 'boolean'
    ];

    protected $primaryKey = "id";

    public $incrementing = false;

    public function times()
    {
        return $this->belongsTo('App\Time','time_id');
    }

    public function ticket()
    {
    	return $this->hasOne('App\Ticket', 'seats_id');
    }
    //overriding get method for taken in laravel admin
    public function getTakenAttribute($value)
    {
	    if($value == "") return "Empty";
	    return "Taken";
    }
}