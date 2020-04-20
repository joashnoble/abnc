<?php

namespace App\Models\ContentManagement;

use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    protected $table = 'cms_team';
    protected $primaryKey = 'team_id';
    public $timestamps = false;
}
