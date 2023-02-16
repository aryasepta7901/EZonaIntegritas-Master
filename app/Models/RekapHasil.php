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
}
