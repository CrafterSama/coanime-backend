<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use SoftDeletes;

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at', 'created_at', 'updated_at', 'postponed_to'];

    protected $fillable = ['title', 'excerpt', 'content', 'category_id', 'user_id', 'slug', 'approved', 'draft', 'image', 'postponed_to', 'created_at'];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'posts';

    public function scopeSearch($query, $name)
    {
        return $query->where('title', 'like', '%' . $name . '%')
            ->orWhere('excerpt', 'like', '%' . $name . '%')
            ->orWhere('content', 'like', '%' . $name . '%');
    }

    public function fullContent($id)
    {
        $post = Post::find($id);
        $intro = $post->intro;
        $content = $post->content;
        $post = $intro . $content;

        //dd($post);
        return $post;
    }

    public function users()
    {
        return $this->belongsTo('\App\User', 'user_id', 'id');
    }

    public function categories()
    {
        return $this->belongsTo('\App\Category', 'category_id', 'id')->select(array('id', 'name', 'slug'));
    }

    public function tags()
    {
        return $this->belongsToMany('App\Tag');
    }

    public function titles()
    {
        return $this->belongsToMany('App\Title')->with('images', 'type', 'users', 'generes', 'posts');
    }

    public static function getByTitle($id)
    {
        return \DB::table('posts')
            ->join('users', 'users.id', '=', 'posts.user_id')
            ->join('categories', 'categories.id', '=', 'posts.category_id')
            ->join('post_tag', 'post_tag.post_id', '=', 'posts.id')
            ->join('tags', 'post_tag.tag_id', '=', 'tags.id')
            ->where('tags.id', '=', $id)
            ->select(
                'posts.*',
                'tags.name as tag_name',
                'tags.slug as tag_slug',
                'tags.id as tag_id',
                'users.name as user_name',
                'users.slug as user_slug',
                'categories.name as category_name',
                'categories.slug as category_slug'
            );
    }
}
