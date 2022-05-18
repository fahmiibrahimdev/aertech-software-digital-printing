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
                'nama_pekerjaan'  => 'STICKER TRANSPARANT',
                'lewat_produksi'  => '1',
                'lewat_finishing'  => '1',
            ],
            [
                'id_mesin'  => '1',
                'nama_pekerjaan'  => 'PVC LUSTER',
                'lewat_produksi'  => '1',
                'lewat_finishing'  => '1',
            ],
            [
                'id_mesin'  => '1',
                'nama_pekerjaan'  => 'STICKER VINYL',
                'lewat_produksi'  => '1',
                'lewat_finishing'  => '1',
            ],
            [
                'id_mesin'  => '1',
                'nama_pekerjaan'  => 'CLOTH SATIN',
                'lewat_produksi'  => '1',
                'lewat_finishing'  => '1',
            ],
			[
                'id_mesin'  => '1',
                'nama_pekerjaan'  => 'STICKER ALBATROS',
                'lewat_produksi'  => '1',
                'lewat_finishing'  => '1',
            ],
			[
                'id_mesin'  => '1',
                'nama_pekerjaan'  => 'STICKER ONE WAY',
                'lewat_produksi'  => '1',
                'lewat_finishing'  => '1',
            ],
			[
                'id_mesin'  => '2',
                'nama_pekerjaan'  => 'KORCIN',
                'lewat_produksi'  => '1',
                'lewat_finishing'  => '1',
            ],
			[
                'id_mesin'  => '2',
                'nama_pekerjaan'  => 'FLEXY',
                'lewat_produksi'  => '1',
                'lewat_finishing'  => '1',
            ],
			[
                'id_mesin'  => '2',
                'nama_pekerjaan'  => 'BACKLITE',
                'lewat_produksi'  => '1',
                'lewat_finishing'  => '1',
            ],
			[
                'id_mesin'  => '2',
                'nama_pekerjaan'  => 'BIAYA SETTING',
                'lewat_produksi'  => '1',
                'lewat_finishing'  => '1',
            ],
			[
                'id_mesin'  => '3',
                'nama_pekerjaan'  => 'ART PAPER',
                'lewat_produksi'  => '1',
                'lewat_finishing'  => '1',
            ],
			[
                'id_mesin'  => '3',
                'nama_pekerjaan'  => 'STICKER CHROMO',
                'lewat_produksi'  => '1',
                'lewat_finishing'  => '1',
            ],
			[
                'id_mesin'  => '3',
                'nama_pekerjaan'  => 'VINYL A3+',
                'lewat_produksi'  => '1',
                'lewat_finishing'  => '1',
            ],
			[
                'id_mesin'  => '3',
                'nama_pekerjaan'  => 'TRANSPARANT A3+',
                'lewat_produksi'  => '1',
                'lewat_finishing'  => '1',
            ],
			[
                'id_mesin'  => '4',
                'nama_pekerjaan'  => 'ONGKOS DESAIN',
                'lewat_produksi'  => '1',
                'lewat_finishing'  => '1',
            ],
        ];
        DB::table('nama_pekerjaans')->insert($data);
    }
}
