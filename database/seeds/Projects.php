<?php

use Illuminate\Database\Seeder;

class Projects extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('projects')->insert([

            [
                'name' => ' CMS',
                'date'=>  '2020/12/12',
            ],
            [
                'name' => 'Billing',
                'date'=>  '2021/01/12',
            ],
            [
                'name' => 'E-commerce',
                'date'=>  '2021/02/19',
            ],
            [
                'name' => 'wordpress',
                'date'=>  '2020/12/23',
            ],
            [
                'name' => 'PHP',
                'date'=>  '2022/7/5',
            ],
            [
                'name' => 'Laravel',
                'date'=>  '2020/11/12',
            ],

        ]);
    }
}
