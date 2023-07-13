<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Satker extends Model
{
    use HasFactory;

    protected $table = 'satker';
    protected $fillable = [
        'id',
        'nama_satker',
        'wilayah',
        'no_telp',
        'satker_id',
        'level_id',

    ];

    public function pengawasan()
    {
        return $this->hasOne(Pengawasan::class, 'satker_id');
    }
    public function persyaratan()
    {
        return $this->hasOne(Persyaratan::class, 'satker_id')->where('tahun', date('Y'));
    }
    public function rekapitulasi()
    {
        return $this->belongsTo(Rekapitulasi::class, 'satker_id');
    }

    public function RekapHasil()
    {
        return $this->hasOne(RekapHasil::class, 'satker_id')->where('tahun', date('Y'));
    }
}
