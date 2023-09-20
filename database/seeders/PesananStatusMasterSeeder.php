<?php

namespace Database\Seeders;

use App\Models\PesananStatusMaster;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PesananStatusMasterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        PesananStatusMaster::create([
            'id' => 1,
            'status_pesanan' => "Belum Bayar",
        ]);

        PesananStatusMaster::create([
            'id' => 2,
            'status_pesanan' => "Dikemas",
        ]);

        PesananStatusMaster::create([
            'id' => 3,
            'status_pesanan' => "Dikirim",
        ]);

        PesananStatusMaster::create([
            'id' => 4,
            'status_pesanan' => "Selesai",
        ]);
    }
}
