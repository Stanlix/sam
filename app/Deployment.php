<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Deployment extends Model
{
    protected $fillable = ['app_id', 'hash', 'branch'];

}
