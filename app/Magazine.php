<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Magazine extends Model {
	use SoftDeletes;
	/**
	 * The table associated with the model.
	 *
	 * @var string
	 */
	protected $table = 'magazines';
	protected $dates = ['deleted_at', 'foundation_date', 'created_at', 'updated_at'];
	protected $fillable = ['name', 'user_id', 'about', 'foundation_date', 'slug', 'type_id', 'release_id', 'country_code', 'website'];

	public function scopeSearch($query, $name) {
        if (strlen($name) > 1) :
            return $query->where('name', 'like', '%' . $name . '%');
        else:
            return $query->where('name', 'like', $name . '%');
        endif;
	}

	public function country() {
        return $this->belongsTo('\App\Country', 'country_code', 'code');
    }

	public function type() {
		return $this->belongsTo('\App\MagazineType');
	}

	public function release() {
		return $this->belongsTo('\App\MagazineRelease');
	}

	public function users() {
		return $this->belongsTo('\App\User', 'user_id', 'id');
	}

	public function image() {
		return $this->hasOne('\App\MagazineImage');
	}

}
