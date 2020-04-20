<?php

namespace App\Models\ContentManagement;

use Illuminate\Database\Eloquent\Model;

class Carousel extends Model
{
    protected $table = 'cms_carousel';
    protected $primaryKey = 'carousel_id';
    public $timestamps = false;
}
