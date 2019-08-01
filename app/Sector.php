<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sector extends Model
{
    protected $table = 'sectors';
    protected $fillable = ['name_sector', 'created_at', 'updated_at', 'active'];
    public $timestamps = false;
}
