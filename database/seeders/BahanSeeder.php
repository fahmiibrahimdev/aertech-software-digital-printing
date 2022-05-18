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
				'nama_barang' 	=> 'TRANSPARANT',
				'stock' 		=> '0',
				'satuan' 		=> 'METER'
			],
			[
				'id_kategori' 	=> '1',
				'nama_barang' 	=> 'LUSTER',
				'stock' 		=> '0',
				'satuan' 		=> 'METER'
			],
			[
				'id_kategori' 	=> '1',
				'nama_barang' 	=> 'VINYL',
				'stock' 		=> '0',
				'satuan' 		=> 'LEMBAR'
			],
			[
				'id_kategori' 	=> '1',
				'nama_barang' 	=> 'ONE WAY',
				'stock' 		=> '0',
				'satuan' 		=> 'METER'
			],
			[
				'id_kategori' 	=> '1',
				'nama_barang' 	=> 'CLOTH SATIN',
				'stock' 		=> '0',
				'satuan' 		=> 'METER'
			],
			[
				'id_kategori' 	=> '1',
				'nama_barang' 	=> 'ALBATROS',
				'stock' 		=> '0',
				'satuan' 		=> 'METER'
			],
			[
				'id_kategori' 	=> '2',
				'nama_barang' 	=> 'FLEXY KOREA 440 GSM',
				'stock' 		=> '0',
				'satuan' 		=> 'METER'
			],
			[
				'id_kategori' 	=> '2',
				'nama_barang' 	=> 'FLEXY FRONLITE 280 GSM',
				'stock' 		=> '0',
				'satuan' 		=> 'METER'
			],
			[
				'id_kategori' 	=> '2',
				'nama_barang' 	=> 'FLEXY BACKLITE 550 GSM',
				'stock' 		=> '0',
				'satuan' 		=> 'METER'
			],
			[
				'id_kategori' 	=> '3',
				'nama_barang' 	=> 'ART PAPER',
				'stock' 		=> '0',
				'satuan' 		=> 'LEMBAR'
			],
			[
				'id_kategori' 	=> '3',
				'nama_barang' 	=> 'TRANSPARANT A3+',
				'stock' 		=> '0',
				'satuan' 		=> 'LEMBAR'
			],
			[
				'id_kategori' 	=> '3',
				'nama_barang' 	=> 'CHROMO',
				'stock' 		=> '0',
				'satuan' 		=> 'LEMBAR'
			],
			[
				'id_kategori' 	=> '3',
				'nama_barang' 	=> 'VYNIL A3+',
				'stock' 		=> '0',
				'satuan' 		=> 'LEMBAR'
			],
			[
				'id_kategori' 	=> '4',
				'nama_barang' 	=> 'DESAIN',
				'stock' 		=> '0',
				'satuan' 		=> 'SET'
			],
		];
		DB::table('bahans')->insert($data);
    }
}
