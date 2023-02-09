<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Satker extends Model
{
    use HasFactory;
    protected $table = 'satker';

    public function pengawasan()
    {
        return $this->hasOne(Pengawasan::class, 'satker_id');
    }
    public function persyaratan()
    {
        return $this->hasOne(Persyaratan::class, 'satker_id');
    }
    public function rekapitulasi()
    {
        return $this->belongsTo(Rekapitulasi::class, 'satker_id');
    }
}
