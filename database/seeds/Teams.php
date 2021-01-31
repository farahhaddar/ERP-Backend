<?php

use Illuminate\Database\Seeder;

class Teams extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('teams')->insert([

            [
                'name' => 'farah',
            ],
            [
                'name' => 'Ali',
            ],
            [
                'name' => 'Hussien',
            ],
            [
                'name' => 'Alfa',
            ],
            [
                'name' => 'Delta',
            ],
            [
                'name' => 'Beta',
            ],

        ]); 
    }
}
