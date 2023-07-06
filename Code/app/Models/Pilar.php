<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pilar extends Model
{
    protected $table = 'pilar';
    public $incrementing = false;
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
    public function SubPilar()
    {
        return $this->hasMany(SubPilar::class, 'pilar_id');
    }
    public function Opsi()
    {
        return $this->hasMany(Opsi::class, 'pertanyaan_id');
    }
    public function RekapPengungkit()
    {
        return $this->hasMany(RekapPengungkit::class, 'pilar_id');
    }
    public function RekapHasil()
    {
        return $this->hasMany(RekapHasil::class, 'pilar_id');
    }
}
