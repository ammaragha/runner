<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('categories')->insert(
            [
                [
                    'name' => 'plumber',
                    'created_at' => Carbon::now()
                ],
                [
                    'name' => 'painter',
                    'created_at' => Carbon::now()
                ],
                [
                    'name' => 'electrician',
                    'created_at' => Carbon::now()
                ], [
                    'name' => 'carpenter',
                    'created_at' => Carbon::now()
                ],
            ]
        );
    }
}
