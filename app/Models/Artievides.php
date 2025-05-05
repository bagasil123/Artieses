<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Users;
use App\Models\LikeArtieVides;


class Artievides extends Model
{
    protected $table = 'artievides'; 
    protected $primaryKey = 'artievidesid';
    public $incrementing = true;
    protected $fillable = ['userid', 'judul', 'lseo', 'kseo', 'video','thumbnail', 'deltime'];
    public $timestamps = true;
    public function usericonVides()
    {
        return $this->belongsTo(Users::class, 'userid', 'userid');
    }
    public function likeVides()
    {
        return $this->hasMany(LikeArtieVides::class, 'artievidesid', 'artievidesid');
    }

}