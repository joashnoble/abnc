<?php

namespace App\Models\ContentManagement;

use Illuminate\Database\Eloquent\Model;

class CSR extends Model
{
    protected $table = 'cms_csr';
    protected $primaryKey = 'csr_id';
    public $timestamps = false;
}
