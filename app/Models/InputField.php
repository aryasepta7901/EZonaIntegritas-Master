<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InputField extends Model
{
    protected $table = 'inputfield';
    public $incrementing = false;
    use HasFactory;

    protected $fillable = [
        'id',
        'input_sa',
        'input_at',
        'input_kt',
        'input_dl',
        'opsi_id',
        'selfassessment_id',

    ];
    public function SelfAssessment()
    {
        return $this->belongsTo(SelfAssessment::class, 'selfassessment_id');
    }
}
