<?php

namespace Database\Seeders;

use App\Models\Post;
use Illuminate\Database\Seeder;

class PostsSeeder extends Seeder
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
                'title' => 'A Loving Heart is the Truest Wisdom',
                'thumbnail' => '-',
                'description' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Maiores corrupti, voluptatibus delectus doloremque accusantium dignissimos mollitia molestiae rerum est eaque.',
                'body' => 'Lorem, ipsum dolor sit amet consectetur adipisicing elit. Labore, ipsa, quae dolores tenetur repellat distinctio optio corrupti eos sequi quidem nisi tempore at, possimus provident! Porro dignissimos aliquam iusto accusamus error sunt ex doloribus autem unde, consequuntur eligendi alias, distinctio quod quae dicta quaerat in debitis ea esse! Porro, amet repudiandae. Harum dignissimos quisquam atque consectetur numquam ipsa assumenda veritatis rem enim voluptatum facilis, possimus in excepturi. Ullam, illo. Molestias neque iusto odit tempore rerum quia velit id voluptatibus vel placeat amet doloremque perspiciatis, repudiandae exercitationem inventore magnam nihil recusandae temporibus nisi a ut, eligendi laudantium sed veniam! Tenetur, assumenda!',
                'user_id' => 1
            ],
        ];

        foreach ($data as $row) {
            Post::create($row);
        }
    }
}
