<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\User;
class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       
        DB::table('users')->insert([
        [
            'name'     => 'Farah',
            'email'    => 'farah@gmail.com',
            'image'    => 'images/avatar6.jpeg',
            'password' =>bcrypt('12345678'),   
        ],
        [
            'name'     => 'Hussien',
            'email'    => 'hussien@gmail.com',
            'image'    => 'images/avatar1.jpeg',
            'password' =>bcrypt('12345678'),   
        ],
        [
            'name'     => 'Ali',
            'email'    => 'ali@gmail.com',
            'image'    => 'images/avatar2.jpeg',
            'password' =>bcrypt('12345678'),   
        ],
    

        ]);
        

      
    }
}
