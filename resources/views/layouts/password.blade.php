@extends('layouts.layout_main_view')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-3"></div>
            <div class="col-md-6">
                <div class="card panel-default">
                    <div class="card-header">
                        <h4 class="text-center">Cambiar Contraseña</h4>
                    </div>

                    <div class="card-body">

                        <form class="form-horizontal" id="formulario" method="POST" action="{{ route('changePassword') }}">
                            @csrf

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="actual_password">Contraseña Actual</label>
                                    <input id="actual_password" type="password" class="form-control" name="actual_password"
                                        placeholder="Ingrese Actual Contraseña">
                                    <span id="invalid_actual_password" class="text-danger"></span>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="password">Nueva Contraseña</label>
                                    <input id="password" type="password" class="form-control"
                                        placeholder="Ingrese Nueva Contraseña" name="password">
                                    <span id="invalid_password" class="text-danger"></span>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="password_confirm">Confirmar Nueva
                                        Contraseña</label>
                                    <input id="password_confirm" type="password" placeholder="Confirmar Nueva Contraseña"
                                        class="form-control" name="password_confirm">
                                    <span id="invalid_password_confirm" class="text-danger"></span>
                                </div>
                            </div>

                            <div class="col-md-12 text-right">
                                <button type="button" id="btn_cambiar" class="btn btn-success">
                                    Confirmar
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
