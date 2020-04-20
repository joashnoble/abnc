<?php

namespace App\Models\References;

use Illuminate\Database\Eloquent\Model;

class Industry extends Model
{
    protected $table = 'industries';
    protected $primaryKey = 'industry_id';
    public $timestamps = false;
}
