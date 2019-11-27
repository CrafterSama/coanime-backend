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
    protected $table = 'country';

    public function event()
    {
        return $this->hasOne('\App\Event', 'code', 'country_code');
    }

    public function person()
    {
        return $this->hasOne('\App\People', 'code', 'country_code');
    }

    public function company()
    {
        return $this->hasOne('\App\Company', 'code', 'country_code');
    }
}
