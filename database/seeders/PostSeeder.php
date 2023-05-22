<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use Faker\Generator as Faker;
use Illuminate\Support\Str;

// import post
use App\Models\Post;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        for($i = 0; $i < 10; $i++) {
            $newPost = new Post();
    
            $newPost->title = $faker->sentence(6, true);
            $newPost->slug = Str::slug($newPost->title, '-');
            $newPost->content = $faker->text(500);
    
            $newPost->save();
        }
    }
}
