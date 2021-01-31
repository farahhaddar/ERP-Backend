<?php

use Illuminate\Database\Seeder;

class TeamProjects extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('team_projects')->insert([

            [
                'teamId'    => '1',
                'projectId' => '1',

            ],
            [
                'teamId'    => '2',
                'projectId' => '2',
            ],
            [
                'teamId'    => '3',
                'projectId' => '3',
            ],
            [
                'teamId'    => '4',
                'projectId' => '4',
            ],
            [
                'teamId'    => '5',
                'projectId' => '5',
            ],
            [
                'teamId'    => '6',
                'projectId' => '6',
            ],

        ]);
    }
}
