<?php

namespace App;

use App\Support\Cropper;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Image extends Model
{
    protected $table = 'images';
    protected $dates = ['created_at', 'updated_at'];
    protected $fillable = [
        'order',
        'image'
    ];


/** Order */
    public function order()
    {
        return $this->belongsTo(Order::class, 'order', 'id');
    }

    /** Metodo cropp (thumb) para imagens */
    public function getUrlCroppedAttribute()
    {
        return Storage::url(Cropper::thumb($this->path, 1366, 768));
    }

}


