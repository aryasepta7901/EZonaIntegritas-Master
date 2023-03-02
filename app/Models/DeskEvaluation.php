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
        'jawaban_at',
        'jawaban_kt',
        'jawaban_pt',
        'catatan_at',
        'catatan_kt',
        'catatan_pt',
        'nilai_at',
        'nilai_kt',
        'nilai_pt',
        'pengawasan_id',

    ];
    public function SelfAssessment()
    {
        return $this->belongsTo(SelfAssessment::class, 'id', 'id');
    }
}
