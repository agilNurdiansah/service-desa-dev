<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterResident extends Model
{
    use HasFactory;


    protected $fillable = [
        'no_kk',
        'nik',
        'status_pernikahan',
        'relationship_family',
        'kewarganegaraan',
        'nama_ayah',
        'nama_ibu',
        'nama',
        'jenis_kelamin',
        'tempat_lahir',
        'tanggal_lahir',
        'pendidikan',
        'jenis_pekerjaan',
        'agama',
        'alamat',
    ];
    
}
