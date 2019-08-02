<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Sector extends Model
{
    use SoftDeletes;
    protected $table = 'sectors';
    protected $fillable = ['name_sector','active'];
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];
    }
