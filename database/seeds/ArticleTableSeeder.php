<?php

use Illuminate\Database\Seeder;

class ArticleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //$faker = Faker::create();
        for ($i=0; $i<50 ; $i++)
        {
            factory(App\Article::class)->create();
        }
    }
}
