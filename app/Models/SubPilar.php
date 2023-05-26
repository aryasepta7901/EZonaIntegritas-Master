<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubPilar extends Model
{
    protected $table = 'subpilar';
    public $incrementing = false;
    use HasFactory;

    protected $fillable = [
        'id',
        'subPilar',
        'bobot',
        'pilar_id',
    ];
    public function Pilar()
    {
        return $this->belongsTo(Pilar::class, 'pilar_id');
    }
    public function pertanyaan()
    {
        return $this->hasMany(Pertanyaan::class, 'subpilar_id');
    }
}
