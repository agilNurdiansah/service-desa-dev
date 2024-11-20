<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class MasterResidentSeeder extends Seeder
{



    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('master_residents')->insert([
            [
                'no_kk' => '1234567890123456',
                'nik' => '123456789012345678',
                'status_pernikahan' => 'Kawin',
                'relationship_family' => 'Kepala Keluarga',
                'kewarganegaraan' => 'Indonesia',
                'nama_ayah' => 'John Doe',
                'nama_ibu' => 'Jane Doe',
                'nama' => 'John Doe Jr.',
                'jenis_kelamin' => 'L',
                'tempat_lahir' => 'Jakarta',
                'tanggal_lahir' => '1990-01-01',
                'pendidikan' => 'S1',
                'jenis_pekerjaan' => 'Karyawan',
                'agama' => 'Islam',
                'alamat' => 'Jl. Sudirman No. 1, Jakarta',
            ],
            [
                'no_kk' => '1234567890123456',
                'nik' => '123456789012345789',
                'status_pernikahan' => 'Kawin',
                'relationship_family' => 'Istri',
                'kewarganegaraan' => 'Indonesia',
                'nama_ayah' => 'John Doe',
                'nama_ibu' => 'Jane Doe',
                'nama' => 'Jane Doe Jr.',
                'jenis_kelamin' => 'P',
                'tempat_lahir' => 'Bandung',
                'tanggal_lahir' => '1991-02-02',
                'pendidikan' => 'D3',
                'jenis_pekerjaan' => 'Ibu Rumah Tangga',
                'agama' => 'Islam',
                'alamat' => 'Jl. Sudirman No. 1, Jakarta',
            ],
            [
                'no_kk' => '1234567890123458',
                'nik' => '123456789012345890',
                'status_pernikahan' => 'Belum Kawin',
                'relationship_family' => 'Anak',
                'kewarganegaraan' => 'Indonesia',
                'nama_ayah' => 'John Doe',
                'nama_ibu' => 'Jane Doe',
                'nama' => 'John Doe III',
                'jenis_kelamin' => 'L',
                'tempat_lahir' => 'Semarang',
                'tanggal_lahir' => '2000-03-03',
                'pendidikan' => 'SMA',
                'jenis_pekerjaan' => 'Pelajar',
                'agama' => 'Islam',
                'alamat' => 'Jl. Sudirman No. 1, Jakarta',
            ],
            [
                'no_kk' => '1234567890123459',
                'nik' => '123456789012345901',
                'status_pernikahan' => 'Belum Kawin',
                'relationship_family' => 'Anak',
                'kewarganegaraan' => 'Indonesia',
                'nama_ayah' => 'John Doe',
                'nama_ibu' => 'Jane Doe',
                'nama' => 'Jane Doe III',
                'jenis_kelamin' => 'P',
                'tempat_lahir' => 'Yogyakarta',
                'tanggal_lahir' => '2002-04-04',
                'pendidikan' => 'SMP',
                'jenis_pekerjaan' => 'Pelajar',
                'agama' => 'Islam',
                'alamat' => 'Jl. Sudirman No. 1, Jakarta',
            ]
        ]);
            

    }
}
