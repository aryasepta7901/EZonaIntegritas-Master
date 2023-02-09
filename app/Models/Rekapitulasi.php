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
        'nilai_pengungkit',
        'nilai_hasil',
        'status',
        'satker_id',
    ];
    public function satker()
    {
        return $this->belongsTo(Satker::class, 'satker_id');
    }
}
