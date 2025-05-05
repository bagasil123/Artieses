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
        
        // DB::table('rcm2story')->insert([
        //     'userid' => '2',
        //     'balcomstoriesid' => '1',
        //     'reaksi' => 'marah',
        //     'created_at' => now(),
        //     'updated_at' => now(),
        // ]);
        // DB::table('commentartiestories')->insert([
        //     'userid' => '2',
        //     'artiestoriesid' => '1',
        //     'commentses' => 'hai kamu dimana',
        //     'created_at' => now(),
        //     'updated_at' => now(),
        // ]);
        DB::table('balcomstories')->insert([
            'userid' => '1',
            'commentartiestoriesid' => '3',
            'comment' => 'hai aku disini',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        // DB::table('likeartievides')->insert([
        //     'userid' => '1',
        //     'artievidesid' => '2',
        //     'created_at' => now(),
        //     'updated_at' => now(),
        // ]);
        // DB::table('likeartievides')->insert([
        //     'userid' => '2',
        //     'artievidesid' => '2',
        //     'created_at' => now(),
        //     'updated_at' => now(),
        // ]);
        // DB::table('reactartiestories')->insert([
        //     'userid' => '1',
        //     'artiestoriesid' => '1',
        //     'reaksi' => 'sedih',
        //     'created_at' => now(),
        //     'updated_at' => now(),
        // ]);
        // DB::table('reactartiestories')->insert([
        //     'userid' => '2',
        //     'artiestoriesid' => '1',
        //     'reaksi' => 'ketawa',
        //     'created_at' => now(),
        //     'updated_at' => now(),
        // ]);
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
