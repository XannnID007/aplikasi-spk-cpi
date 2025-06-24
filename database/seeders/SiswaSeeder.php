<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Siswa;

class SiswaSeeder extends Seeder
{
    public function run()
    {
        $siswa = [
            [
                'kode' => 'A1',
                'nama' => 'Akhdan Latif Azizan',
                'jenis_kelamin' => 'Laki-laki',
                'tanggal_lahir' => '2018-03-15',
                'nama_orang_tua' => 'Budi Santoso',
                'alamat' => 'Jl. Mawar No. 12, Banjar'
            ],
            [
                'kode' => 'A2',
                'nama' => 'Nayaka Dzakiyah Rafifah',
                'jenis_kelamin' => 'Perempuan',
                'tanggal_lahir' => '2018-05-22',
                'nama_orang_tua' => 'Ahmad Rahman',
                'alamat' => 'Jl. Melati No. 8, Banjar'
            ],
            [
                'kode' => 'A3',
                'nama' => 'Hayfa Hanum Hanania',
                'jenis_kelamin' => 'Perempuan',
                'tanggal_lahir' => '2018-01-10',
                'nama_orang_tua' => 'Sari Indrawati',
                'alamat' => 'Jl. Anggrek No. 5, Banjar'
            ],
            [
                'kode' => 'A4',
                'nama' => 'Katya Yumna Aafiyah',
                'jenis_kelamin' => 'Perempuan',
                'tanggal_lahir' => '2018-07-03',
                'nama_orang_tua' => 'Dedi Kurniawan',
                'alamat' => 'Jl. Dahlia No. 20, Banjar'
            ],
            [
                'kode' => 'A5',
                'nama' => 'Farell Putra Sagara',
                'jenis_kelamin' => 'Laki-laki',
                'tanggal_lahir' => '2018-09-18',
                'nama_orang_tua' => 'Rina Marlina',
                'alamat' => 'Jl. Cempaka No. 7, Banjar'
            ],
            [
                'kode' => 'A6',
                'nama' => 'Shakila Sopiyah Maulidia',
                'jenis_kelamin' => 'Perempuan',
                'tanggal_lahir' => '2018-04-25',
                'nama_orang_tua' => 'Hendra Wijaya',
                'alamat' => 'Jl. Kenanga No. 15, Banjar'
            ],
            [
                'kode' => 'A7',
                'nama' => 'Safa Namira Hidayat',
                'jenis_kelamin' => 'Perempuan',
                'tanggal_lahir' => '2018-11-12',
                'nama_orang_tua' => 'Yuli Handayani',
                'alamat' => 'Jl. Tulip No. 3, Banjar'
            ],
            [
                'kode' => 'A8',
                'nama' => 'Reysa Rismawati',
                'jenis_kelamin' => 'Perempuan',
                'tanggal_lahir' => '2018-06-08',
                'nama_orang_tua' => 'Irwan Setiawan',
                'alamat' => 'Jl. Sakura No. 18, Banjar'
            ]
        ];

        foreach ($siswa as $s) {
            Siswa::create($s);
        }
    }
}
