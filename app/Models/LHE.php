<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LHE extends Model
{
    use HasFactory;
    protected $table = 'lhe';
    public $incrementing = false;

    protected $fillable = [
        'rekapitulasi_id',
        'surat_pengantar_kabkota',
        'surat_pengantar_prov',
        'LHE_1',
        'LHE_2',

    ];
    public function Rekapitulasi()
    {
        return $this->belongsTo(Rekapitulasi::class, 'rekapitulasi_id');
    }
}
