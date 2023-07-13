<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Persyaratan extends Model
{
    public $incrementing = true;
    public $timestamps = true;
    protected $table = 'persyaratan';
    use HasFactory;

    protected $fillable = [
        'id',
        'satker_id',
        'tahun',
        'wbk',
        'wbbm',

    ];

    public function satker()
    {
        return $this->belongsTo(Satker::class, 'satker_id');
    }
}
