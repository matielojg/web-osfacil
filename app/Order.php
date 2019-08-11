<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use SoftDeletes;
    protected $table = 'orders';
    protected $fillable = ['description','active'];
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];
}
