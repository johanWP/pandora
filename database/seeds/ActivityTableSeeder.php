<?php

use Illuminate\Database\Seeder;

class ActivityTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('activity')->insert([
            'name'     =>    'Visita Técnica',
        ]);
        DB::table('activity')->insert([
            'name'     =>    'Obras',
        ]);
        DB::table('activity')->insert([
            'name'     =>    'Garantías',
        ]);
    }
}
