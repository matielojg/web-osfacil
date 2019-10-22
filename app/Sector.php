<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Sector extends Model
{
    use SoftDeletes;

    protected $table = 'sectors';
    protected $fillable = ['name_sector', 'responsible'];
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    /** Ordem */
    public function orderRequester()
    {
        return $this->hasMany(Order::class, 'sector_requester', 'id');
    }

    public function orderProvider()
    {
        return $this->hasMany(Order::class, 'sector_provider', 'id');
    }

    public function userSector()
    {
        return $this->hasMany(User::class, 'sector', 'id');
    }
}
