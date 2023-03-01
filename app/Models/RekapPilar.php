<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RekapPilar extends Model
{
    use HasFactory;
    protected $table = 'rekappilar';
    public $incrementing = false;
    public $timestamps = true;
    use HasFactory;
    protected $fillable = [
        'id',
        'nilai_sa', // self assessment
        'nilai_at', //anggota Tim
        'nilai_kt', //ketua tim
        'nilai_pt', //pengandali teknis
        'rekapitulasi_id',
        'pilar_id',

    ];
    public function Rekapitulasi()
    {
        return $this->belongsTo(Rekapitulasi::class, 'rekapitulasi_id');
    }
}
