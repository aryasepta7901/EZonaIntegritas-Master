<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LHE extends Model
{
    use HasFactory;
    protected $table = 'LHE';
    public $incrementing = false;

    protected $fillable = [
        'id',
        'surat_pengantar_kabkota',
        'surat_pengantar_prov',
        'surat_pengantar_LHE1',
        'surat_pengantar_LHE2',

    ];
    public function Rekapitulasi()
    {
        return $this->belongsTo(Rekapitulasi::class, 'id', 'id');
    }
}
