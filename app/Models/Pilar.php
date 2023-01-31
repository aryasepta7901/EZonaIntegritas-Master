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
}
