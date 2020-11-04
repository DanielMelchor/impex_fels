<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
//use Wildside\Userstamps\Userstamps;

class role_has_permission extends Model
{
    protected $table = 'role_has_permissions';
    //use Userstamps;
    public $incrementing = false;
}
