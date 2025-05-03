<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LikeArtievides extends Model
{
    protected $table = 'likeartievides'; 
    protected $fillable = ['userid', 'artievidesid'];
    public $timestamps = true;
}
