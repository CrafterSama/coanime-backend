<?php

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Redirect;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
 */

/** Web Routes */

//Route::get('/jsondata', 'TitleController@getJsonData');

Route::get('/home', function () {
    return Redirect::to('/', 301);
});

Route::get('/page/{slug}', 'PostController@page');

Route::get('/', 'PostController@index');
Route::get('/posts', 'PostController@index')->name('blog');
Route::get('/posts/{slug}', 'PostController@show');

Route::get('/tags', 'PostController@showAllTags')->name('tags');
Route::get('/tags/{slug}', 'PostController@showAllByTag');

Route::get('/categorias', 'PostController@showAllCategories')->name('categories');
Route::get('/categorias/{slug}', 'PostController@showAllByCategory');

Route::get('/ecma', 'EncyclopediaController@index')->name('ecma');

Route::get('/eventos', 'EventController@index')->name('events');
Route::get('/eventos/{slug}', 'EventController@show');

Route::get('/users/profile/{id}', 'UserController@profile')->name('profile');
Route::get('/users/update-image', 'UserController@updateImage');

Route::group(['prefix' => 'ecma'], function () {
    Route::get('titulos', 'TitleController@index')->name('titles');
    Route::get('titulos/actualizar', 'TitleController@updateTitles')->name('update.titles');
    //Route::get('titulos/{slug}', 'TitleController@show');

    Route::get('titulos/{type}/{slug}', 'TitleController@show');
    Route::get('titulos/{type}', 'TitleController@showAllByType');

    Route::get('generos', 'TitleController@index')->name('genres');
    Route::get('generos/{slug}', 'TitleController@showAllByGenre');

    Route::get('calendario', 'TitleController@showCalendar')->name('calendar');

    Route::get('revistas', 'MagazineController@index')->name('magazine');
    Route::get('revistas/{slug}', 'MagazineController@show');

    Route::get('empresas', 'CompanyController@index')->name('companies');
    Route::get('empresas/{slug}', 'CompanyController@show');

    Route::get('personas', 'PeopleController@index')->name('people');
    Route::get('personas/{slug}', 'PeopleController@show');

    Route::get('slugs', 'PeopleController@slugs');
});


Route::group(['prefix' => 'api/v1/', 'middleware' => 'cors'], function () {
    /** Get Endpoints */
    Route::get('home', 'PostController@apiPosts');

    Route::get('article/{slug}', 'PostController@showApi');
    Route::get('articles', 'PostController@posts');
    Route::get('articles/{category}', 'PostController@postsByCategory');
    Route::get('articles/{tag}', 'PostController@postsByTag');

    Route::get('ecma', 'EncyclopediaController@api');

    Route::get('titles', 'TitleController@apiTitles');
    Route::get('titles/{type}', 'TitleController@apiTitlesByType');
    Route::get('titles/{type}/{slug}', 'TitleController@apiShowTitle');
    Route::get('titles/{type}/{slug}/posts', 'TitleController@postsTitle');

    Route::get('search/titles/{name}', 'TitleController@apiSearchTitles');
    Route::get('search/people/{name}', 'PeopleController@apiIndex');
    Route::get('search/magazine/{name}', 'MagazineController@apiIndex');
    Route::get('search/companies/{name}', 'CompanyController@apiIndex');

    Route::get('genres/{slug}', 'TitleController@apiAllByGenre');

    Route::get('people', 'PeopleController@apiIndex');
    Route::get('people/{slug}', 'PeopleController@apiShow');

    Route::get('magazine', 'MagazineController@apiIndex');
    Route::get('magazine/{slug}', 'MagazineController@apiShow');

    Route::get('companies', 'CompanyController@apiIndex');
    Route::get('companies/{slug}', 'CompanyController@apiShow');

    Route::get('profile/{slug}', 'UserController@apiProfile');
    Route::get('profile/{id}/posts', 'UserController@postsProfile');
    Route::get('profile/{id}/titles', 'UserController@titlesProfile');
    Route::get('profile/{id}/companies', 'UserController@companiesProfile');
    Route::get('profile/{id}/magazine', 'UserController@magazineProfile');
    Route::get('profile/{id}/people', 'UserController@peopleProfile');
    Route::get('profile/{id}/events', 'UserController@eventsProfile');

    Route::get('random-image', 'PostController@getRandomPostImage');
    Route::get('random-image-title/{slug}', 'PostController@getRandomPostImageByTitle');

    /** Posts Endpoints */
    Route::post('post-image-upload', 'PostController@imageUpload');
    Route::post('vote', 'PostVoteController@vote');

    /** Others API links */
    Route::get('pvu', 'PVUController@index');
});


Auth::routes();

