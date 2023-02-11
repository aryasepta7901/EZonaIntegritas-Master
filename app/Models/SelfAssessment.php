<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SelfAssessment extends Model
{
    protected $table = 'self_assessment';
    public $incrementing = false;
    public $timestamps = true;
    use HasFactory;

    protected $fillable = [
        'id',
        'tahun',
        'opsi_id',
        'catatan',
        'nilai',
        'satker_id',
        'pertanyaan_id',

    ];
}
