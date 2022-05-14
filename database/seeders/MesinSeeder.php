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
                'kode_printer'  => 'C-600',
                'nama_printer'  => 'C-600',
                'status_perkalian_ukuran'  => '1',
            ],
            [
                'kode_printer'  => 'COLD',
                'nama_printer'  => 'LAM-COLD',
                'status_perkalian_ukuran'  => '0',
            ],
            [
                'kode_printer'  => 'HOT',
                'nama_printer'  => 'LAM-HOT',
                'status_perkalian_ukuran'  => '0',
            ],
            [
                'kode_printer'  => 'JASA',
                'nama_printer'  => 'JASA',
                'status_perkalian_ukuran'  => '0',
            ],
        ];
        DB::table('mesins')->insert($data);
    }
}
