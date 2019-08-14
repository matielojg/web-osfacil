<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Action extends Model
{
    protected $guarded = [];
    protected $table = 'actions';
    protected $fillable = ['description'];
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];
}
