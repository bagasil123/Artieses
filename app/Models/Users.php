<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
// Jika Anda mengimplementasikan Authenticatable, pastikan ini ada
use Illuminate\Contracts\Auth\Authenticatable; // <-- Tambahkan ini jika model ini digunakan untuk auth
// Jika Anda menggunakan trait, pastikan ini ada juga
use Illuminate\Foundation\Auth\User as AuthenticatableTrait; // <-- Atau ini jika Anda menggunakan trait dari Laravel

class Users extends Model // Jika Anda mengimplementasikan Authenticatable, tambahkan 'implements Authenticatable'
{
    // Jika Anda menggunakan trait dari Laravel untuk autentikasi, tambahkan ini
    // use AuthenticatableTrait; // <-- Uncomment ini jika Anda pakai trait dari Laravel

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

    // Perbaikan: tambahkan 'userid' sebagai local key
    public function subscribing()
    {
        // 'subscriber' adalah foreign key di tabel 'subs' yang menyimpan userid dari user yang melakukan subscribe
        // 'userid' adalah local key di tabel 'users' (primary key dari model Users)
        return $this->hasMany(Subs::class, 'subscriber', 'userid');
    }

    // Perbaikan: tambahkan 'userid' sebagai local key
    public function subscriber()
    {
        // 'subscribing' adalah foreign key di tabel 'subs' yang menyimpan userid dari user yang di-subscribe
        // 'userid' adalah local key di tabel 'users' (primary key dari model Users)
        return $this->hasMany(Subs::class, 'subscribing', 'userid');
    }

    // Jika Anda mengimplementasikan Illuminate\Contracts\Auth\Authenticatable,
    // Anda perlu metode-metode berikut:
    /*
    public function getAuthIdentifierName()
    {
        return 'userid';
    }

    public function getAuthIdentifier()
    {
        return $this->attributes['userid'];
    }

    public function getAuthPassword()
    {
        return $this->attributes['password'];
    }

    public function getRememberToken()
    {
        return $this->attributes['remember_token'] ?? null; // Sesuaikan jika tidak ada remember_token
    }

    public function setRememberToken($value)
    {
        $this->attributes['remember_token'] = $value; // Sesuaikan jika tidak ada remember_token
    }

    public function getRememberTokenName()
    {
        return 'remember_token'; // Sesuaikan jika tidak ada remember_token
    }
    */
}