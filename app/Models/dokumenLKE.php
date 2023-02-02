<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class dokumenLKE extends Model
{
    protected $table = 'dokumenlke';
    public $incrementing = false;
    public $timestamps = false;
    use HasFactory;

    public function pertanyaan()
    {
        return $this->belongsTo(Pertanyaan::class, 'pertanyaan_id');
    }
}
