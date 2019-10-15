<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Order extends Model
{
    use SoftDeletes;

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
        'ancillary'
    ];
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    /** Usuario */
    public function requester()
    {
        return $this->belongsTo(Order::class, 'requester', 'id');
    }

    public function responsible()
    {
        return $this->belongsTo(Order::class, 'responsible', 'id');
    }

    public function ancillary()
    {
        return $this->belongsTo(Order::class, 'ancillary', 'id');
    }

    /** Setor */
    public function sectorRequester()
    {
        return $this->belongsTo(Order::class, 'sector_requester', 'id');
    }

    public function sectorProvider()
    {
        return $this->belongsTo(Order::class, 'sector_provider', 'id');
    }

    /** Service */
    public function service()
    {
        return $this->belongsTo(Order::class, 'service', 'id');
    }

    /** Avaliação */
    public function evaluation()
    {
        return $this->hasOne(Evaluation::class, 'order', 'id');
    }

    /**Histórico */
    public function action()
    {
        return $this->hasMany(Action::class, 'order', 'id');
    }

    /** Imagens */

    public function images()
    {
        return $this->hasMany(Image::class, 'order', 'id');
    }

}

