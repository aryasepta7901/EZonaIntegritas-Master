<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class dokumenLKE extends Model
{
    protected $table = 'dokumenlke';
    public $incrementing = false;
    use HasFactory;

    protected $fillable = [
        'id',
        'dokumen',
        'pertanyaan_id',

    ];
    public function pertanyaan()
    {
        return $this->belongsTo(Pertanyaan::class, 'pertanyaan_id');
    }
    public function file()
    {
        return $this->hasMany(UploadDokumen::class, 'dokumenlke_id');
    }
}
