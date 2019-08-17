<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Contact extends Model
{

    //use SoftDeletes;

    protected $table = 'contacts';
    protected $fillable = ['primary_contact', 'secondary_contact'];
    protected $dates = ['created_at', 'updated_at'];

    public function user()
    {
        return $this->belongsTo(User::class);

    }
}
