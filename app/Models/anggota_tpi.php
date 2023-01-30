<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Tpi;

class anggota_tpi extends Model
{
    use HasFactory;
    protected $table = 'anggota_tpi';
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        'tpi_id',
        'anggota',
        'jumlah_satker',

    ];

    public function tpi()
    {
        return $this->belongsTo(TPI::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'anggota');
    }
}
