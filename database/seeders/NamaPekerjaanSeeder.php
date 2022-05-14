<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class NamaPekerjaanSeeder extends Seeder
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
                'id_mesin'  => '1',
                'nama_pekerjaan'  => 'HVS SIAP CETAK',
                'produksi'  => '1',
                'finishing'  => '0',
            ],
            [
                'id_mesin'  => '1',
                'nama_pekerjaan'  => 'ART PAPER 120GR SIAP CETAK',
                'produksi'  => '1',
                'finishing'  => '0',
            ],
            [
                'id_mesin'  => '1',
                'nama_pekerjaan'  => 'ART PAPER 150GR SIAP CETAK',
                'produksi'  => '1',
                'finishing'  => '0',
            ],
            [
                'id_mesin'  => '1',
                'nama_pekerjaan'  => 'ART PAPER 210GR SIAP CETAK',
                'produksi'  => '1',
                'finishing'  => '0',
            ],
        ];
        DB::table('nama_pekerjaans')->insert($data);
    }
}
