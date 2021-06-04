<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    use SoftDeletes;
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $dates = ['deleted_at', 'created_at', 'updated_at', 'birthday'];
    protected $fillable = [
        'name', 'email', 'password', 'bio', 'nick', 'twitter', 'facebook', 'pinterest', 'instagram', 'devianart', 'googleplus', 'behance', 'tumblr', 'website', 'genre', 'birthday', 'slug'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function companies()
    {
        return $this->hasMany('\App\Company')->orderBy('id', 'desc');
    }

    public function events()
    {
        return $this->hasMany('\App\Event')->orderBy('id', 'desc');
    }

    public function magazine()
    {
        return $this->hasMany('\App\Magazine')->orderBy('id', 'desc');
    }

    public function people()
    {
        return $this->hasMany('\App\People')->orderBy('id', 'desc');
    }

    public function posts()
    {
        return $this->hasMany('\App\Post')->where('approved', 'yes')->whereRaw('TIMESTAMP(postponed_to) <= NOW()')->orWhere('postponed_to', NULL)->orderBy('id', 'desc');
    }

    public function titles()
    {
        return $this->hasMany('\App\Title')->orderBy('id', 'desc');
    }

    public function roles()
    {
        return $this->belongsTo('\App\Role', 'role_id', 'id');
    }

    public function isAdmin()
    {
        if ($this->roles->name == 'Administrator') {
            return true;
        }
    }

    public function isMod()
    {
        if ($this->roles->name == 'Moderator') {
            return true;
        }
    }
}
