<?php

namespace App\Models\References;

use Illuminate\Database\Eloquent\Model;

class ServiceType extends Model
{
    protected $table = 'services_type';
    protected $primaryKey = 'service_type_id';
    public $timestamps = false;
}
