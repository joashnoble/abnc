<?php

namespace App\Models\Management;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $table = 'services';
    protected $primaryKey = 'service_id';
    public $timestamps = false;
}
