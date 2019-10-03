<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SectorProvider extends Model
{
    use SoftDeletes;
    protected $table = 'sector_providers';
    protected $fillable = ['name_sector'];
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];
}
