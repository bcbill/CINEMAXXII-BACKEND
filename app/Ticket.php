<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    protected $table = "tickets";
    protected $fillable = ['seats_id'];
    protected $casts = [
    	'id' => 'string'
    ];
    protected $primaryKey = "id";

    public $incrementing = false;

    public function seat()
    {
        return $this->belongsTo('App\Seats', 'seats_id');
    }

    public function transaction()
    {
    	return $this->hasOne('App\Transaction', 'ticket_id');
    }
}
