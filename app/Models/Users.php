<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Users extends Model
{
    protected $table = 'users'; 
    protected $primaryKey = 'userid';
    protected $fillable = ['username', 'nameuse', 'bio', 'email', 'password','improfil'];
    public $timestamps = true;
    public function stories()
    {
        return $this->hasMany(Artiestories::class, 'userid', 'userid');
    }
    public function videos()
    {
        return $this->hasMany(Artievides::class, 'userid', 'userid');
    }
    public function artiekeles()
    {
        return $this->hasMany(Artiekeles::class, 'userid', 'userid');
    }
    public function subscribing()
    {
        return $this->hasMany(Subs::class, 'subscriber');
    }
    public function subscriber()
    {
        return $this->hasMany(Subs::class, 'subscribing');
    }
}
