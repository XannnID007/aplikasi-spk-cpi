<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Siswa extends Model
{
    use HasFactory;

    protected $table = 'siswa';

    protected $fillable = [
        'kode',
        'nama',
        'jenis_kelamin',
        'tanggal_lahir',
        'nama_orang_tua',
        'alamat'
    ];

    protected $casts = [
        'tanggal_lahir' => 'date'
    ];

    public function penilaian()
    {
        return $this->hasMany(Penilaian::class, 'siswa_id');
    }

    public function hasilCpi()
    {
        return $this->hasOne(HasilCpi::class, 'siswa_id');
    }

    public function getUmurAttribute()
    {
        return $this->tanggal_lahir ? $this->tanggal_lahir->age : null;
    }
}
