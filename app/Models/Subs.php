<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subs extends Model
{
    protected $table = 'subs'; 
    protected $primaryKey = 'subsid';
    protected $fillable = ['subscriber', 'subscribing'];
    public $timestamps = true;
}
