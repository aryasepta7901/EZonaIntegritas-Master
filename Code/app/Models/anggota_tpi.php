<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Tpi;

class anggota_tpi extends Model
{
    use HasFactory;
    protected $table = 'anggota_tpi';
    public $incrementing = true;

    protected $fillable = [
        'id',
        'tpi_id',
        'anggota_id',

    ];

    public function tpi()
    {
        return $this->belongsTo(TPI::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'anggota_id');
    }
    public function pengawasan()
    {
        return $this->hasMany(Pengawasan::class, 'anggota_id', 'anggota_id');
    }
}
