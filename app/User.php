<?php

namespace App;

use App\Support\Cropper;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Storage;

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
        'first_name',
        'last_name',
        'document',
        'email',
        'username',
        'password',
        'function',
        'sector',
        'primary_contact',
        'secondary_contact'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
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

    /** Order */
    public function orderRequester()
    {
        return $this->hasMany(Order::class, 'requester', 'id');
    }

    public function orderResponsible()
    {
        return $this->hasMany(Order::class, 'responsible', 'id');
    }

    public function orderAncillary()
    {
        return $this->hasMany(Order::class, 'ancillary', 'id');
    }

    /** Action */
    public function action()
    {
        return $this->hasMany(Action::class, 'user', 'id');
    }

    /** Sector Provider */
    public function supervisor()
    {
        return $this->hasMany(SectorProvider::class, 'supervisor', 'id');
    }



    //Tratamento dos dados para salvar no banco

    public function getUrlPhotoAttribute()
    {
        if (!empty($this->photo)) {
            return Storage::url(Cropper::thumb($this->photo, 500, 500));
        }
        return '';
    }

    public function setDocumentAttribute($value)
    {
        $this->attributes['document'] = $this->clearField($value);
    }

    public function getDocumentAttribute($value)
    {
        return substr($value, 0, 3) . '.' . substr($value, 3, 3) . '.' . substr($value, 6, 3) . '-' . substr($value, 9, 2);
    }

    public function setCellAttribute($value)
    {
        $this->attributes['primary_contact'] = $this->clearField($value);
    }

    public function setTelephoneAttribute($value)
    {
        $this->attributes['secondary_contact'] = $this->clearField($value);
    }

    public function setPasswordAttribute($value)
    {
        if (empty($value)) {
            unset($this->attributes['password']);
            return;
        }

        $this->attributes['password'] = bcrypt($value);
    }

    private function clearField(?string $param)
    {
        if (empty($param)) {
            return '';
        }

        return str_replace(['.', '-', '/', '(', ')', ' '], '', $param);

    }
}

