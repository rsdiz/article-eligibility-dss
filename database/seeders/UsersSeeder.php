<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [
                'name' => 'Admin',
                'email' => 'admin@mail.com',
                'role' => 'admin',
                'password' => bcrypt('password')
            ],
            [
                'name' => 'Reader',
                'email' => 'reader@mail.com',
                'role' => 'reader',
                'password' => bcrypt('password')
            ]
        ];

        foreach ($data as $row) {
            User::create($row);
        }
    }
}
