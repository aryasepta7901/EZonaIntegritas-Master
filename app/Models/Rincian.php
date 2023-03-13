<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rincian extends Model
{

    protected $table = 'rincian';
    public $incrementing = false;
    public $timestamps = false;
    use HasFactory;

    protected $fillable = [
        'id',
        'rincian',
        'bobot',
    ];
    public function SubRincian()
    {
        return $this->hasMany(SubRincian::class, 'rincian_id');
    }
}
