<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Title extends Model
{
    use SoftDeletes;

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at', 'broad_finish', 'broad_time', 'created_at', 'updated_at'];
    protected $fillable = ['name', 'user_id', 'episodies', 'sinopsis', 'slug', 'type_id', 'other_titles', 'trailer_url', 'status', 'rating_id', 'broad_time', 'broad_finish', 'updated_by', 'just_year'];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'titles';

    public function scopeSearch($query, $name)
    {
        return $query->where('name', 'like', $name . '%')
            ->orWhere('other_titles', 'like', $name . '%')
            ->orWhere('sinopsis', 'like', $name . '%');
    }

    public static function scopeTitles($query, $name)
    {
        return $query->where('name', 'like', $name . '%')
            ->orWhere('other_titles', 'like', $name . '%');
    }

    /*public function scopeByGenre($genre, $query) {
        return $query->whereHas('Genre', function ($q) use ($genre) {
            $q->where('genre_id', $genre->id);
        });
    }*/

    public function images()
    {
        return $this->hasOne('App\TitleImage');
    }

    public function users()
    {
        return $this->belongsTo('App\User', 'user_id', 'id');
    }

    public function rating()
    {
        return $this->belongsTo('App\Ratings');
    }

    public function type()
    {
        return $this->belongsTo('App\TitleType');
    }

    public function genres()
    {
        return $this->belongsToMany('App\Genre');
    }

    public function posts()
    {
        return $this->belongsToMany('App\Post')->orderBy('id', 'desc');
    }

    public function relateds()
    {
        return $this->hasMany('App\Related');
    }

    public function getFirstDateAttribute()
    {
        return $this->broad_time->format('d/m/Y');
    }

    public function getFirstDateYearAttribute()
    {
        return $this->broad_time->format('Y');
    }

    public function getLastDateAttribute()
    {
        return $this->broad_finish->format('d/m/Y');
    }

    public function getLastDateYearAttribute()
    {
        return $this->broad_finish->format('Y');
    }
}
