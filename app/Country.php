<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'countries';

    public function event()
    {
        return $this->hasOne('\App\Event', 'iso3', 'country_code');
    }

    public function person()
    {
        return $this->hasOne('\App\People', 'iso3', 'country_code');
    }

    public function company()
    {
        return $this->hasOne('\App\Company', 'iso3', 'country_code');
    }
}
