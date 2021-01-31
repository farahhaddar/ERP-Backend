<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;
class KpiDetails extends Seeder
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
                'level' => '60',
                'date'  =>  Carbon:: now()->toDateString(),
                'KpiId' => 1,
            ],
            [
                'level' => '100',
                'date'  =>  Carbon:: now()->toDateString(),
                'KpiId' => 2,
            ],
            [
                'level' => '20',
                'date'  =>  Carbon:: now()->toDateString(),
                'KpiId' => 3,
            ],
            [
                'level' => '40',
                'date'  =>  Carbon:: now()->toDateString(),
                'KpiId' => 4,
            ],
            [
                'level' => '30',
                'date'  =>  Carbon:: now()->toDateString(),
                'KpiId' => 5,
            ],
            [
                'level' => '10',
                'date'  =>  Carbon:: now()->toDateString(),
                'KpiId' => 6,
            ],

        ]);
    }
}
