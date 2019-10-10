<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SectorProvider extends Model
{
    use SoftDeletes;
    protected $table = 'sector_providers';
    protected $fillable = ['name_sector','supervisor'];
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    /** Service */
    public function service()
    {
        return $this->hasMany(Service::class, 'sector', 'id');
    }
    /** User */
    public function supervisor()
    {
        return $this->belongsTo(User::class, 'supervisor', 'id');
    }


}
