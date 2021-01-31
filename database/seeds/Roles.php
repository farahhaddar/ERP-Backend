<?php

use Illuminate\Database\Seeder;

class Roles extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('roles')->insert([

            [
                'name' => 'Full Stack Developer',
            ],
            [
                'name' => 'Project manager',
            ],
            [
                'name' => 'Backend Developer',
            ],
            [
                'name' => 'Frontend Developer',
            ],
            [
                'name' => 'Quality Assurence',
            ],
            [
                'name' => 'Designer',
            ],

        ]);
    }
}
