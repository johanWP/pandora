<?php

use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('users')->insert([
            'firstName'     =>    'Super',
            'lastName'      =>    'Admin',
            'username'      =>    'superadmin',
            'email'         =>    'jmarchan@gmail.com',
            'password'      =>    bcrypt('Diego2201'),
            'active'        =>    '1',
            'company_id'    =>    '1',
            'employee_id'   =>    '1',
            'securityLevel' =>    '100',
        ]);



    }
}
