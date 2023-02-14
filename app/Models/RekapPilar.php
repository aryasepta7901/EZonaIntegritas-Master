<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RekapPilar extends Model
{
    use HasFactory;
    protected $table = 'rekappilar';
    public $incrementing = false;
    public $timestamps = true;
    use HasFactory;
    protected $fillable = [
        'id',
        'nilai',
        'rekapitulasi_id',
        'pilar_id',

    ];
}
