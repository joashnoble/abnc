<?php

namespace App\Models\Management;

use Illuminate\Database\Eloquent\Model;

class ServiceItems extends Model
{
    protected $table = 'service_items';
    protected $primaryKey = 'service_item_id';
    public $timestamps = false;
}
