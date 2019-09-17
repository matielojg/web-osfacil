<?php

namespace App;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;

//use Illuminate\Contracts\Auth\MustVerifyEmail;

class User extends Authenticatable
{
    //protected $guarded= [];

    use SoftDeletes;

    //use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name', 'last_name', 'document', 'email', 'username', 'password', 'function', 'sector', 'primary_contact', 'secondary_contact'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    //use SoftDeletes;

    public function responsible()
    {
        return $this->hasMany(Order::class, 'responsible', 'id');
    }
    public function requester()
    {
        return $this->hasMany(Order::class, 'requester', 'id');
    }
}

