<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StatusRekap extends Model
{
    protected $table = 'status_rekap';
    public $incrementing = true;
    use HasFactory;
    protected $fillable = [
        'id',
        'status',

    ];
    public function Rekapitulasi()
    {
        return $this->hasMany(Rekapitulasi::class, 'status');
    }
}
