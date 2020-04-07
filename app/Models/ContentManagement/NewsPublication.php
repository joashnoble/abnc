<?php

namespace App\Models\ContentManagement;

use Illuminate\Database\Eloquent\Model;

class NewsPublication extends Model
{
    protected $table = 'cms_newspublication';
    protected $primaryKey = 'news_id';
    public $timestamps = false;
}
