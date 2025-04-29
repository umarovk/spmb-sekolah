<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class seedUser extends Seeder
{
    public function run(): void
    {
        DB::table('users')->insert([
            [
                'username' => 'umar',
                'nama' => 'Umar Abdur Rahman, S.Kom',
                'email' => 'umar@umar.com',
                'password' => bcrypt('lolipop'),
                'role' => 'admin'
            ],
            [
                'username' => 'bayu',
                'nama' => 'Bayu Aji Wibowo, S.Pd',
                'email' => 'senjawibowo99@gmail.com',
                'password' => bcrypt('lolipop'),
                'role' => 'admin'
            ],
            [
                'username' => 'suswan',
                'nama' => 'Suswan, S.Pd',
                'email' => 'suswanuny@gmail.com',
                'password' => bcrypt('lolipop'),
                'role' => 'admin'
            ],
            [
                'username' => 'teller',
                'nama' => 'Admin Teller',
                'email' => 'teller@gmail.com',
                'password' => bcrypt('teller'),
                'role' => 'teller'
            ],
            [
                'username' => 'guru',
                'nama' => 'Guru SMKC',
                'email' => 'guru@gmail.com',
                'password' => bcrypt('guru'),
                'role' => 'guest'
            ]
        ]);
    }
}
