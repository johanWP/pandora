<?php

use Illuminate\Database\Seeder;

class CompanyTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('companies')->insert([
            'name'     =>    'Cooperativa VT',
            'parent'      =>    0,
        ]);
        DB::table('companies')->insert([
            'name'     =>    'Cooperativa Obras y VT',
            'parent'      =>    0,
        ]);
        DB::table('companies')->insert([
            'name'     =>    'Cooperativa Garantías y Obras',
            'parent'      =>    0,
        ]);
    }
}
