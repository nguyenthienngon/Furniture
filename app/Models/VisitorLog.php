<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VisitorLog extends Model
{

    protected $fillable = ['ip_address', 'user_agent'];
}
