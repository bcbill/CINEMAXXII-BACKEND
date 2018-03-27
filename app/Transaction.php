<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $table = "transactions";
    protected $fillable = ['ticket_id','user_id'];
    protected $casts = [
    	'id' => 'string'
    ];
    protected $primaryKey = "id";

    public $incrementing = false;

    public function ticket()
    {
        return $this->belongsTo('App\Ticket','ticket_id');
    }

    public function user()
    {
        return $this->belongsTo('App\User','user_id');
    }
}
