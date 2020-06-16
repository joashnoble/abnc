<?php

namespace App\Models\References;

use Illuminate\Database\Eloquent\Model;

class ServiceSelectType extends Model
{
    protected $table = 'services_select_type';
    protected $primaryKey = 'select_type_id';
    public $timestamps = false;
}
