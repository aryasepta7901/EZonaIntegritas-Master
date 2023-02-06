<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Opsi extends Model
{
    use HasFactory;
    protected $table = 'opsi';
    public $incrementing = false;
    public $timestamps = false;
    protected $fillable = [
        'id',
        'rincian',
        'bobot',
        'type',
        'pertanyaan_id',

    ];

    public function pertanyaan()
    {
        return $this->belongsTo(Pertanyaan::class, 'pertanyaan_id');
    }
}
