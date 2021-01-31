<?php

use Illuminate\Database\Seeder;

class Employees extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('employees')->insert([

            [
                'name'   => 'farah',
                'email'  => 'farah@gmail.com',
                'phoneNb'=> '03333333',
                'image'  => 'images/avatar6.jpeg',
                'teamId' =>  '1',

            ],
            [
                'name' => 'Ali',
                'email'  => 'ali@gmail.com',
                'phoneNb'=> '01111111',
                'image'  => 'images/avatar1.jpeg',
                'teamId' =>  '2',
            ],
            [
                'name' => 'Hussien',
                'email'  => 'hussien@gmail.com',
                'phoneNb'=> '02222222',
                'image'  => 'images/avatar2.jpeg',
                'teamId' =>  '3',
            ],
            [
                'name' => 'Alfa',
                'email'  => 'alfa@gmail.com',
                'phoneNb'=> '04444444',
                'image'  => 'images/avatar3.jpeg',
                'teamId' =>  '1',
            ],
            [
                'name' => 'Delta',
                'email'  => 'delta@gmail.com',
                'phoneNb'=> '05555555',
                'image'  => 'images/avatar4.jpeg',
                'teamId' =>  '4',
            ],
            [
                'name' => 'Beta',
                'email'  => 'beta@gmail.com',
                'phoneNb'=> '06666666',
                'image'  => 'images/avatar5.jpeg',
                'teamId' =>  '6',
            ],

        ]);
    }
}
