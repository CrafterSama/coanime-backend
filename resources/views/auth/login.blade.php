@extends('layouts.app')

@section('title', 'Inicio de Sesión')

@section('content')
<div class="row login">
    <div class="col-md-5 col-md-offset-4">
        <div class="panel panel-warning">
            <div class="panel-heading">Iniciar Sesión</div>
            <div class="panel-body">
                <form class="form-horizontal" role="form" method="POST" action="{{ url('/login') }}">
                    {{ csrf_field() }}

                    <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                        <div class="col-md-12">
                            <input id="email" type="email" placeholder="Correo Electronico" class="form-control" name="email" value="{{ old('email') }}" required autofocus>

                            @if ($errors->has('email'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                        <div class="col-md-12">
                            <input id="password" type="password" placeholder="Contraseña" class="form-control" name="password" required>

                            @if ($errors->has('password'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('password') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group text-center">
                        <div class="col-md-12">
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" name="remember"> Recordar mis datos
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-md-12">
                            <button type="submit" class="btn btn-success btn-block">
                                Entrar
                            </button>
                            <div class="text-center">
                                Si olvido su contraseña, Siga este <a style="color: #ff9900;" class="btn-link" href="{{ url('/password/reset') }}">enlace</a><br />
                                No tienes una Cuenta? puedes registrarte desde este link <a  style="color: #ff9900;" class="btn-link" href="{{ url('/register') }}">Registrate</a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
