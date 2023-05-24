<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use Faker\Generator as Faker;
use Illuminate\Support\Str;

use App\Models\Tag;

class TagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        $tags = ['PHP', 'HTML', 'Figma', 'MySQL', 'JS', 'CSS', 'Sass', 'Postman', 'VS Code'];

        foreach($tags as $tag) {
            $newTag = new Tag();

            $newTag->name = $tag;
            $newTag->slug = Str::slug($newTag->name, '-');
            $newTag->color = $faker->hexColor();

            $newTag->save();
        }
    }
}
