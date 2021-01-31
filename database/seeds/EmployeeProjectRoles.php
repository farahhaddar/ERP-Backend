<?php

use Illuminate\Database\Seeder;

class EmployeeProjectRoles extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('employee_project_roles')->insert([

            [
                'employeeId'=> '1',
                'projectId' => '1',
                'roleId'    => '1',

            ],
            [
                'employeeId'=> '2',
                'projectId' => '2',
                'roleId'    => '2',
            ],
            [
                'employeeId'=> '3',
                'projectId' => '3',
                'roleId'    => '3',
            ],
            [
                'employeeId'=> '4',
                'projectId' => '4',
                'roleId'    => '4',
            ],
            [
                'employeeId'=> '5',
                'projectId' => '5',
                'roleId'    => '5',
            ],
            [
                'employeeId'=> '6',
                'projectId' => '6',
                'roleId'    => '6',
            ],

        ]);
    }
}
