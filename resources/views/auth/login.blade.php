@extends('layouts.front')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-4">
            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="text-center mb-4">
                    <img class="mb-4" src="https://getbootstrap.com/assets/brand/bootstrap-solid.svg" alt="" width="72" height="72">
                    <h1 class="h3 mb-3 font-weight-normal">Bienvenido/a</h1>
                    <p>Consulta de <code>Lugares y Horarios</code>. <br>
                    <a href="#!">Funciona bien en Chrome y Firefox.</a></p>
                </div>

                <div class="form-group row">
                    <label for="email" class="col-sm-3 col-form-label text-md-right">Email</label>

                    <div class="col-md-8">
                        <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required autofocus>

                        @if ($errors->has('email'))
                            <span class="invalid-feedback">
                                <strong>{{ $errors->first('email') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

                <div class="form-group row">
                    <label for="password" class="col-md-3 col-form-label text-md-right">Clave</label>

                    <div class="col-md-8">
                        <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>

                        @if ($errors->has('password'))
                            <span class="invalid-feedback">
                                <strong>{{ $errors->first('password') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

                <button class="btn btn-lg btn-primary btn-block" type="submit">Login</button>
                <p class="mt-5 mb-3 text-muted text-center">&copy; 2018</p>
            </form>
        </div>
        <div class="col-md-9">
            <div class="text-center" style="padding-top: 10px;">
                <a href="#!">
                    <img class="img-thumbnail rounded" width="20%" src="{{url('img/header/logo.jpg')}}" alt=""> <br>
                    <img class="img-thumbnail rounded" width="20%" src="{{url('img/LOGO_SALUD RESPONDE_2014.jpg')}}" alt=""> <br>
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
