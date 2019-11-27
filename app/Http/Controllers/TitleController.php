<?php

namespace App\Http\Controllers;

use Alert;
use App\Genere;
use App\Ratings;
use App\Tag;
use App\Title;
use App\TitleImage;
use App\TitleType;
use App\User;
use App\Category;
use App\Company;
use App\Magazine;
use App\People;
use App\Post;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TitleController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $titles = Title::search($request->name)->with('images', 'rating', 'type', 'generes')->orderBy('name', 'asc')->get();
            return $titles;
        } else {
            if ($titles = Title::search($request->name)->with('images', 'rating', 'type', 'generes')->orderBy('name', 'asc')->simplePaginate()) :
                $types = TitleType::orderBy('name', 'asc')->get();
                $genres = Genere::orderBy('name', 'asc')->get();

                return view('titles.home', compact('titles', 'types', 'genres'));
            else :
                \Alert::error('No se ha podido acceder a los datos de la aplicacion');
                return back();
            endif;
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $types = TitleType::pluck('name', 'id');
        $generes = Genere::pluck('name', 'id');
        $ratings = Ratings::pluck('name', 'id');
        return view('dashboard.titles.create', compact('generes', 'ratings', 'types'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (Title::where('name', '=', $request->get('name'))->where('type_id', '=', $request->get('type_id'))->count() > 0) :
            \Alert::error('La serie que trata de guardar ya esta en nuestros archivos');
            return back();
        else :
            $this->validate($request, [
                'name' => 'required',
                'other_titles' => 'required',
                'type_id' => 'required',
                'sinopsis' => 'required',
                'episodies' => 'numeric',
                'just_year' => 'required',
                'broad_time' => 'required|date_format:"Y-m-d H:i:s"',
                'broad_finish' => 'date_format:"Y-m-d H:i:s"',
                'genere_id' => 'required',
                'rating_id' => 'required',
                'image-client' => 'required|max:1024|mimes:jpeg,gif,bmp,png|dimensions:min_width=300,min_height=400',
            ]);

            if (empty($request['broad_finish'])) :
                $request['broad_finish'] = null;
            endif;

            if (empty($request['episodies'])) :
                $request['episodies'] = '0';
            endif;

            $data = new Title;

            $file = $request->file('image-client');

            //Creamos una instancia de la libreria instalada
            $image = \Image::make($request->file('image-client')->getRealPath());

            //Ruta donde queremos guardar las imagenes
            $originalPath = public_path() . '/images/encyclopedia/titles/';

            //Ruta donde se guardaran los Thumbnails
            $thumbnailPath = public_path() . '/images/encyclopedia/titles/thumbnails/';

            $tName = TitleType::find($request['type_id']);

            // Guardar Original
            $fileName = hash('sha256', str_slug($request['name']) . strval(time()));

            $watermark = \Image::make(public_path() . '/images/logo_homepage.png');

            $watermark->opacity(30);

            if (($image->width() * .20) < 300) {
                if (($image->width() * .20) < 150) {
                    $watermark->resize(100, null, function ($constraint) {
                        $constraint->aspectRatio();
                    });
                } else {
                    $watermark->resize(($image->width() * .20), null, function ($constraint) {
                        $constraint->aspectRatio();
                    });
                }
            }

            $image->insert($watermark, 'bottom-right', 10, 10);

            $image->save($originalPath . $fileName . '.jpg');

            // Cambiar de tamaño Tomando en cuenta el radio para hacer un thumbnail
            $image->resize(300, null, function ($constraint) {
                $constraint->aspectRatio();
            });
            // Guardar
            $image->save($thumbnailPath . 'thumb-' . $fileName . '.jpg');

            $request['user_id'] = \Auth::user()->id;
            $request['slug'] = str_slug($request['name']);

            if (Title::where('slug', '=', $request['slug'])->where('type_id', '=', $request['type_id'])->count() > 0) :
                $request['slug'] = str_slug($request['name']) . '-01';
            endif;

            $request['images'] = 'https://coanime.net/images/encyclopedia/titles/' . $fileName . '.jpg';
            $request['thumbnail'] = 'https://coanime.net/images/encyclopedia/titles/thumbnails/thumb-' . $fileName . '.jpg';

            $data = $request->all();

            if ($data = Title::create($data)) :
                $images = $data->images ?: new TitleImage;
                $images->name = $request['images'];
                $images->thumbnail = $request['thumbnail'];
                $data->images()->save($images);
                $data->generes()->sync($request['genere_id']);
                \Alert::success('Titulo Agregado');
                return redirect()->to('dashboard/titles');
            else :
                \Alert::error('No se ha podido guardar la Informacion Suministrada');
                return back();
            endif;
        endif;
    }

    /**
     * Display the specified resource.
     *
     * @param  str  $type
     * @param  str  $slug
     * @return \Illuminate\Http\Response
     */
    public function show($type, $slug)
    {

        $type_id = TitleType::where('slug', '=', $type)->pluck('id');

        $title = Title::where('slug', '=', $slug)->where('type_id', $type_id);

        if ($title->count() > 0) {
            $id = $title->pluck('id');
            $title = Title::with('images', 'rating', 'type', 'generes', 'users', 'posts')->find($id);


            return view('titles.details', ['title' => $title]);
        } else {
            return view('errors.404');
        }
    }

    /**
     * Get all items of the resource by type.
     *
     * @param  str  $type
     * @return \Illuminate\Http\Response
     */
    public function showAllByType($type)
    {
        $type_id = TitleType::where('slug', 'like', $type)->pluck('id');
        $id = Title::where('type_id', $type_id)->pluck('id');
        $titles = Title::where('type_id', $type_id)->with('images', 'rating', 'type', 'generes')->orderBy('name', 'asc')->simplePaginate(12);
        $types = TitleType::orderBy('name', 'asc')->get();
        $genres = Genere::orderBy('name', 'asc')->get();

        return view('titles.home', compact('titles', 'types', 'genres'));
    }

    /**
     * Get all the genre.
     *
     */
    public function showAllGenre()
    {

        $genre = Genere::orderBy('name', 'asc')->get();

        return view('genres.home', compact('genre'));
    }


    /**
     * Get all items of the resource by genre.
     *
     * @param  str  $genre
     * @return \Illuminate\Http\Response
     */
    public function showAllByGenre($genre)
    {

        $genre_id = Genere::where('slug', 'like', $genre)->pluck('id');

        $titles = Title::whereHas('generes', function ($q) use ($genre_id) {
            $q->where('genere_id', $genre_id);
        })->with('images', 'rating', 'type', 'generes')->orderBy('name', 'asc')->simplePaginate(12);

        $genres = Genere::orderBy('name', 'asc')->get();

        $types = TitleType::orderBy('name', 'asc')->get();

        return view('titles.home', compact('titles', 'genres', 'types'));
    }

    public function getAllBySearch(Request $request)
    {
        $titles = \App\Title::search($request->name)->with('images', 'rating', 'type', 'generes')->orderBy('name', 'asc')->get();
        return $titles;
    }

    /**
     * Get the Titles in JSON Format from th API.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return Illuminate\Http\JsonResponse
     */
    public function apiTitles(Request $request)
    {

        $titles = \App\Title::search($request->name)->with('images', 'rating', 'type', 'generes', 'users', 'posts')->orderBy('name', 'asc')->paginate(10);

        return response()->json(array(
            'title' => 'Coanime.net - Titulos',
            'descripcion' => 'Títulos de la Enciclopedia, estos estan compuestos por títulos de TV, Mangas, Peliculas, Lives Actions, Doramas, Video Juegos, entre otros',
            'path_image_url' => 'https://coanime.net/images/encyclopedia/titles/',
            'result' => $titles
        ), 200);
    }

    public function apiShowTitle($type, $slug)
    {
        $type_id = TitleType::where('slug', '=', $type)->pluck('id');
        $title = Title::where('slug', '=', $slug)->where('type_id', $type_id);

        if ($title->count() > 0) {
            $id = $title->pluck('id');
            $title = Title::with('images', 'rating', 'type', 'generes', 'users', 'posts')->find($id);
            return response()->json(array(
                'message' => 'OK',
                'data' => $title
            ), 200);
        } else {
            return response()->json(array('message' => 'Not Found!'), 404);
        }
    }

    public function postsTitle($type, $slug)
    {
        $tag_id = Tag::where('slug', '=', $slug)->pluck('id');

        /* $posts = Post::whereHas('tags', function ($q) use ($tag_id) {
            $q->where('tag_id', $tag_id);
        })->get(); */

        //return $tag_id;
        if ($tag_id->count() > 0) :

            $query = Post::getByTitle($tag_id);

            if (!empty($tag_id) && $query->count() > 0) :
                $posts = $query->orderBy('posts.postponed_to', 'desc')->simplePaginate();
                return response()->json(array(
                    'message' => 'OK',
                    'quantity' => $posts->count(),
                    'data' => $posts,
                ), 200);
            else :
                return response()->json(array(
                    'message' => 'Not Found!'
                ), 404);
            endif;
        else :
            return response()->json(array(
                'message' => 'Not Found'
            ), 404);
        endif;
        /* return view('web.home', compact('posts')); */
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {

        $title = Title::with('images', 'rating', 'type', 'generes', 'users')->find($id);
        $types = TitleType::pluck('name', 'id');
        $generes = Genere::orderBy('name', 'asc')->pluck('name', 'id');
        $ratings = Ratings::pluck('name', 'id');
        $selected = $title->generes()->pluck('genere_id')->toArray();

        return view('dashboard.titles.create', compact('generes', 'ratings', 'types', 'title', 'selected'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required',
            'other_titles' => 'required',
            'type_id' => 'required',
            'sinopsis' => 'required',
            'episodies' => 'numeric',
            'just_year' => 'required',
            'broad_time' => 'required|date_format:"Y-m-d H:i:s"',
            'broad_finish' => 'date_format:"Y-m-d H:i:s"',
            'genere_id' => 'required',
            'rating_id' => 'required',
            'image-client' => 'max:1024|mimes:jpeg,gif,bmp,png|dimensions:min_width=300,min_height=400',
        ]);

        if (empty($request['broad_finish'])) :
            $request['broad_finish'] = null;
        endif;

        if (empty($request['episodies'])) :
            $request['episodies'] = '0';
        endif;

        $data = Title::find($id);

        if ($request->file('image-client')) :
            $file = $request->file('image-client');
            //Creamos una instancia de la libreria instalada
            $image = \Image::make($request->file('image-client')->getRealPath());
            //Ruta donde queremos guardar las imagenes
            $originalPath = public_path() . '/images/encyclopedia/titles/';
            //Ruta donde se guardaran los Thumbnails
            $thumbnailPath = public_path() . '/images/encyclopedia/titles/thumbnails/';
            $tName = $data->type->name;
            // Guardar Original
            $fileName = hash('sha256', str_slug($request['name']) . strval(time()));

            $watermark = \Image::make(public_path() . '/images/logo_homepage.png');

            $watermark->opacity(30);

            if (($image->width() * .20) < 300) {
                if (($image->width() * .20) < 150) {
                    $watermark->resize(100, null, function ($constraint) {
                        $constraint->aspectRatio();
                    });
                } else {
                    $watermark->resize(($image->width() * .20), null, function ($constraint) {
                        $constraint->aspectRatio();
                    });
                }
            }

            $image->insert($watermark, 'bottom-right', 10, 10);

            $image->save($originalPath . $fileName . '.jpg');

            // Cambiar de tamaño Tomando en cuenta el radio para hacer un thumbnail
            $image->resize(300, null, function ($constraint) {
                $constraint->aspectRatio();
            });
            // Guardar
            $image->save($thumbnailPath . 'thumb-' . $fileName . '.jpg');

            $request['images'] = 'https://coanime.net/images/encyclopedia/titles/' . $fileName . '.jpg';
            $request['thumbnail'] = 'https://coanime.net/images/encyclopedia/titles/thumbnails/thumb-' . $fileName . '.jpg';
        else :
            $request['images'] = null;
            $request['thumbnail'] = null;
        endif;

        $request['user_id'] = $data['user_id'];
        $request['edited_by'] = \Auth::user()->id;
        $request['slug'] = str_slug($request['name']);

        //dd($request);

        if ($data->update($request->all())) :

            if ($request->file('image-client')) :
                if (TitleImage::where('title_id', $id)->count() > 0) :
                    $images = $data->images ?: TitleImage::where('title_id', $id);
                else :
                    $images = $data->images ?: new TitleImage;
                endif;
                $images->name = $request['images'];
                $images->thumbnail = $request['thumbnail'];
                $data->images()->save($images);
            endif;
            $data->generes()->sync($request['genere_id']);
            \Alert::success('Titulo Actualizado');
            return redirect()->to('dashboard/titles');
        else :
            \Alert::error('No se ha podido guardar la Informacion Suministrada');
            return back();
        endif;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $title = Title::find($id);

        if ($title->delete()) :
            \Alert::success('El Titulo se ha Eliminado satisfactoriamente');
            return back();
        else :
            \Alert::error('El Post no se ha podido Eliminar');
            return back();
        endif;
    }

    public function name()
    {

        $title = Title::where('name', 'like', '%' . $value . '%')->get();
        return view('titles.details', ['title', $title]);
    }

    public function slugs()
    { }

    public function showCalendar()
    {
        $carbon = new Carbon;
        $titles = Title::orderBy('id', 'desc')->get();
        $people = People::orderBy('id', 'desc')->get();
        $magazine = Magazine::orderBy('id', 'desc')->get();
        $companies = Company::orderBy('id', 'desc')->get();

        return view('calendar.home', compact('titles', 'people', 'companies', 'magazine', 'carbon', 'legion'));
    }

    public function getJsonData(Request $request)
    {
        /* $url = 'http://www.ecma.animekaigen.xyz/api/content?cuantos=' . $request->get('a') . '&buscar=&ordenado=0&iniciar=' . $request->get('b'); */
        $url = 'http://www.ecma.animekaigen.xyz/api/content?cuantos=200&buscar=&ordenado=0&iniciar=1200';
        $content = file_get_contents($url);
        $json = json_decode($content, true);

        $data = [];

        $i = 1200;
        foreach ($json as $j) {
            $jdata = $j['response']['anime'];
            $find = [' (Latino)', ' (TV)', ' (latino)', ' (2011)', ' (2012)', ' (2010)', ' (2013)', ' (2014)', ' (2015)', ' (2016)', ' (2017)', ' (2018)', ' (2019)', ' (Sub-Inglés)', ' (Castellano)', ' (Movie)', ' latino', ' Latino', ' Movie', ' Castellano', ' Ova', ' ( )', ' ()'];
            $replace = ['', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''];
            $data['name'] = str_replace($find, $replace, $jdata['nombre']);
            $data['name'] = str_replace($find, $replace, $jdata['nombre']);
            $data['slug'] = str_slug($jdata['nombre']);
            $data['sinopsis'] = $jdata['sinopsis'];
            $data['episodies'] = $jdata['episodios'];
            $data['status'] = $jdata['estatus'];

            if (!empty($jdata['japones']) && !empty($jdata['nombre_alternativo'])) {
                $data['other_titles'] = $jdata['japones'] . '(Japonés),' . $jdata['nombre_alternativo'] . '(Sinonimo)';
            } elseif (!empty($jdata['japones']) && empty($jdata['nombre_alternativo'])) {
                $data['other_titles'] = $jdata['japones'] . '(Japonés)';
            } elseif (empty($jdata['japones']) && !empty($jdata['nombre_alternativo'])) {
                $data['other_titles'] = $jdata['nombre_alternativo'] . '(Sinonimo)';
            }

            $data['episodies'] = $jdata['episodios'];

            $data['user_id'] = 1;
            if ($jdata['tipo'] == 'Anime') {
                $data['type_id'] = 1;
            }
            if ($jdata['tipo'] == 'Película') {
                $data['type_id'] = 3;
            }
            if ($jdata['tipo'] == 'Ova') {
                $data['type_id'] = 4;
            }
            if ($jdata['tipo'] == 'Ona') {
                $data['type_id'] = 10;
            }

            $type_name = ['Aventuras', 'Comedia', 'Romance', 'Drama', 'Ciencia Ficción', 'Torneo', 'Acción', 'Magia', 'Psicológico', 'Demencia', 'Horror', 'Terror', 'Misterio', 'Sobrenatural', 'Erotico', 'Fantasía', 'Recuentos de la vida', 'Suspenso', 'Mecha', 'Historico', 'Ecchi', 'Cocina', 'Shoujo', 'Detectives', 'Seinen', 'Sirvientas', 'Moe', 'Shounen', 'Escolares', 'Gore', 'Harem', 'Yuri', 'Yaoi', 'Deportes', 'Arcade', 'Plataformas', 'Disparos', 'Lucha', 'Politica', 'RPG \/ Juegos de Rol', 'Puzzle', 'Estrategia', 'Simulación', 'Conducción', 'Carreras', 'Artes Marciales', 'Cyberpunk', 'Supervivencia', 'Construcción', 'Tablero', 'Educativo', 'Shounen-ai', 'Shoujo-ai', 'Josei', 'Doujinshi', 'Música', 'Espacial', 'Gotico', 'Fantasia Oscura', 'Demonios', 'Smut', 'Sentai', 'Parodia', 'Superpoderes', '_Superpoderes', 'Militar', 'Samurai', 'Infantil', 'Juegos', 'Policía', 'Vampiros', ', Latino-Español'];

            $type_id = ['1', '2', '3', '4', '5', '6', '7', '8', '9', '9', '10', '10', '11', '12', '13', '14', '15', '16', '17', '18', '19', '20', '21', '22', '23', '24', '25', '26', '27', '28', '29', '30', '31', '32', '33', '34', '35', '36', '49', '38', '39', '40', '41', '42', '42', '43', '44', '45', '46', '47', '48', '50', '51', '52', '53', '54', '55', '56', '57', '58', '59', '60', '61', '62', '62', '63', '64', '65', '66', '67', '68'];

            if ($jdata['generos'] != "") :
                $generos = str_replace($type_name, $type_id, $jdata['generos']);

                $generos = str_replace(' ', '', $generos);

                $generos = explode(',', $generos);
            endif;

            //$titles = Title::all();

            //dd($titles->count());

            //return \App\Post::has('tags')->get();
            if (Title::search($data['name'])->where('type_id', '=', $data['type_id'])->count() > 0 || Title::where('slug', '=', $data['slug'])->where('type_id', '=', $data['type_id'])->count() > 0) :
                $i++;
                $oldId = Title::doesntHave('generes')->where('slug', '=', $data['slug'])->where('type_id', '=', $data['type_id'])->pluck('id');
                $oldId = Title::doesntHave('generes')->where('slug', '=', $data['slug'])->where('type_id', '=', $data['type_id'])->pluck('id');
                if ($jdata['generos'] != "") :
                    if ($oldId->count() > 0) :
                        if ($oldTitle = Title::find($oldId)) :
                            if ($oldTitle->has('generes')) :
                                $data['genere_id'] = $generos;
                                $oldTitle->generes()->sync($data['genere_id']);
                                echo '<p style="font-family: sans-serif">' . $i . '.- <span style="font-weight: bold">' . $data['name'] . '</span> (' . str_replace('Anime', 'Tv', $jdata['tipo']) . ') : Data Actualizada (Generos Actualizados: ' . $jdata['generos'] . ')</p>';
                            else :
                                echo '<p style="font-family: sans-serif">' . $i . '.- <span style="font-weight: bold">' . $data['name'] . '</span> (' . str_replace('Anime', 'Tv', $jdata['tipo']) . ') : Data Existente </p>';
                            endif;
                        endif;
                    else :
                        echo '<p style="font-family: sans-serif">' . $i . '.- <span style="font-weight: bold">' . $data['name'] . '</span> (' . str_replace('Anime', 'Tv', $jdata['tipo']) . ') : Data Existente </p>';
                    endif;
                else :
                    echo '<p style="font-family: sans-serif">' . $i . '.- <span style="font-weight: bold">' . $data['name'] . '</span> (' . str_replace('Anime', 'Tv', $jdata['tipo']) . ') : Data Existente </p>';
                endif;
            else :
                try {
                    if ($data = Title::create($data)) :
                        if ($jdata['generos'] != "") :
                            $data['genere_id'] = $generos;
                            //var_dump($data['genere_id']);
                            $data->generes()->sync($data['genere_id']);
                        endif;
                        $i++;
                        echo '<p style="font-family: sans-serif">' . $i . '.- <span style="font-weight: bold">' . $data['name'] . '</span> (' . str_replace('Anime', 'Tv', $jdata['tipo']) . ') : Data creada (Generos: ' . $jdata['generos'] . ')</p>';
                    endif;
                } catch (Error $e) {
                    echo $e;
                }
            endif;
        }
    }
}
