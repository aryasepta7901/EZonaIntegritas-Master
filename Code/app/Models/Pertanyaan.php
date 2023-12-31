<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Pertanyaan extends Model
{
    protected $table = 'pertanyaan';
    public $incrementing = false;
    use HasFactory;

    protected $fillable = [
        'id',
        'pertanyaan',
        'info',
        'bobot',
        'subpilar_id',

    ];
    public function SubPilar()
    {
        return $this->belongsTo(SubPilar::class, 'subpilar_id');
    }
    public function dokumen()
    {
        return $this->hasMany(dokumenLKE::class, 'pertanyaan_id');
    }
    public function opsi()
    {
        return $this->hasMany(Opsi::class, 'pertanyaan_id');
    }
    public function file()
    {
        return $this->hasMany(UploadDokumen::class, 'dokumenlke_id');
    }
    public function SelfAssessment()
    {
        return $this->hasMany(SelfAssessment::class, 'pertanyaan_id');
    }
}
