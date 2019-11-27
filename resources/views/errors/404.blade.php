
@extends('layouts.app')
@section('title', 'Error 404 - No encontrado')
@section('content')
<div class="content-inner text-center">
    <h1>404 - Pagina no encontrada</h1>
    <div class="text-center"><img src="/images/error404.jpg" alt="Error 404" /></div>
    <p>La pagina o sección a la que estan tratando de acceder no existe o no ha sido agregada aun.</p>
    <p>
        Si es un Contenido de la enciclopedia <a class="btn btn-warning btn-xs" href="/dashboard" role="button">Agregalo</a> o <a class="btn btn-warning btn-xs" href="/" role="button">Vuelve al Inicio</a>
    </p>
</div>
@endsection