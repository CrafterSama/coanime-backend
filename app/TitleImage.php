<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TitleImage extends Model {
	use SoftDeletes;
	/**
	 * The table associated with the model.
	 *
	 * @var string
	 */
	protected $table = 'titles_image';
	protected $dates = ['deleted_at', 'created_at', 'updated_at'];
	protected $fillable = ['name', 'title_id'];

	public function titles() {
		return $this->belongsTo('App\Title', 'title_id', 'id');
	}
}
