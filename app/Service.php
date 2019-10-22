<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Service extends Model
{
    use SoftDeletes;
    protected $table = 'services';
    protected $fillable = ['name_service', 'sector'];
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];


    /** Order */
    public function orderService()
    {
        return $this->hasMany(Order::class, 'service', 'id');
    }

    /** Sector Provider */
    public function sectorProvider()
    {
        return $this->belongsTo(SectorProvider::class, 'sector', 'id');
    }
}
