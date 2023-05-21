<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeskEvaluation extends Model
{
    protected $table = 'desk_evaluation';
    public $incrementing = false;
    public $timestamps = true;
    use HasFactory;

    protected $fillable = [
        'id',
        'rekapitulasi_id',
        'jawaban_at',
        'jawaban_kt',
        'jawaban_dl',
        'catatan_at',
        'catatan_kt',
        'catatan_dl',
        'nilai_at',
        'nilai_kt',
        'nilai_dl',
        'pengawasan_id',

    ];
    public function SelfAssessment()
    {
        return $this->belongsTo(SelfAssessment::class, 'id', 'id');
    }
    public function InputField()
    {
        return $this->hasMany(InputField::class,  'selfassessment_id', 'id');
    }
}
