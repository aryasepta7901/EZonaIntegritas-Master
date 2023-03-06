<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RekapHasil extends Model
{
    use HasFactory;
    protected $table = 'rekaphasil';
    public $incrementing = false;
    public $timestamps = true;
    use HasFactory;
    protected $fillable = [
        'id',
        'tahun',
        'opsi_id',
        'nilai',
        'pilar_id',
        'satker_id',
    ];
    public function satker()
    {
        return $this->belongsTo(Satker::class, 'satker_id');
    }
    public function Opsi()
    {
        return $this->belongsTo(Opsi::class, 'opsi_id');
    }
    public function Pilar()
    {
        return $this->belongsTo(Pilar::class, 'pilar_id');
    }
}
