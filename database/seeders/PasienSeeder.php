<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Pasien;

class PasienSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $pasien = new Pasien;
 
        $pasien->nama_pasien = "Pasien 1";
        $pasien->kewarganegaraan = "Indonesia";
        $pasien->nik = "123456789012345";
        $pasien->no_passport = "123456789012345";
        $pasien->jenis_kelamin = true;
        $pasien->tempat_lahir = "Yogyakarta";
        $pasien->tanggal_lahir = "10-10-2000";
        $pasien->umur = 22;
        $pasien->rt = "02";
        $pasien->rw = "05";
        $pasien->kelurahan = "mujamuju";
        $pasien->kecamatan = "umbulharjo";
        $pasien->kabupaten = "Yogya";
        $pasien->provinsi = "D.I.Yogyakarta";
        $pasien->kode_pos = "55555";

        $pasien->save();
    }
}
