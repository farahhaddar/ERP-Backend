<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class KpiDetail extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('kpi_details')->insert([

            [
                'level' => 'Advanced',
                'date'  =>  Carbon:: now()->toDateString(),
                'kpiId' => '1',
            ],
            [
                'level' => 'Begginer',
                'date'  =>  Carbon:: now()->toDateString(),
                'kpiId' => '2',
            ],
            [
                'level' => 'Intermediate',
                'date'  =>  Carbon:: now()->toDateString(),
                'kpiId' => '3',
            ],
            [
                'level' => 'Advanced',
                'date'  =>  Carbon:: now()->toDateString(),
                'kpiId' => '4',
            ],
            [
                'level' => 'Begginer',
                'date'  =>  Carbon:: now()->toDateString(),
                'kpiId' => '5',
            ],
            [
                'level' => 'Intermediate',
                'date'  =>  Carbon:: now()->toDateString(),
                'kpiId' => '6',
            ],
        ]);
    }
}
