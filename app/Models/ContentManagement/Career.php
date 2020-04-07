<?php

namespace App\Models\ContentManagement;

use Illuminate\Database\Eloquent\Model;

class Career extends Model
{
    protected $table = 'cms_careers';
    protected $primaryKey = 'career_id';
    public $timestamps = false;
}
