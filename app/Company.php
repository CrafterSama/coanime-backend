<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Company extends Model
{
    use SoftDeletes;
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'companies';
    protected $dates = ['deleted_at', 'foundation_date', 'created_at', 'updated_at'];
    protected $fillable = ['name', 'user_id', 'about', 'foundation_date', 'slug', 'country_code', 'website'];

    public function scopeSearch($query, $name)
    {
        return $query->where('name', 'like', '%' . $name . '%');
    }

    public function users()
    {
        return $this->belongsTo('\App\User', 'user_id', 'id');
    }

    public function city()
    {
        return $this->belongsTo('\App\City', 'city_id', 'id');
    }

    public function country()
    {
        return $this->belongsTo('\App\Country', 'country_code', 'iso3');
    }
}
