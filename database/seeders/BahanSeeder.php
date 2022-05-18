<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class BahanSeeder extends Seeder
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
				'id_kategori' 	=> '1',
				'nama_kategori' => 'TRANSPARANT',
				'stock' 		=> '0',
				'satuan' 		=> 'METER'
			],
			[
				'id_kategori' 	=> '1',
				'nama_kategori' => 'LUSTER',
				'stock' 		=> '0',
				'satuan' 		=> 'METER'
			],
			[
				'id_kategori' 	=> '1',
				'nama_kategori' => 'VINYL',
				'stock' 		=> '0',
				'satuan' 		=> 'LEMBAR'
			],
			[
				'id_kategori' 	=> '1',
				'nama_kategori' => 'ONE WAY',
				'stock' 		=> '0',
				'satuan' 		=> 'METER'
			],
			[
				'id_kategori' 	=> '1',
				'nama_kategori' => 'CLOTH SATIN',
				'stock' 		=> '0',
				'satuan' 		=> 'METER'
			],
			[
				'id_kategori' 	=> '1',
				'nama_kategori' => 'ALBATROS',
				'stock' 		=> '0',
				'satuan' 		=> 'METER'
			],
			[
				'id_kategori' 	=> '2',
				'nama_kategori' => 'FLEXY KOREA 440 GSM',
				'stock' 		=> '0',
				'satuan' 		=> 'METER'
			],
			[
				'id_kategori' 	=> '2',
				'nama_kategori' => 'FLEXY FRONLITE 280 GSM',
				'stock' 		=> '0',
				'satuan' 		=> 'METER'
			],
			[
				'id_kategori' 	=> '2',
				'nama_kategori' => 'FLEXY BACKLITE 550 GSM',
				'stock' 		=> '0',
				'satuan' 		=> 'METER'
			],
			[
				'id_kategori' 	=> '3',
				'nama_kategori' => 'ART PAPER',
				'stock' 		=> '0',
				'satuan' 		=> 'LEMBAR'
			],
			[
				'id_kategori' 	=> '3',
				'nama_kategori' => 'TRANSPARANT A3+',
				'stock' 		=> '0',
				'satuan' 		=> 'LEMBAR'
			],
			[
				'id_kategori' 	=> '3',
				'nama_kategori' => 'CHROMO',
				'stock' 		=> '0',
				'satuan' 		=> 'LEMBAR'
			],
			[
				'id_kategori' 	=> '3',
				'nama_kategori' => 'VYNIL A3+',
				'stock' 		=> '0',
				'satuan' 		=> 'LEMBAR'
			],
			[
				'id_kategori' 	=> '4',
				'nama_kategori' => 'DESAIN',
				'stock' 		=> '0',
				'satuan' 		=> 'SET'
			],
		];
		DB::table('bahans')->insert($data);
    }
}
