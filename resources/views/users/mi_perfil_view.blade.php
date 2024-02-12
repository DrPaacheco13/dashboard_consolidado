@extends('layouts.layout_main_view')

@section('content')
    <div class="container">
        <div class="card">
            <div class="card-header d-flex justify-content-center">
                <h4>Mi Perfil</h4>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-1"></div>
                    <div class="col-md-10">
                        <form action="{{ route('miperfil.post', ['id' => $user->id]) }}" method="post" id="formulario">
                            @csrf
                            <div class="row d-flex justify-content-center">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="name">Nombre</label>
                                        <input disabled type="text" value="{{ !empty($user->name) ? $user->name : '' }}"
                                            id="name" name="name" class="form-control"
                                            placeholder="Ingrese Nombre Usuario...">
                                        <span id="invalid_name" class="text-danger"></span>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="email">Email</label>
                                        <input disabled type="text" id="email" name="email"
                                            value="{{ !empty($user->email) ? $user->email : '' }}" class="form-control"
                                            placeholder="Ingrese Email...">
                                        <span id="invalid_email" class="text-danger"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="row d-flex justify-content-center">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="id_mall">Mall Activo</label>
                                        <select name="id_mall" id="id_mall" class="form-control">
                                            @if (!empty($malls))
                                                @foreach ($malls as $mall)
                                                    <option value="{{ $mall->id }}"
                                                        {{ !empty($user->id_mall) && $user->id_mall == $mall->id ? 'selected' : '' }}>
                                                        {{ $mall->nombre }}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                        <span id="invalid_acceso_r2" class="text-danger"></span>
                                    </div>
                                </div>
                            </div>
                            <br><br>
                            <div class="row d-flex justify-content-end">
                                <div class="col-md-4 d-flex justify-content-end">
                                    <div class="btn-group">
                                        <a class="btn btn-secondary" href="{{ route('users/listado') }}"><i
                                                class="fas fa-arrow-left"></i>
                                            Atrás</a>
                                        <button class="btn btn-success" type="button" id="btn_submit"><i
                                                class="fas fa-save"></i>
                                            Guardar</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
