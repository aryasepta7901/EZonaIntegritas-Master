<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UploadDokumen extends Model
{
    use HasFactory;
    protected $table = 'upload_dokumen';
    public $incrementing = false;
    public $timestamps = true;

    protected $fillable = [
        'id',
        'name',
        'file',
        'dokumenlke_id',
        'selfassessment_id',

    ];
    public function dokumenLKE()
    {
        return $this->belongsTo(dokumenLKE::class, 'dokumenlke_id');
    }
    public function pertanyaan()
    {
        return $this->belongsTo(Pertanyaan::class, 'dokumenlke_id');
    }
}
