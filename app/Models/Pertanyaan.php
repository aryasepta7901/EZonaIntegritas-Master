<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pertanyaan extends Model
{
    protected $table = 'pertanyaan';
    public $incrementing = false;
    public $timestamps = false;
    use HasFactory;

    public function dokumen()
    {
        return $this->hasMany(dokumenLKE::class, 'pertanyaan_id');
    }
}
