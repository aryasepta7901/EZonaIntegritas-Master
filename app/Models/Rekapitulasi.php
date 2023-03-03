<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rekapitulasi extends Model
{
    protected $table = 'rekapitulasi';
    public $incrementing = false;
    public $timestamps = false;
    use HasFactory;
    protected $fillable = [
        'id',
        'tahun',
        'predikat',
        'status',
        'satker_id',
        'surat_rekomendasi',
    ];
    public function satker()
    {
        return $this->belongsTo(Satker::class, 'satker_id');
    }
    public function RekapPilar()
    {
        return $this->hasMany(RekapPilar::class, 'rekapitulasi_id');
    }
    public function StatusRekap()
    {
        return $this->belongsTo(StatusRekap::class, 'status');
    }
    public function Pengawasan()
    {
        return $this->belongsTo(Pengawasan::class, 'satker_id', 'satker_id');
    }
}
