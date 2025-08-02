<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\BankSampah;

class BankSampahSeeder extends Seeder
{
    public function run()
    {
        $banks = [
            ['nama' => 'Bank Sampah Sejahtera', 'alamat' => 'Jl. Merdeka No. 1, Jakarta'],
            ['nama' => 'Bank Sampah Indah', 'alamat' => 'Jl. Melati No. 5, Bandung'],
            ['nama' => 'Bank Sampah Cemerlang', 'alamat' => 'Jl. Mawar No. 10, Surabaya'],
            ['nama' => 'Bank Sampah Hijau', 'alamat' => 'Jl. Kenanga No. 20, Yogyakarta'],
            ['nama' => 'Bank Sampah Mandiri', 'alamat' => 'Jl. Anggrek No. 15, Medan'],
        ];

        foreach ($banks as $bank) {
            BankSampah::create($bank);
        }
    }
}
