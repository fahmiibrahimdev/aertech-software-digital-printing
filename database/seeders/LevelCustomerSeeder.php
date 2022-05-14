<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class LevelCustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
			[
				'nama_level' => 'REGULAR'
			],
			[
				'nama_level' => 'RESELLER'
			],
			[
				'nama_level' => 'CORPORATE'
			],
			[
				'nama_level' => 'KHUSUS'
			],
		];
		DB::table('level_customers')->insert($data);
    }
}
