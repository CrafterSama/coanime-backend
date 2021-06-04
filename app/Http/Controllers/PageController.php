<?php

namespace App\Http\Controllers;

use Alert;
use App\Category;
use App\Event;
use App\Company;
use App\Magazine;
use App\People;
use App\Post;
use App\Tag;
use App\Title;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class PageController extends Controller {

    public function index(Request $request, $id) {
        $page = '';

        return view('pages.detail', compact($page));
    }

}