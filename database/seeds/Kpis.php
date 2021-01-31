<?php

use Illuminate\Database\Seeder;

class Kpis extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('kpis')->insert([

            [
                'name' => 'Laravel',
                'employeeId'=> 1,
            ],
            [
                'name' => 'Laravel',
                'employeeId'=> 2,
            ],
            [
                'name' => 'React',
                'employeeId'=>3,
            ],
            [
                'name' => 'React',
                'employeeId'=>4,
            ],
            [
                'name' => 'NodeJS',
                'employeeId'=>5,
            ],
            [
                'name' => 'NodeJS',
                'employeeId'=>6,
            ],

        ]);
    }
}
