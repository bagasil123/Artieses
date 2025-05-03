<?php

// app/Models/User.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Users extends Model
{
    protected $table = 'users'; 
    protected $fillable = ['username', 'nameuse', 'email', 'password','improfil'];
    public $timestamps = true;
}
