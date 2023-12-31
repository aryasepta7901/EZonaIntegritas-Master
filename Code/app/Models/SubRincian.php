<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubRincian extends Model
{

    protected $table = 'subrincian';
    public $incrementing = false;
    use HasFactory;

    protected $fillable = [
        'id',
        'subRincian',
        'bobot',
        'rincian_id',
    ];
    public function pilar()
    {
        return $this->hasMany(Pilar::class, 'subrincian_id');
    }
    public function Rincian()
    {
        return $this->belongsTo(Rincian::class, 'rincian_id');
    }
}
