<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengawasan extends Model
{
    use HasFactory;
    protected $table = 'pengawasan_satker';
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        'id',
        'satker_id',
        'tpi_id',
        'anggota_id',
        'status',

    ];

    public function anggota()
    {
        return $this->belongsTo(User::class, 'anggota_id');
    }
    public function satker()
    {
        return $this->belongsTo(Satker::class, 'satker_id');
    }
    public function pengawasan()
    {
        return $this->hasMany(Pengawasan::class, 'anggota_id', 'anggota_id');
    }
    public function tpi()
    {
        return $this->belongsTo(TPI::class, 'tpi_id');
    }
    public function Rekapitulasi()
    {
        return $this->hasMany(Rekapitulasi::class, 'satker_id', 'satker_id');
    }
}
