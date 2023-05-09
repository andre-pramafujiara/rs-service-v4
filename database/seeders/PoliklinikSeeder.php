<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Poliklinik;

class PoliklinikSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $poliklinik = new Poliklinik;
 
        $poliklinik->name = "Poli 1";
 
        $poliklinik->save();
    }
}
