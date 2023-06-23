<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategoriesSeeder extends Seeder
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
                'name' => 'Politik',
                'user_id' => 1,
            ],
            [
                'name' => 'Teknologi',
                'user_id' => 1,
            ],
            [
                'name' => 'Olahraga',
                'user_id' => 1,
            ],
            [
                'name' => 'Makanan',
                'user_id' => 1,
            ],
            [
                'name' => 'Wisata',
                'user_id' => 1,
            ],
        ];

        foreach ($data as $row) {
            Category::create($row);
        }
    }
}
