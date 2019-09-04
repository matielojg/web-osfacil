<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Action extends Model
{

    use SoftDeletes;
    protected $table = 'actions';
    protected $fillable = [
        'description',
        'user',
        'order',
        'status'
    ];
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];
}
