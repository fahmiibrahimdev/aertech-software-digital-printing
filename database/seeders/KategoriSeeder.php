<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class KategoriSeeder extends Seeder
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
				'nama_kategori' => 'INDOOR'
			],
			[
				'nama_kategori' => 'OUTDOOR'
			],
			[
				'nama_kategori' => 'A3+'
			],
		];
		DB::table('kategoris')->insert($data);
    }
}
