<?php

namespace App\Models\ContentManagement;

use Illuminate\Database\Eloquent\Model;

class Seminar extends Model
{
    protected $table = 'cms_seminars';
    protected $primaryKey = 'seminar_id';
    public $timestamps = false;
}
