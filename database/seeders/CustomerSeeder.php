<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CustomerSeeder extends Seeder
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
				'nama_customer' 	=> 'Fahmi Ibrahim',
				'no_telepon'	 	=> '085691253593',
				'email' 			=> '',
			],
			[
				'id_level_customer' => '1',
				'nama_customer' 	=> 'Dimas A.P',
				'no_telepon'	 	=> '082219721116',
				'email' 			=> '',
			],
			[
				'id_level_customer' => '1',
				'nama_customer' 	=> '3second',
				'no_telepon'	 	=> '089677860766',
				'email' 			=> '',
			],
			[
				'id_level_customer' => '1',
				'nama_customer' 	=> 'Mba Pecel Lele',
				'no_telepon'	 	=> '-',
				'email' 			=> '',
			],
			[
				'id_level_customer' => '2',
				'nama_customer' 	=> 'Rajip',
				'no_telepon'	 	=> '088882182872',
				'email' 			=> '',
			],
			[
				'id_level_customer' => '2',
				'nama_customer' 	=> 'CECEP HARNY',
				'no_telepon'	 	=> '082319881740',
				'email' 			=> '',
			],
			[
				'id_level_customer' => '2',
				'nama_customer' 	=> 'EKO KARYA BERSAMA',
				'no_telepon'	 	=> '-',
				'email' 			=> '',
			],
			[
				'id_level_customer' => '2',
				'nama_customer' 	=> 'MANG AGUS',
				'no_telepon'	 	=> '081323212923',
				'email' 			=> '',
			],
			[
				'id_level_customer' => '2',
				'nama_customer' 	=> 'A HAMDAN',
				'no_telepon'	 	=> '085723238671',
				'email' 			=> '',
			],
		];
		DB::table('customers')->insert($data);
    }
}
