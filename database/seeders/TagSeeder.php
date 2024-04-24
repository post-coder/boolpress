<?php

namespace Database\Seeders;

use App\Models\Tag;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tags = ['html', 'css', 'js', 'php', 'mysql'];

        
        foreach($tags as $tag) {

            $newTag = new Tag();

            $newTag->title = $tag;

            $newTag->save();
            
        }
    }
}
