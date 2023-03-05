<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RekapPengungkit extends Model
{
    use HasFactory;
    protected $table = 'rekappengungkit';
    public $incrementing = false;
    public $timestamps = true;
    use HasFactory;
    protected $fillable = [
        'id',
        'nilai_sa', // self assessment
        'nilai_at', //anggota Tim
        'nilai_kt', //ketua tim
        'nilai_dl', //pengandali teknis
        'rekapitulasi_id',
        'pilar_id',

    ];
    public function Rekapitulasi()
    {
        return $this->belongsTo(Rekapitulasi::class, 'rekapitulasi_id');
    }
    public function Pilar()
    {
        return $this->belongsTo(Pilar::class, 'pilar_id');
    }
}
