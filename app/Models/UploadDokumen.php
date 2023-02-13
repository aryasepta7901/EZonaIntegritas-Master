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
        'file',
        'dokumenlke_id',
        'selfassessment_id',

    ];
}
