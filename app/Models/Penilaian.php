<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penilaian extends Model
{
    use HasFactory;

    protected $table = 'penilaian';

    protected $fillable = [
        'siswa_id',
        'kriteria_id',
        'nilai_mentah',
        'nilai_normalisasi',
        'nilai_terbobot'
    ];

    protected $casts = [
        'nilai_mentah' => 'decimal:2',
        'nilai_normalisasi' => 'decimal:2',
        'nilai_terbobot' => 'decimal:2'
    ];

    public function siswa()
    {
        return $this->belongsTo(Siswa::class, 'siswa_id');
    }

    public function kriteria()
    {
        return $this->belongsTo(Kriteria::class, 'kriteria_id');
    }
}
