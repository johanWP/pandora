<?php

use Illuminate\Database\Seeder;

class TypeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('types')->insert([
            'name'     =>    'Sistema',
        ]);
        DB::table('types')->insert([
            'name'     =>    'Móvil',
        ]);
        DB::table('types')->insert([
            'name'     =>    'Fijo',
        ]);
    }
}