Route::group(['middleware' => 'auth'], function () {
    Route::post('/posts/vote', 'PostVoteController@vote');

    Route::get('dashboard', 'HomeController@index')->name('admin');

    Route::group(['prefix' => 'dashboard'], function () {
        Route::group(['middleware' => 'admin'], function () {
            Route::get('settings', 'HomeController@settings')->name('config');

            Route::get('posts', 'HomeController@posts')->name('db.posts');
            Route::get('posts/borrados', 'PostController@destroyPosts');
            Route::resource('posts', 'PostController', ['except' => ['index', 'show']]);
        });

        Route::resource('users', 'UserController');

        Route::get('events', 'HomeController@events')->name('db.events');
        Route::resource('events', 'EventController', ['except' => ['index', 'show']]);

        Route::get('magazine', 'HomeController@magazine')->name('db.magazine');
        Route::resource('magazine', 'MagazineController', ['except' => ['index', 'show']]);

        Route::get('titles', 'HomeController@titles')->name('db.titles');
        Route::resource('titles', 'TitleController', ['except' => ['index', 'show']]);

        Route::get('companies', 'HomeController@companies')->name('db.companies');
        Route::resource('companies', 'CompanyController', ['except' => ['index', 'show']]);

        Route::get('people', 'HomeController@people')->name('db.people');
        Route::resource('people', 'PeopleController', ['except' => ['index', 'show']]);

        /*
        GEOLOCALIZATION API
         */
        Route::get('/geo/countries', function () {
            $countries = \App\Country::all();
            return $countries;
        });

        Route::get('/geo/cities/{code}', function ($code) {
            $cities = \App\City::where('country_code', 'like', $code)->orderBy('name', 'asc')->get();
            return $cities;
        });

        Route::get('/search/titles/{name}', function ($name) {
            $titles = \App\Title::titles($name)->select('id', 'name', 'type_id', 'other_titles')->with('images', 'type')->orderBy('name', 'asc')->get();
            return $titles;
        });
    });
});

Route::get('check-tags', 'PostController@checkTags');

Route::get('google-analytics-summary', array('as'=>'google-analytics-summary','uses'=>'HomeController@getAnalyticsSummary'));

/** All Feeds Routes **/


Route::get('feed', function () {

    // create new feed
    $feed = App::make("feed");

    // multiple feeds are supported
    // if you are using caching you should set different cache keys for your feeds

    // cache the feed for 60 minutes (second parameter is optional)
    $feed->setCache(1);

    // check if there is cached feed and build new only if is not
    if (!$feed->isCached()) {
        // creating rss feed with our most recent 20 posts
        $posts = \App\Post::where('approved', 'yes')->where('draft', '0')->where('category_id', '!=', 10)->whereRaw('TIMESTAMP(postponed_to) <= NOW()')->orWhere('postponed_to', null)->orderBy('created_at', 'desc')->take(20)->get();

        // set your feed's title, description, link, pubdate and language
        $feed->title = 'Ecma by Coanime.net';
        $feed->description = 'Feeds from http://coanime.net';
        $feed->logo = URL::to('http://coanime.net/images/logo_old.jpg');
        $feed->link = url('feed');
        $feed->setDateFormat('carbon'); // 'datetime', 'timestamp' or 'carbon'
        $feed->pubdate = $posts[0]->created_at;
        $feed->lang = 'es';
        $feed->setShortening(true); // true or false
        $feed->setTextLimit(100); // maximum length of description text

        foreach ($posts as $key => $post) {
            $image = '<img style="width:100%; position:absolute; top: 0px;left:0px;" src="' . \App\Helper::img_post($post->content) . '" />';

            //echo $image;
            // set item's title, author, url, pubdate, description, content, enclosure (optional)*
            $feed->add($post->title, $post->users->nick, URL::to('posts/' . $post->slug), $post->created_at, '', $post->content);
        }
    }
    // first param is the feed format
    // optional: second param is cache duration (value of 0 turns off caching)
    // optional: you can set custom cache key with 3rd param as string
    return $feed->render('rss', -1);

    // to return your feed as a string set second param to -1
    // $xml = $feed->render('atom', -1);
});

Route::get('telegram', function () {

    // create new feed
    $feed = App::make("feed");

    // multiple feeds are supported
    // if you are using caching you should set different cache keys for your feeds

    // cache the feed for 60 minutes (second parameter is optional)
    $feed->setCache(1);

    // check if there is cached feed and build new only if is not
    if (!$feed->isCached()) {
        // creating rss feed with our most recent 20 posts
        $posts = \App\Post::where('approved', 'yes')->where('draft', '0')->where('category_id', '!=', 10)->whereRaw('TIMESTAMP(postponed_to) <= NOW()')->orWhere('postponed_to', null)->orderBy('created_at', 'desc')->take(20)->get();

        // set your feed's title, description, link, pubdate and language
        $feed->title = 'Coanime Hoy';
        $feed->description = 'Tu sitio Web para compartir las actualizaciones de noticias acerca del mundillo del anime, manga, video juegos, Doramas, Jpop, Kpop, Kdrama y la Cultura Asiática';
        $feed->logo = URL::to('http://coanime.net/images/logo-coanime.png');
        $feed->link = url('telegram');
        $feed->setDateFormat('carbon'); // 'datetime', 'timestamp' or 'carbon'
        $feed->pubdate = $posts[0]->created_at;
        $feed->lang = 'es';
        $feed->setShortening(true); // true or false
        $feed->setTextLimit(100); // maximum length of description text

        foreach ($posts as $post) {
            // set item's title, author, url, pubdate, description, content, enclosure (optional)*
            $feed->add($post->title, $post->users->nick, URL::to('posts/' . $post->slug), $post->created_at, $post->excerpt, $post->content);
            //$feed->add($post->title, $post->users->nick, URL::to('posts/'.$post->slug), $post->created_at, '', '';
        }
    }
    // first param is the feed format
    // optional: second param is cache duration (value of 0 turns off caching)
    // optional: you can set custom cache key with 3rd param as string
    return $feed->render('rss', -1);

    // to return your feed as a string set second param to -1
    // $xml = $feed->render('atom', -1);
});


/* Route::get('/', function () {
    return view('welcome');
}); */
