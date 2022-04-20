<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Master\Article;

class ArticleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\Article::factory(10)->create();
    }
}
