<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Theatre extends Model
{
    protected $table = "theatres";
    protected $fillable = ['movie_name','section','image'];
    
    //these are necessary when using uuid
    protected $casts = ['id' => 'string'];
    protected $primaryKey = "id";
    public $incrementing = false;

    public function times()
    {
    	return $this->hasMany('App\Time', 'theatre_id');
    }

}
