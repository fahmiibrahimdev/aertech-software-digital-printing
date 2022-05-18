<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DetailBahanSeeder extends Seeder
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
				'id_level_customer' => '1',
				'id_pekerjaan'		=> '1',
				'id_bahan'			=> '1',
				'ukuran'			=> '',
				'min_qty'			=> '1',
				'max_qty'			=> '999',
				'harga_jual'		=> '100000',
				'min_order'			=> '1',
			],
			[
				'id_level_customer' => '1',
				'id_pekerjaan'		=> '2',
				'id_bahan'			=> '2',
				'ukuran'			=> '',
				'min_qty'			=> '1',
				'max_qty'			=> '999',
				'harga_jual'		=> '50000',
				'min_order'			=> '1',
			],
			[
				'id_level_customer' => '1',
				'id_pekerjaan'		=> '3',
				'id_bahan'			=> '4',
				'ukuran'			=> '',
				'min_qty'			=> '1',
				'max_qty'			=> '999',
				'harga_jual'		=> '50000',
				'min_order'			=> '1',
			],
			[
				'id_level_customer' => '1',
				'id_pekerjaan'		=> '4',
				'id_bahan'			=> '6',
				'ukuran'			=> '',
				'min_qty'			=> '1',
				'max_qty'			=> '999',
				'harga_jual'		=> '100000',
				'min_order'			=> '1',
			],
			[
				'id_level_customer' => '1',
				'id_pekerjaan'		=> '5',
				'id_bahan'			=> '10',
				'ukuran'			=> '',
				'min_qty'			=> '1',
				'max_qty'			=> '999',
				'harga_jual'		=> '50000',
				'min_order'			=> '1',
			],
			[
				'id_level_customer' => '1',
				'id_pekerjaan'		=> '6',
				'id_bahan'			=> '11',
				'ukuran'			=> '',
				'min_qty'			=> '1',
				'max_qty'			=> '999',
				'harga_jual'		=> '100000',
				'min_order'			=> '1',
			],
			[
				'id_level_customer' => '1',
				'id_pekerjaan'		=> '9',
				'id_bahan'			=> '9',
				'ukuran'			=> '',
				'min_qty'			=> '1',
				'max_qty'			=> '999',
				'harga_jual'		=> '100000',
				'min_order'			=> '1',
			],
			[
				'id_level_customer' => '1',
				'id_pekerjaan'		=> '7',
				'id_bahan'			=> '12',
				'ukuran'			=> '',
				'min_qty'			=> '1',
				'max_qty'			=> '999',
				'harga_jual'		=> '25000',
				'min_order'			=> '1',
			],
			[
				'id_level_customer' => '1',
				'id_pekerjaan'		=> '15',
				'id_bahan'			=> '15',
				'ukuran'			=> '',
				'min_qty'			=> '1',
				'max_qty'			=> '999',
				'harga_jual'		=> '15000',
				'min_order'			=> '1',
			],
			[
				'id_level_customer' => '2',
				'id_pekerjaan'		=> '1',
				'id_bahan'			=> '1',
				'ukuran'			=> '',
				'min_qty'			=> '1',
				'max_qty'			=> '999',
				'harga_jual'		=> '80000',
				'min_order'			=> '1',
			],
			[
				'id_level_customer' => '2',
				'id_pekerjaan'		=> '4',
				'id_bahan'			=> '6',
				'ukuran'			=> '',
				'min_qty'			=> '1',
				'max_qty'			=> '999',
				'harga_jual'		=> '80000',
				'min_order'			=> '1',
			],
			[
				'id_level_customer' => '2',
				'id_pekerjaan'		=> '7',
				'id_bahan'			=> '12',
				'ukuran'			=> '',
				'min_qty'			=> '1',
				'max_qty'			=> '999',
				'harga_jual'		=> '17000',
				'min_order'			=> '1',
			],
			[
				'id_level_customer' => '2',
				'id_pekerjaan'		=> '15',
				'id_bahan'			=> '15',
				'ukuran'			=> '',
				'min_qty'			=> '1',
				'max_qty'			=> '999',
				'harga_jual'		=> '15000',
				'min_order'			=> '1',
			],
			[
				'id_level_customer' => '2',
				'id_pekerjaan'		=> '3',
				'id_bahan'			=> '4',
				'ukuran'			=> '',
				'min_qty'			=> '1',
				'max_qty'			=> '999',
				'harga_jual'		=> '40000',
				'min_order'			=> '1',
			],
		];
		DB::table('detail_bahans')->insert($data);
    }
}
