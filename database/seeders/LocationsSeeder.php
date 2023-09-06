<?php

namespace Database\Seeders;

use App\Models\Kota;
use App\Models\Provinsi;
use Illuminate\Database\Seeder;
use Kavist\RajaOngkir\Facades\RajaOngkir;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class LocationsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        {
            $daftarProvinsi = RajaOngkir::provinsi()->all();
            foreach ($daftarProvinsi as $provinceRow) {
                Provinsi::create([
                    'id' => $provinceRow['province_id'],
                    'name'        => $provinceRow['province'],
                ]);
                $daftarKota = RajaOngkir::kota()->dariProvinsi($provinceRow['province_id'])->get();
                foreach ($daftarKota as $cityRow) {
                    Kota::create([
                        'id'       => $cityRow['city_id'],
                        'provinsi_id'   => $provinceRow['province_id'],
                        'name'          => $cityRow['city_name'],
                    ]);
                }
            }
        }
    }
}
