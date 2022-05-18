<?php

namespace Database\Seeders;

use DateTime;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class MesinSeeder extends Seeder
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
                'id_kategori'  	=> '1',
                'kode_printer'  => '001',
                'nama_printer'  => 'MIMAKI',
                'status_perkalian_ukuran'  => '0',
            ],
            [
				'id_kategori'  	=> '2',
                'kode_printer'  => '002',
                'nama_printer'  => 'GONGZHENG',
                'status_perkalian_ukuran'  => '0',
            ],
            [
				'id_kategori'  	=> '3',
                'kode_printer'  => '003',
                'nama_printer'  => 'FUJI XEROX',
                'status_perkalian_ukuran'  => '0',
            ],
            [
				'id_kategori'  	=> '4',
                'kode_printer'  => '004',
                'nama_printer'  => 'PC COM',
                'status_perkalian_ukuran'  => '0',
            ],
        ];
        DB::table('mesins')->insert($data);
    }
}
