<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Rating extends Model
{
    use SoftDeletes;
    protected $table = 'ratings';
    protected $guarded =  [];
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];
}
