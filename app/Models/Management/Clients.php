<?php

namespace App\Models\Management;

use Illuminate\Database\Eloquent\Model;

class Clients extends Model
{
    protected $table = 'clients';
    protected $primaryKey = 'client_id';
    public $timestamps = false;
}
