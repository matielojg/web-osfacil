<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use App\Support\Cropper;

class Image extends Model
{

    protected $table = 'images';

    protected $fillable = [
        'order',
        'image'
    ];

    public function getUrlCroppedAttribute()
    {
        return Storage::url(Cropper::thumb($this->path, 1366, 768));
    }

    protected $dates = ['created_at', 'updated_at'];

    public function order()
    {
        return $this->belongsTo(Image::class, 'order', 'id');
    }
}
