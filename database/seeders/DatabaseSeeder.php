<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            'username' => 'Ini Admin',
            'nameuse' => 'jangan senggol admin',
            'email' => 'artiesesofficial@gmail.com',
            'password' => hash::make('asdqweasd'),
            'improfil' => 'Ini Admin.gif',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('users')->insert([
            'username' => 'Ini User',
            'nameuse' => 'ampun sepuh admin aku takut',
            'email' => 'ryukoogi712@gmail.com',
            'password' => hash::make('asdqweasd'),
            'improfil' => 'Ini User.gif',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('admin')->insert([
            'userid' => '1',
            'activity' => 'buat akun admin',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
