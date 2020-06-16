<?php

namespace App\Models\References;

use Illuminate\Database\Eloquent\Model;

class ServiceGroupType extends Model
{
    protected $table = 'services_group_type';
    protected $primaryKey = 'service_group_type_id';
    public $timestamps = false;
}
