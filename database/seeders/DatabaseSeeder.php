<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            LaratrustSeeder::class,
			SettingTanggalSeeder::class,
			KategoriSeeder::class,
			LevelCustomerSeeder::class,
            MesinSeeder::class,
            NamaPekerjaanSeeder::class,
			BahanSeeder::class,
			DetailBahanSeeder::class,
			CustomerSeeder::class,
        ]);
    }
}
