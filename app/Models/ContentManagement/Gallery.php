<?php

namespace App\Models\ContentManagement;

use Illuminate\Database\Eloquent\Model;

class Gallery extends Model
{
    protected $table = 'cms_gallery';
    protected $primaryKey = 'gallery_id';
    public $timestamps = false;
}
