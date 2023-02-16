<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pilar extends Model
{
    protected $table = 'pilar';
    public $incrementing = false;
    public $timestamps = false;
    use HasFactory;

    protected $fillable = [
        'id',
        'pilar',
        'bobot',
        'min_wbk',
        'min_wbbm',
        'subrincian_id',
    ];
    public function SubRincian()
    {
        return $this->belongsTo(SubRincian::class, 'subrincian_id');
    }
    public function Opsi()
    {
        return $this->hasMany(Opsi::class, 'pertanyaan_id');
    }
}
