<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    //use SoftDeletes;
    protected $table = 'orders';
    protected $fillable = [
        'requester',
        'sector_requester',
        'sector_provider',
        'service',
        'description',
        'priority',
        'status',
        'type_service',
        'responsible',
        'image'];
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    public function requester()
    {
        return $this->belongsTo(Order::class, 'requester', 'id');
    }

    public function responsible()
    {
        return $this->belongsTo(Order::class, 'responsible', 'id');
    }

}

