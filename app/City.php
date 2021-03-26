<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'city';

    public function event()
    {
        return $this->belongsTo('\App\Event', 'city_id', 'id');
    }

    public function country()
    {
        return $this->belongsTo('\App\Country', 'country_code', 'code');
    }

    public function person()
    {
        return $this->hasOne('\App\People', 'city_id', 'id');
    }

    public function company()
    {
        return $this->hasOne('\App\People', 'city_id', 'id');
    }
}
