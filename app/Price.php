<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Price extends Model
{
    protected $table = "prices";
    protected $fillable = ['price'];
    protected $casts = [
    	'id' => 'string'
    ];
    protected $primaryKey = "id";

    public $incrementing = false;
}