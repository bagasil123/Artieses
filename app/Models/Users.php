<?php

// app/Models/User.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Users extends Model
{
    protected $table = 'users'; 
    protected $primaryKey = 'userid';
    protected $fillable = ['username', 'nameuse', 'bio', 'email', 'password','improfil'];
    public $timestamps = true;
}
