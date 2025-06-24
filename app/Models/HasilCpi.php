<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HasilCpi extends Model
{
    use HasFactory;

    protected $table = 'hasil_cpi';

    protected $fillable = [
        'siswa_id',
        'skor_total',
        'peringkat',
        'persentase',
        'rekomendasi'
    ];

    protected $casts = [
        'skor_total' => 'decimal:4',
        'persentase' => 'decimal:2'
    ];

    public function siswa()
    {
        return $this->belongsTo(Siswa::class, 'siswa_id');
    }

    public function getKategoriKesiapanAttribute()
    {
        if ($this->persentase >= 90) {
            return 'Sangat Siap';
        } elseif ($this->persentase >= 80) {
            return 'Siap';
        } elseif ($this->persentase >= 70) {
            return 'Cukup Siap';
        } elseif ($this->persentase >= 60) {
            return 'Kurang Siap';
        } else {
            return 'Belum Siap';
        }
    }

    public function getWarnaKategoriAttribute()
    {
        if ($this->persentase >= 90) {
            return 'success';
        } elseif ($this->persentase >= 80) {
            return 'primary';
        } elseif ($this->persentase >= 70) {
            return 'info';
        } elseif ($this->persentase >= 60) {
            return 'warning';
        } else {
            return 'danger';
        }
    }
}
