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
        'filter_sector_provider',    //sector_provider
        'service',
        'description',
        'priority',
        'status',
        'type_service',
        'responsible',
        'ancillary'
    ];
    protected $dates = ['closed_at', 'created_at', 'updated_at', 'deleted_at'];

    /** Usuario */
    public function userRequester()
    {
        return $this->belongsTo(User::class, 'requester', 'id');
        //return $this->belongsTo(Order::class, 'requester', 'id');
    }

    public function userResponsible()
    {
        return $this->belongsTo(User::class, 'responsible', 'id');
        //return $this->belongsTo(Order::class, 'responsible', 'id');
    }

    public function technicianAncillary()
    {
        //return $this->belongsTo(Order::class, 'ancillary', 'id');
        return $this->belongsTo(User::class, 'ancillary', 'id');
    }

    /** Setor */
    public function sectorRequester()
    {
        return $this->belongsTo(Sector::class, 'sector_requester', 'id');
    }

    public function sectorProvider()
    {
        return $this->belongsTo(SectorProvider::class, 'sector_provider', 'id');
    }

    /** Service */
    public function serviceProvider()
    {
        return $this->belongsTo(Service::class, 'service', 'id');
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

