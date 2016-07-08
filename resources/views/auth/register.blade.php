@extends('layouts.app')
@section('titulo') Registro
@endsection
@section('contenido')
<div class="login-form">
      <form class="form-horizontal" role="form" method="POST" action="{{ url('/register') }}">
        <div class="top">
          <h1>Registro</h1>
          <h4>Disfruta de un servicio completo !</h4>
        </div>
        <div class="form-area">
         {!! csrf_field() !!}  
            <div class="group{{ $errors->has('name') ? ' has-error' : '' }}">
                    <input type="text" class="form-control" name="name" placeholder="Nombre completo" value="{{ old('name') }}">
                    <i class="fa fa-user"></i>
                    @if ($errors->has('name'))
                        <span class="help-block">
                            <strong>{{ $errors->first('name') }}</strong>
                        </span>
                    @endif
            </div>  
            <div class="group{{ $errors->has('email') ? ' has-error' : '' }}">
                 <input type="email" class="form-control" name="email" placeholder="Correo electónico" value="{{ old('email') }}">
                 <i class="fa fa-envelope-o"></i>
                    @if ($errors->has('email'))
                        <span class="help-block">
                            <strong>{{ $errors->first('email') }}</strong>
                        </span>
                    @endif
            </div>
            <div class="group{{ $errors->has('password') ? ' has-error' : '' }}">
                <input type="password" class="form-control" name="password" placeholder="Contraseña">
                    <i class="fa fa-key"></i>
                    @if ($errors->has('password'))
                        <span class="help-block">
                            <strong>{{ $errors->first('password') }}</strong>
                        </span>
                    @endif
            </div>
            <div class="group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
               
                    <input type="password" class="form-control" placeholder="Repetir contraseña" name="password_confirmation">
                    <i class="fa fa-key"></i>
                    @if ($errors->has('password_confirmation'))
                        <span class="help-block">
                            <strong>{{ $errors->first('password_confirmation') }}</strong>
                        </span>
                    @endif
                
            </div> 
          <button type="submit" class="btn btn-default btn-block">Registrar ahora!</button>
        </div>
      </form>
      <div class="footer-links row">
        <div class="col-xs-6"><a href="{{ url('/login') }}"<i class="fa fa-sign-in"></i> Iniciar sesión</a></div>
       <div class="col-xs-6 text-right"><a href="{{ url('/password/reset') }}"><i class="fa fa-lock"></i> ¿Olvidaste tu contraseña?</a></div>
      </div>
    </div>


@endsection
