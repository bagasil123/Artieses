<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReactStories extends Model
{
    protected $table = 'reactartiestories'; 
    protected $fillable = ['userid', 'artiestoriesid'];
    public $timestamps = true;
}
