<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Service extends Model
{
    use SoftDeletes;
    protected $table = 'services';
    protected $fillable = ['name_service','name_sector'];
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];
}
