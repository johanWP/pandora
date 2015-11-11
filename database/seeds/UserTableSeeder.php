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
            'firstName'     =>    'Jon',
            'lastName'      =>    'Snow',
            'username'      =>    'jsnow',
            'email'         =>    'jon@thewall.com',
            'password'      =>    bcrypt('123456'),
            'active'        =>    '1',
            'company_id'    =>    '1',
            'employee_id'   =>    '1',
            'securityLevel' =>    '100',
        ]);
        DB::table('users')->insert([
            'firstName'     =>    'Jeoffrey',
            'lastName'      =>    'Baratheon',
            'username'      =>    'daking',
            'email'         =>    'king@kingslanding.biz',
            'password'      =>    bcrypt('123456'),
            'active'        =>    '1',
            'company_id'    =>    '1',
            'employee_id'   =>    '2',
            'securityLevel' =>    '50',
        ]);
        DB::table('users')->insert([
            'firstName'     =>    'Eddard',
            'lastName'      =>    'Stark',
            'username'      =>    'ned',
            'email'         =>    'ned@winterfell.org',
            'password'      =>    bcrypt('123456'),
            'active'        =>    '0',
            'company_id'    =>    '1',
            'employee_id'   =>    '3',
            'securityLevel' =>    '10',
        ]);


    }
}
