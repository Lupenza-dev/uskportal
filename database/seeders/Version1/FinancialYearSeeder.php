<?php

namespace Database\Seeders\Version1;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FinancialYearSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
       // DB::table('financial_years')->truncate();


        DB::table('financial_years')->insert(array(
            0 =>
                array(
                    'id' => 1,
                    'name' => "2023/2024",
                    'start_date' =>'2023-12-20',
                    'end_date'   =>'2024-12-20',
                    'is_active'  => true,
                    'created_at' => '2023-12-20 03:04:00',
                    'updated_at' => '2023-12-20 03:04:00',
                )
            ));

            DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
