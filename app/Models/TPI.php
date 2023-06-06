<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TPI extends Model
{
    use HasFactory;
    protected $table = 'tpi';
    public $incrementing = false;

    protected $fillable = [
        'id',
        'tahun',
        'nama',
        'dalnis',
        'ketua_tim',
        'wilayah',
    ];

    public function anggota()
    {
        return $this->hasMany(anggota_tpi::class, 'tpi_id');
    }
    public function user() //dalnis
    {
        return $this->belongsTo(User::class, 'dalnis');
    }
    public function ketua()
    {
        return $this->belongsTo(User::class, 'ketua_tim');
    }
    public function pengawasan()
    {
        return $this->hasMany(Pengawasan::class, 'tpi_id');
    }
}
