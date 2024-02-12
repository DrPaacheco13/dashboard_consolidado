@extends('layouts.main', [
    'namePage' => 'Login page',
    'class' => 'login-page sidebar-mini ',
    'activePage' => 'login',
    'backgroundImage' => asset('img/Background.png'),
])

@section('content')
    <div class="content">
        <div class="container">
            <div class="col-md-12 ml-auto mr-auto">
                <div class="header bg-gradient-primary py-10 py-lg-2 pt-lg-12">
                    <div class="container">
                        <div class="header-body text-center mb-7">
                            <div class="row justify-content-center">
                                <div class="col-lg-12 col-md-9">
                                    <p class="text-lead text-light mt-3 mb-0">
                                        @include('alerts.migrations_check')
                                    </p>
                                </div>
                                <div class="col-lg-5 col-md-6">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4 ml-auto mr-auto">
                <form role="form" method="POST" id="formulario" action="{{ route('login') }}">
                    @csrf
                    <div class="card card-login card-plain" style="margin-top: 110%">
                        <div class="card-header ">
                        </div>
                        <div class="card-body ">
                            <div id="invalidC_email"
                                class="input-group no-border form-control-lg {{ $errors->has('email') ? ' has-danger' : '' }}">
                                <span class="input-group-prepend">
                                    <div class="input-group-text pr-3">
                                        <i class="now-ui-icons users_circle-08"></i>
                                    </div>
                                </span>
                                <input class="form-control {{ $errors->has('email') ? ' is-invalid' : '' }}"
                                    placeholder="{{ __('Correo de Usuario') }}" id="email" type="email" name="email"
                                    autofocus>
                                <br>
                            </div>
                            <strong id="invalid_email" class="text-danger pb-2 pl-1">
                                @if ($errors->has('email'))
                                    {{ $errors->first('email') }}
                                @endif
                            </strong>
                            <div
                                class="input-group no-border form-control-lg mt-3 {{ $errors->has('password') ? ' has-danger' : '' }}">
                                <div class="input-group-prepend">
                                    <div class="input-group-text pr-3">
                                        <i class="now-ui-icons objects_key-25"></i></i>
                                    </div>
                                </div>
                                <input class="form-control {{ $errors->has('password') ? ' is-invalid' : '' }}"
                                    name="password" id="password" placeholder="{{ __('Contraseña') }}" type="password">
                            </div>
                            <strong id="invalid_password" class="text-danger pb-2 pl-1">
                                @if ($errors->has('password'))
                                    {{ $errors->first('password') }}
                                @endif
                            </strong>
                        </div>
                        <div class="card-footer ">
                            <button type="button" id="btn_login" class="btn btn-primary btn-round btn-lg btn-block mb-3">
                                {{ __('Iniciar') }}
                            </button>
                        </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('js')
@endpush
