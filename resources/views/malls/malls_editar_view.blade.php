@extends('layouts.layout_main_view')

@section('content')
    <style>
        #upload-button {
            background-color: #17a2b8;
            color: white;
            padding: 10px 15px;
            border-radius: 6px 6px 6px 6px;
            cursor: pointer;
        }

        #upload-button:hover {
            background-color: #0e7e8f;
        }
    </style>
    @php
        $array_r = ['r0', 'r1', 'r2', 'r3'];
        // $urlImagen = $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'] . '/' . $mall->logo;
    @endphp
    <div class="container">
        <div class="card">
            <div class="card-header d-flex justify-content-center">
                <h4>Editar Mall</h4>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <form action="{{ route('malls/editar.post', ['id' => $idmall]) }}" method="post" id="formulario"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="row d-flex justify-content-center">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="nombre">Nombre Mall</label>
                                        <input type="text" id="nombre" name="nombre" class="form-control"
                                            placeholder="Ingrese nombre..." value="{{ old('nombre', $mall->nombre) }}">
                                        <span id="invalid_nombre" class="text-danger"></span>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="descripcion">Descripcion</label>
                                        <input type="text" id="descripcion" name="descripcion" class="form-control"
                                            placeholder="Ingrese descripcion..."
                                            value="{{ old('descripcion', $mall->descripcion) }}">
                                        <span id="invalid_descripcion" class="text-danger"></span>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="distribucion_id">Distribución</label>
                                        <select name="distribucion_id" id="distribucion_id" class="form-control">
                                            <option value="0">Seleccionar</option>
                                            <option value="1" {{ $mall->distribucion_id == 1 ? 'selected' : '' }}>MALL
                                                VIVO</option>
                                            <option value="2" {{ $mall->distribucion_id == 2 ? 'selected' : '' }}>MALL
                                                ESPACIO URBANO</option>
                                        </select>
                                        <span id="invalid_distribucion_id" class="text-danger"></span>
                                    </div>
                                </div>
                            </div>

                            <div class="row d-flex justify-content-center">
                                <div class="col-md-4 text-center">
                                    <label for="logo">Logo Mall</label>
                                    <div class="form-group">
                                        <!-- Muestra la imagen actual si existe -->
                                        <label for="logo" id="upload-button">
                                            <i class="fas fa-upload" style="font-size: 22px"></i> Subir Archivo
                                        </label>
                                        <input type="file" style="display: none" name="logo" id="logo"
                                            accept="image/*">
                                    </div>
                                </div>
                            </div>

                            <div class="row d-flex justify-content-center">
                                <div class="col-md-4 text-center">
                                    <label for="logo_prev">Previsualización</label>
                                    <div class="form-group">

                                        <img class="bg-secondary bg-gradient" style="--bs-bg-opacity: .5;" width="400"
                                            height="250" id="logo_prev" alt="" src="{{ asset($mall->logo) }}">
                                    </div>
                                </div>
                            </div>

                            <div class="row d-flex justify-content-center">
                                <div class="col-md-10">
                                    <div class="row d-flex justify-content-end">
                                        <div class="col-md-4 d-flex justify-content-end">
                                            <div class="btn-group">
                                                <a class="btn btn-secondary" href="{{ route('malls/listado') }}"><i
                                                        class="fas fa-arrow-left"></i>
                                                    Atrás</a>
                                                <button class="btn btn-success" type="button" id="btn_submit"><i
                                                        class="fas fa-save"></i>
                                                    Guardar</button>
                                            </div>
                                        </div>
                                    </div>
                                    <br>
                                    <div id="accordion">
                                        <div class="card card-primary">
                                            <div class="card-header">
                                                <h4 class="card-title w-100">
                                                    <a class="d-block w-100" style="text-decoration: none"
                                                        data-toggle="collapse" href="#collapseVehiculo">
                                                        Configuración Región Vehiculos
                                                    </a>
                                                </h4>
                                            </div>
                                            <div id="collapseVehiculo" class="collapse" data-parent="#accordion">
                                                <div class="card-body">
                                                    <div class="row d-flex justify-content-center">
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <label for="acceso_vehicle">Acceso Vehiculos</label>
                                                                <select name="acceso_vehicle" id="acceso_vehicle"
                                                                    class="form-control">
                                                                    <option value="1"
                                                                        {{ $mall->acceso_vehicle == true ? 'selected' : '' }}>
                                                                        Activo</option>
                                                                    <option value="0"
                                                                        {{ $mall->acceso_vehicle == false ? 'selected' : '' }}>
                                                                        Inactivo</option>
                                                                </select>
                                                                <span id="invalid_acceso_vehicle"
                                                                    class="text-danger"></span>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <label for="acceso_tendencia">Tendencia Clientes x
                                                                    Vehiculos</label>
                                                                <select name="acceso_tendencia" id="acceso_tendencia"
                                                                    class="form-control">
                                                                    <option value="1"
                                                                        {{ $mall->acceso_tendencia == true ? 'selected' : '' }}>
                                                                        Activo</option>
                                                                    <option value="0"
                                                                        {{ $mall->acceso_tendencia == false ? 'selected' : '' }}>
                                                                        Inactivo</option>
                                                                </select>
                                                                <span id="invalid_acceso_tendencia"
                                                                    class="text-danger"></span>
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                        <div class="card card-primary">
                                            <div class="card-header">
                                                <h4 class="card-title w-100">
                                                    <a class="d-block w-100" style="text-decoration: none"
                                                        data-toggle="collapse" href="#collapseCamarasMarketing">
                                                        Configuración Camaras Maketing
                                                    </a>
                                                </h4>
                                            </div>
                                            <div id="collapseCamarasMarketing" class="collapse" data-parent="#accordion">
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="col-md-1"></div>
                                                        <div class="col-md-10">
                                                            <div class="row" id="row_camaras_marketing">
                                                                {{-- <div class="col-12" id="col_alerta_mkt">
                                                                    <div
                                                                        class="alert alert-warning alert-dismissible text-center">
                                                                        <h5>
                                                                            <i
                                                                                class="icon fas fa-exclamation-triangle"></i>
                                                                            Alerta!
                                                                        </h5>
                                                                        Agrega una Base de Datos para cargar las cámaras de
                                                                        Marketing.
                                                                    </div>


                                                                </div> --}}

                                                                <div class="row"
                                                                    id="row_camaras">
                                                                    <div class="col-md-12 text-right">
                                                                        <button id="btn_agregar_camara"
                                                                            onclick="AgregarInputsCamara()" type="button"
                                                                            class="btn btn-info text-white"><i
                                                                                class="fas fa-plus-circle text-white"></i>
                                                                            Agregar Cámara</button>
                                                                    </div>
                                                                    <div class="col-md-12" id="col_camaras">

                                                                        <br>
                                                                        <div class="row d-flex justify-content-center">
                                                                            <div class="col-md-3">
                                                                                <label for="">ID Cámara Marketing</label>
                                                                            </div>
                                                                            <div class="col-md-7">
                                                                                <label for="">Nombre Cámara</label>
                                                                            </div>
                                                                        </div>
                                                                        @if (!empty($camaras))
                                                                            @foreach ($camaras as $key => $camara)
                                                                                <div
                                                                                    class="row d-flex justify-content-center pb-3">
                                                                                    <div class="col-md-3">
                                                                                        <input type="text"
                                                                                            id="marketing_id_{{ $key }}"
                                                                                            name="marketing_id_{{ $key }}"
                                                                                            placeholder="Ingrese ID de cámara"
                                                                                            class="form-control text-center" value="{{ $camara->entrada_marketing_id }}">
                                                                                    </div>
                                                                                    <div class="col-md-7">
                                                                                        <input type="text"
                                                                                            id="nombre_camara_{{ $key }}"
                                                                                            name="nombre_camara_{{ $key }}"
                                                                                            placeholder="Ingrese Nombre de cámara"
                                                                                            class="form-control" value="{{ $camara->titulo_entrada }}">
                                                                                    </div>
                                                                                </div>
                                                                            @endforeach
                                                                        @endif
                                                                    </div>
                                                                </div>

                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                        <div class="card card-primary">
                                            <div class="card-header">
                                                <h4 class="card-title w-100">
                                                    <a class="d-block w-100" style="text-decoration: none"
                                                        data-toggle="collapse" href="#collapseR0">
                                                        Configuración Región 0
                                                    </a>
                                                </h4>
                                            </div>
                                            <div id="collapseR0" class="collapse" data-parent="#accordion">
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <label for="acceso_r0">Acceso R0</label>
                                                                <select name="acceso_r0" id="acceso_r0"
                                                                    class="form-control">
                                                                    <option value="1"
                                                                        {{ $mall->acceso_r0 == 1 ? 'selected' : '' }}>
                                                                        Activo
                                                                    </option>
                                                                    <option value="0"
                                                                        {{ $mall->acceso_r0 == 0 ? 'selected' : '' }}>
                                                                        Inactivo</option>
                                                                </select>
                                                                <span id="invalid_acceso_r0" class="text-danger"></span>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="form-group" id="col_nombre_r1">
                                                                <label for="acceso_r0_nombre">Nombre Acceso R0</label>
                                                                <input type="text" id="acceso_r0_nombre"
                                                                    name="acceso_r0_nombre" class="form-control"
                                                                    placeholder="Ingrese Nombre Acceso..."
                                                                    value="{{ old('acceso_r0_nombre', $mall->acceso_r0_nombre) }}">
                                                                <span id="invalid_acceso_r0_nombre"
                                                                    class="text-danger"></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <hr>
                                                    <h3>Secciones de Región</h3>
                                                    <hr>
                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <label for="mostrar_total_entradas_hoy_r0">Entrada
                                                                    Actual</label>
                                                                <select name="mostrar_total_entradas_hoy_r0"
                                                                    id="mostrar_total_entradas_hoy_r0"
                                                                    class="form-control">
                                                                    @empty($r0_option)
                                                                        <option value="1">Activo</option>
                                                                        <option value="0" selected>Inactivo</option>
                                                                    @else
                                                                        <option value="1"
                                                                            {{ $r0_option->mostrar_total_entradas_hoy == 1 ? 'selected' : '' }}>
                                                                            Activo</option>
                                                                        <option value="0"
                                                                            {{ $r0_option->mostrar_total_entradas_hoy == 0 ? 'selected' : '' }}>
                                                                            Inactivo</option>
                                                                    @endempty
                                                                </select>
                                                                <span id="invalid_mostrar_total_entradas_hoy_r0"
                                                                    class="text-danger"></span>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <label for="mostrar_entradas_segmentadas_hoy_r0"> Entradas
                                                                    Segmentadas Del Día</label>
                                                                <select name="mostrar_entradas_segmentadas_hoy_r0"
                                                                    id="mostrar_entradas_segmentadas_hoy_r0"
                                                                    class="form-control">
                                                                    @empty($r0_option)
                                                                        <option value="1">Activo</option>
                                                                        <option value="0" selected>Inactivo</option>
                                                                    @else
                                                                        <option value="1"
                                                                            {{ $r0_option->mostrar_entradas_segmentadas_hoy == 1 ? 'selected' : '' }}>
                                                                            Activo</option>
                                                                        <option value="0"
                                                                            {{ $r0_option->mostrar_entradas_segmentadas_hoy == 0 ? 'selected' : '' }}>
                                                                            Inactivo</option>
                                                                    @endempty
                                                                </select>
                                                                <span id="invalid_mostrar_entradas_segmentadas_hoy_r0"
                                                                    class="text-danger"></span>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <label for="mostrar_estadisticas_dia_anterior_r0">
                                                                    Estadísticas
                                                                    Día Anterior</label>
                                                                <select name="mostrar_estadisticas_dia_anterior_r0"
                                                                    id="mostrar_estadisticas_dia_anterior_r0"
                                                                    class="form-control">
                                                                    @empty($r0_option)
                                                                        <option value="1">Activo</option>
                                                                        <option value="0" selected>Inactivo</option>
                                                                    @else
                                                                        <option value="1"
                                                                            {{ $r0_option->mostrar_estadisticas_dia_anterior == 1 ? 'selected' : '' }}>
                                                                            Activo</option>
                                                                        <option value="0"
                                                                            {{ $r0_option->mostrar_estadisticas_dia_anterior == 0 ? 'selected' : '' }}>
                                                                            Inactivo</option>
                                                                    @endempty
                                                                </select>
                                                                <span id="invalid_mostrar_estadisticas_dia_anterior_r0"
                                                                    class="text-danger"></span>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <label for="mostrar_estadisticas_consolidadas_mes_r0">
                                                                    Estadísticas Consolidadas Mes</label>
                                                                <select name="mostrar_estadisticas_consolidadas_mes_r0"
                                                                    id="mostrar_estadisticas_consolidadas_mes_r0"
                                                                    class="form-control">
                                                                    @empty($r0_option)
                                                                        <option value="1">Activo</option>
                                                                        <option value="0" selected>Inactivo</option>
                                                                    @else
                                                                        <option value="1"
                                                                            {{ $r0_option->mostrar_estadisticas_consolidadas_mes == 1 ? 'selected' : '' }}>
                                                                            Activo</option>
                                                                        <option value="0"
                                                                            {{ $r0_option->mostrar_estadisticas_consolidadas_mes == 0 ? 'selected' : '' }}>
                                                                            Inactivo</option>
                                                                    @endempty
                                                                </select>
                                                                <span id="invalid_mostrar_estadisticas_consolidadas_mes_r0"
                                                                    class="text-danger"></span>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <label for="mostrar_estadisticas_consolidadas_anio_r0">
                                                                    Estadísticas Consolidadas Año</label>
                                                                <select name="mostrar_estadisticas_consolidadas_anio_r0"
                                                                    id="mostrar_estadisticas_consolidadas_anio_r0"
                                                                    class="form-control">
                                                                    @empty($r0_option)
                                                                        <option value="1">Activo</option>
                                                                        <option value="0" selected>Inactivo</option>
                                                                    @else
                                                                        <option value="1"
                                                                            {{ $r0_option->mostrar_estadisticas_consolidadas_anio == 1 ? 'selected' : '' }}>
                                                                            Activo</option>
                                                                        <option value="0"
                                                                            {{ $r0_option->mostrar_estadisticas_consolidadas_anio == 0 ? 'selected' : '' }}>
                                                                            Inactivo</option>
                                                                    @endempty
                                                                </select>
                                                                <span
                                                                    id="invalid_mostrar_estadisticas_consolidadas_anio_r0"
                                                                    class="text-danger"></span>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <label
                                                                    for="mostrar_estadisticas_comparativas_mes_actual_r0">
                                                                    Estadísticas Comparativas Mes Actual</label>
                                                                <select
                                                                    name="mostrar_estadisticas_comparativas_mes_actual_r0"
                                                                    id="mostrar_estadisticas_comparativas_mes_actual_r0"
                                                                    class="form-control">
                                                                    @empty($r0_option)
                                                                        <option value="1">Activo</option>
                                                                        <option value="0" selected>Inactivo</option>
                                                                    @else
                                                                        <option value="1"
                                                                            {{ $r0_option->mostrar_estadisticas_comparativas_mes_actual == 1 ? 'selected' : '' }}>
                                                                            Activo</option>
                                                                        <option value="0"
                                                                            {{ $r0_option->mostrar_estadisticas_comparativas_mes_actual == 0 ? 'selected' : '' }}>
                                                                            Inactivo</option>
                                                                    @endempty
                                                                </select>
                                                                <span
                                                                    id="invalid_mostrar_estadisticas_comparativas_mes_actual_r0"
                                                                    class="text-danger"></span>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <label
                                                                    for="mostrar_estadisticas_comparativas_mes_anterior_r0">
                                                                    Estadísticas Comparativas Mes Anterior</label>
                                                                <select
                                                                    name="mostrar_estadisticas_comparativas_mes_anterior_r0"
                                                                    id="mostrar_estadisticas_comparativas_mes_anterior_r0"
                                                                    class="form-control">
                                                                    @empty($r0_option)
                                                                        <option value="1">Activo</option>
                                                                        <option value="0" selected>Inactivo</option>
                                                                    @else
                                                                        <option value="1"
                                                                            {{ $r0_option->mostrar_estadisticas_comparativas_mes_anterior == 1 ? 'selected' : '' }}>
                                                                            Activo</option>
                                                                        <option value="0"
                                                                            {{ $r0_option->mostrar_estadisticas_comparativas_mes_anterior == 0 ? 'selected' : '' }}>
                                                                            Inactivo</option>
                                                                    @endempty
                                                                </select>
                                                                <span
                                                                    id="invalid_mostrar_estadisticas_comparativas_mes_anterior_r0"
                                                                    class="text-danger"></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card card-primary">
                                            <div class="card-header">
                                                <h4 class="card-title w-100">
                                                    <a class="d-block w-100" style="text-decoration: none"
                                                        data-toggle="collapse" href="#collapseR1">
                                                        Configuración Región 1
                                                    </a>
                                                </h4>
                                            </div>
                                            <div id="collapseR1" class="collapse" data-parent="#accordion">
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <label for="acceso_r1">Acceso R1</label>
                                                                <select name="acceso_r1" id="acceso_r1"
                                                                    class="form-control">
                                                                    <option value="1"
                                                                        {{ $mall->acceso_r1 == 1 ? 'selected' : '' }}>
                                                                        Activo
                                                                    </option>
                                                                    <option value="0"
                                                                        {{ $mall->acceso_r1 == 0 ? 'selected' : '' }}>
                                                                        Inactivo</option>
                                                                </select>
                                                                <span id="invalid_acceso_r1" class="text-danger"></span>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="form-group" id="col_nombre_r1">
                                                                <label for="acceso_r1_nombre">Nombre Acceso R1</label>
                                                                <input type="text" id="acceso_r1_nombre"
                                                                    name="acceso_r1_nombre" class="form-control"
                                                                    placeholder="Ingrese Nombre Acceso..."
                                                                    value="{{ old('acceso_r1_nombre', $mall->acceso_r1_nombre) }}">
                                                                <span id="invalid_acceso_r1_nombre"
                                                                    class="text-danger"></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <hr>
                                                    <h3>Secciones de Región</h3>
                                                    <hr>
                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <label for="mostrar_total_entradas_hoy_r1">Entrada
                                                                    Actual</label>
                                                                <select name="mostrar_total_entradas_hoy_r1"
                                                                    id="mostrar_total_entradas_hoy_r1"
                                                                    class="form-control">
                                                                    @empty($r1_option)
                                                                        <option value="1">Activo</option>
                                                                        <option value="0" selected>Inactivo</option>
                                                                    @else
                                                                        <option value="1"
                                                                            {{ $r1_option->mostrar_total_entradas_hoy == 1 ? 'selected' : '' }}>
                                                                            Activo</option>
                                                                        <option value="0"
                                                                            {{ $r1_option->mostrar_total_entradas_hoy == 0 ? 'selected' : '' }}>
                                                                            Inactivo</option>
                                                                    @endempty
                                                                </select>
                                                                <span id="invalid_mostrar_total_entradas_hoy_r1"
                                                                    class="text-danger"></span>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <label for="mostrar_entradas_segmentadas_hoy_r1"> Entradas
                                                                    Segmentadas Del Día</label>
                                                                <select name="mostrar_entradas_segmentadas_hoy_r1"
                                                                    id="mostrar_entradas_segmentadas_hoy_r1"
                                                                    class="form-control">
                                                                    @empty($r1_option)
                                                                        <option value="1">Activo</option>
                                                                        <option value="0" selected>Inactivo</option>
                                                                    @else
                                                                        <option value="1"
                                                                            {{ $r1_option->mostrar_entradas_segmentadas_hoy == 1 ? 'selected' : '' }}>
                                                                            Activo</option>
                                                                        <option value="0"
                                                                            {{ $r1_option->mostrar_entradas_segmentadas_hoy == 0 ? 'selected' : '' }}>
                                                                            Inactivo</option>
                                                                    @endempty
                                                                </select>
                                                                <span id="invalid_mostrar_entradas_segmentadas_hoy_r1"
                                                                    class="text-danger"></span>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <label for="mostrar_estadisticas_dia_anterior_r1">
                                                                    Estadísticas
                                                                    Día Anterior</label>
                                                                <select name="mostrar_estadisticas_dia_anterior_r1"
                                                                    id="mostrar_estadisticas_dia_anterior_r1"
                                                                    class="form-control">
                                                                    @empty($r1_option)
                                                                        <option value="1">Activo</option>
                                                                        <option value="0" selected>Inactivo</option>
                                                                    @else
                                                                        <option value="1"
                                                                            {{ $r1_option->mostrar_estadisticas_dia_anterior == 1 ? 'selected' : '' }}>
                                                                            Activo</option>
                                                                        <option value="0"
                                                                            {{ $r1_option->mostrar_estadisticas_dia_anterior == 0 ? 'selected' : '' }}>
                                                                            Inactivo</option>
                                                                    @endempty
                                                                </select>
                                                                <span id="invalid_mostrar_estadisticas_dia_anterior_r1"
                                                                    class="text-danger"></span>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <label for="mostrar_estadisticas_consolidadas_mes_r1">
                                                                    Estadísticas Consolidadas Mes</label>
                                                                <select name="mostrar_estadisticas_consolidadas_mes_r1"
                                                                    id="mostrar_estadisticas_consolidadas_mes_r1"
                                                                    class="form-control">
                                                                    @empty($r1_option)
                                                                        <option value="1">Activo</option>
                                                                        <option value="0" selected>Inactivo</option>
                                                                    @else
                                                                        <option value="1"
                                                                            {{ $r1_option->mostrar_estadisticas_consolidadas_mes == 1 ? 'selected' : '' }}>
                                                                            Activo</option>
                                                                        <option value="0"
                                                                            {{ $r1_option->mostrar_estadisticas_consolidadas_mes == 0 ? 'selected' : '' }}>
                                                                            Inactivo</option>
                                                                    @endempty
                                                                </select>
                                                                <span id="invalid_mostrar_estadisticas_consolidadas_mes_r1"
                                                                    class="text-danger"></span>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <label for="mostrar_estadisticas_consolidadas_anio_r1">
                                                                    Estadísticas Consolidadas Año</label>
                                                                <select name="mostrar_estadisticas_consolidadas_anio_r1"
                                                                    id="mostrar_estadisticas_consolidadas_anio_r1"
                                                                    class="form-control">
                                                                    @empty($r1_option)
                                                                        <option value="1">Activo</option>
                                                                        <option value="0" selected>Inactivo</option>
                                                                    @else
                                                                        <option value="1"
                                                                            {{ $r1_option->mostrar_estadisticas_consolidadas_anio == 1 ? 'selected' : '' }}>
                                                                            Activo</option>
                                                                        <option value="0"
                                                                            {{ $r1_option->mostrar_estadisticas_consolidadas_anio == 0 ? 'selected' : '' }}>
                                                                            Inactivo</option>
                                                                    @endempty
                                                                </select>
                                                                <span
                                                                    id="invalid_mostrar_estadisticas_consolidadas_anio_r1"
                                                                    class="text-danger"></span>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <label
                                                                    for="mostrar_estadisticas_comparativas_mes_actual_r1">
                                                                    Estadísticas Comparativas Mes Actual</label>
                                                                <select
                                                                    name="mostrar_estadisticas_comparativas_mes_actual_r1"
                                                                    id="mostrar_estadisticas_comparativas_mes_actual_r1"
                                                                    class="form-control">
                                                                    @empty($r1_option)
                                                                        <option value="1">Activo</option>
                                                                        <option value="0" selected>Inactivo</option>
                                                                    @else
                                                                        <option value="1"
                                                                            {{ $r1_option->mostrar_estadisticas_comparativas_mes_actual == 1 ? 'selected' : '' }}>
                                                                            Activo</option>
                                                                        <option value="0"
                                                                            {{ $r1_option->mostrar_estadisticas_comparativas_mes_actual == 0 ? 'selected' : '' }}>
                                                                            Inactivo</option>
                                                                    @endempty
                                                                </select>
                                                                <span
                                                                    id="invalid_mostrar_estadisticas_comparativas_mes_actual_r1"
                                                                    class="text-danger"></span>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <label
                                                                    for="mostrar_estadisticas_comparativas_mes_anterior_r1">
                                                                    Estadísticas Comparativas Mes Anterior</label>
                                                                <select
                                                                    name="mostrar_estadisticas_comparativas_mes_anterior_r1"
                                                                    id="mostrar_estadisticas_comparativas_mes_anterior_r1"
                                                                    class="form-control">
                                                                    @empty($r1_option)
                                                                        <option value="1">Activo</option>
                                                                        <option value="0" selected>Inactivo</option>
                                                                    @else
                                                                        <option value="1"
                                                                            {{ $r1_option->mostrar_estadisticas_comparativas_mes_anterior == 1 ? 'selected' : '' }}>
                                                                            Activo</option>
                                                                        <option value="0"
                                                                            {{ $r1_option->mostrar_estadisticas_comparativas_mes_anterior == 0 ? 'selected' : '' }}>
                                                                            Inactivo</option>
                                                                    @endempty
                                                                </select>
                                                                <span
                                                                    id="invalid_mostrar_estadisticas_comparativas_mes_anterior_r1"
                                                                    class="text-danger"></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card card-primary">
                                            <div class="card-header">
                                                <h4 class="card-title w-100">
                                                    <a class="d-block w-100" style="text-decoration: none"
                                                        data-toggle="collapse" href="#collapseR2">
                                                        Configuración Región 2
                                                    </a>
                                                </h4>
                                            </div>
                                            <div id="collapseR2" class="collapse" data-parent="#accordion">
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <label for="acceso_r2">Acceso R2</label>
                                                                <select name="acceso_r2" id="acceso_r2"
                                                                    class="form-control">
                                                                    <option value="1"
                                                                        {{ $mall->acceso_r2 == 1 ? 'selected' : '' }}>
                                                                        Activo
                                                                    </option>
                                                                    <option value="0"
                                                                        {{ $mall->acceso_r2 == 0 ? 'selected' : '' }}>
                                                                        Inactivo</option>
                                                                </select>
                                                                <span id="invalid_acceso_r2" class="text-danger"></span>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="form-group" id="col_nombre_r2">
                                                                <label for="acceso_r2_nombre">Nombre Acceso R2</label>
                                                                <input type="text" id="acceso_r2_nombre"
                                                                    name="acceso_r2_nombre" class="form-control"
                                                                    placeholder="Ingrese Nombre Acceso..."
                                                                    value="{{ old('acceso_r2_nombre', $mall->acceso_r2_nombre) }}">
                                                                <span id="invalid_acceso_r2_nombre"
                                                                    class="text-danger"></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <hr>
                                                    <h3>Secciones de Región</h3>
                                                    <hr>
                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <label for="mostrar_total_entradas_hoy_r2">Entrada
                                                                    Actual</label>
                                                                <select name="mostrar_total_entradas_hoy_r2"
                                                                    id="mostrar_total_entradas_hoy_r2"
                                                                    class="form-control">
                                                                    @empty($r2_option)
                                                                        <option value="1">Activo</option>
                                                                        <option value="0" selected>Inactivo</option>
                                                                    @else
                                                                        <option value="1"
                                                                            {{ $r2_option->mostrar_total_entradas_hoy == 1 ? 'selected' : '' }}>
                                                                            Activo</option>
                                                                        <option value="0"
                                                                            {{ $r2_option->mostrar_total_entradas_hoy == 0 ? 'selected' : '' }}>
                                                                            Inactivo</option>
                                                                    @endempty
                                                                </select>
                                                                <span id="invalid_mostrar_total_entradas_hoy_r2"
                                                                    class="text-danger"></span>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <label for="mostrar_entradas_segmentadas_hoy_r2"> Entradas
                                                                    Segmentadas Del Día</label>
                                                                <select name="mostrar_entradas_segmentadas_hoy_r2"
                                                                    id="mostrar_entradas_segmentadas_hoy_r2"
                                                                    class="form-control">
                                                                    @empty($r2_option)
                                                                        <option value="1">Activo</option>
                                                                        <option value="0" selected>Inactivo</option>
                                                                    @else
                                                                        <option value="1"
                                                                            {{ $r2_option->mostrar_entradas_segmentadas_hoy == 1 ? 'selected' : '' }}>
                                                                            Activo</option>
                                                                        <option value="0"
                                                                            {{ $r2_option->mostrar_entradas_segmentadas_hoy == 0 ? 'selected' : '' }}>
                                                                            Inactivo</option>
                                                                    @endempty
                                                                </select>
                                                                <span id="invalid_mostrar_entradas_segmentadas_hoy_r2"
                                                                    class="text-danger"></span>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <label for="mostrar_estadisticas_dia_anterior_r2">
                                                                    Estadísticas
                                                                    Día Anterior</label>
                                                                <select name="mostrar_estadisticas_dia_anterior_r2"
                                                                    id="mostrar_estadisticas_dia_anterior_r2"
                                                                    class="form-control">
                                                                    @empty($r2_option)
                                                                        <option value="1">Activo</option>
                                                                        <option value="0" selected>Inactivo</option>
                                                                    @else
                                                                        <option value="1"
                                                                            {{ $r2_option->mostrar_estadisticas_dia_anterior == 1 ? 'selected' : '' }}>
                                                                            Activo</option>
                                                                        <option value="0"
                                                                            {{ $r2_option->mostrar_estadisticas_dia_anterior == 0 ? 'selected' : '' }}>
                                                                            Inactivo</option>
                                                                    @endempty
                                                                </select>
                                                                <span id="invalid_mostrar_estadisticas_dia_anterior_r2"
                                                                    class="text-danger"></span>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <label for="mostrar_estadisticas_consolidadas_mes_r2">
                                                                    Estadísticas Consolidadas Mes</label>
                                                                <select name="mostrar_estadisticas_consolidadas_mes_r2"
                                                                    id="mostrar_estadisticas_consolidadas_mes_r2"
                                                                    class="form-control">
                                                                    @empty($r2_option)
                                                                        <option value="1">Activo</option>
                                                                        <option value="0" selected>Inactivo</option>
                                                                    @else
                                                                        <option value="1"
                                                                            {{ $r2_option->mostrar_estadisticas_consolidadas_mes == 1 ? 'selected' : '' }}>
                                                                            Activo</option>
                                                                        <option value="0"
                                                                            {{ $r2_option->mostrar_estadisticas_consolidadas_mes == 0 ? 'selected' : '' }}>
                                                                            Inactivo</option>
                                                                    @endempty
                                                                </select>
                                                                <span id="invalid_mostrar_estadisticas_consolidadas_mes_r2"
                                                                    class="text-danger"></span>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <label for="mostrar_estadisticas_consolidadas_anio_r2">
                                                                    Estadísticas Consolidadas Año</label>
                                                                <select name="mostrar_estadisticas_consolidadas_anio_r2"
                                                                    id="mostrar_estadisticas_consolidadas_anio_r2"
                                                                    class="form-control">
                                                                    @empty($r2_option)
                                                                        <option value="1">Activo</option>
                                                                        <option value="0" selected>Inactivo</option>
                                                                    @else
                                                                        <option value="1"
                                                                            {{ $r2_option->mostrar_estadisticas_consolidadas_anio == 1 ? 'selected' : '' }}>
                                                                            Activo</option>
                                                                        <option value="0"
                                                                            {{ $r2_option->mostrar_estadisticas_consolidadas_anio == 0 ? 'selected' : '' }}>
                                                                            Inactivo</option>
                                                                    @endempty
                                                                </select>
                                                                <span
                                                                    id="invalid_mostrar_estadisticas_consolidadas_anio_r2"
                                                                    class="text-danger"></span>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <label
                                                                    for="mostrar_estadisticas_comparativas_mes_actual_r2">
                                                                    Estadísticas Comparativas Mes Actual</label>
                                                                <select
                                                                    name="mostrar_estadisticas_comparativas_mes_actual_r2"
                                                                    id="mostrar_estadisticas_comparativas_mes_actual_r2"
                                                                    class="form-control">
                                                                    @empty($r2_option)
                                                                        <option value="1">Activo</option>
                                                                        <option value="0" selected>Inactivo</option>
                                                                    @else
                                                                        <option value="1"
                                                                            {{ $r2_option->mostrar_estadisticas_comparativas_mes_actual == 1 ? 'selected' : '' }}>
                                                                            Activo</option>
                                                                        <option value="0"
                                                                            {{ $r2_option->mostrar_estadisticas_comparativas_mes_actual == 0 ? 'selected' : '' }}>
                                                                            Inactivo</option>
                                                                    @endempty
                                                                </select>
                                                                <span
                                                                    id="invalid_mostrar_estadisticas_comparativas_mes_actual_r2"
                                                                    class="text-danger"></span>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <label
                                                                    for="mostrar_estadisticas_comparativas_mes_anterior_r2">
                                                                    Estadísticas Comparativas Mes Anterior</label>
                                                                <select
                                                                    name="mostrar_estadisticas_comparativas_mes_anterior_r2"
                                                                    id="mostrar_estadisticas_comparativas_mes_anterior_r2"
                                                                    class="form-control">
                                                                    @empty($r2_option)
                                                                        <option value="1">Activo</option>
                                                                        <option value="0" selected>Inactivo</option>
                                                                    @else
                                                                        <option value="1"
                                                                            {{ $r2_option->mostrar_estadisticas_comparativas_mes_anterior == 1 ? 'selected' : '' }}>
                                                                            Activo</option>
                                                                        <option value="0"
                                                                            {{ $r2_option->mostrar_estadisticas_comparativas_mes_anterior == 0 ? 'selected' : '' }}>
                                                                            Inactivo</option>
                                                                    @endempty
                                                                </select>
                                                                <span
                                                                    id="invalid_mostrar_estadisticas_comparativas_mes_anterior_r2"
                                                                    class="text-danger"></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card card-primary">
                                            <div class="card-header">
                                                <h4 class="card-title w-100">
                                                    <a class="d-block w-100" style="text-decoration: none"
                                                        data-toggle="collapse" href="#collapseR3">
                                                        Configuración Región 3
                                                    </a>
                                                </h4>
                                            </div>
                                            <div id="collapseR3" class="collapse" data-parent="#accordion">
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <label for="acceso_r3">Acceso R3</label>
                                                                <select name="acceso_r3" id="acceso_r3"
                                                                    class="form-control">
                                                                    <option value="1"
                                                                        {{ $mall->acceso_r3 == 1 ? 'selected' : '' }}>
                                                                        Activo
                                                                    </option>
                                                                    <option value="0"
                                                                        {{ $mall->acceso_r3 == 0 ? 'selected' : '' }}>
                                                                        Inactivo</option>
                                                                </select>
                                                                <span id="invalid_acceso_r3" class="text-danger"></span>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="form-group" id="col_nombre_r3">
                                                                <label for="acceso_r3_nombre">Nombre Acceso R3</label>
                                                                <input type="text" id="acceso_r3_nombre"
                                                                    name="acceso_r3_nombre" class="form-control"
                                                                    placeholder="Ingrese Nombre Acceso..."
                                                                    value="{{ old('acceso_r3_nombre', $mall->acceso_r3_nombre) }}">
                                                                <span id="invalid_acceso_r3_nombre"
                                                                    class="text-danger"></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <hr>
                                                    <h3>Secciones de Región</h3>
                                                    <hr>
                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <label for="mostrar_total_entradas_hoy_r3">Entrada
                                                                    Actual</label>
                                                                <select name="mostrar_total_entradas_hoy_r3"
                                                                    id="mostrar_total_entradas_hoy_r3"
                                                                    class="form-control">
                                                                    @empty($r3_option)
                                                                        <option value="1">Activo</option>
                                                                        <option value="0" selected>Inactivo</option>
                                                                    @else
                                                                        <option value="1"
                                                                            {{ $r3_option->mostrar_total_entradas_hoy == 1 ? 'selected' : '' }}>
                                                                            Activo</option>
                                                                        <option value="0"
                                                                            {{ $r3_option->mostrar_total_entradas_hoy == 0 ? 'selected' : '' }}>
                                                                            Inactivo</option>
                                                                    @endempty
                                                                </select>
                                                                <span id="invalid_mostrar_total_entradas_hoy_r3"
                                                                    class="text-danger"></span>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <label for="mostrar_entradas_segmentadas_hoy_r3"> Entradas
                                                                    Segmentadas Del Día</label>
                                                                <select name="mostrar_entradas_segmentadas_hoy_r3"
                                                                    id="mostrar_entradas_segmentadas_hoy_r3"
                                                                    class="form-control">
                                                                    @empty($r3_option)
                                                                        <option value="1">Activo</option>
                                                                        <option value="0" selected>Inactivo</option>
                                                                    @else
                                                                        <option value="1"
                                                                            {{ $r3_option->mostrar_entradas_segmentadas_hoy == 1 ? 'selected' : '' }}>
                                                                            Activo</option>
                                                                        <option value="0"
                                                                            {{ $r3_option->mostrar_entradas_segmentadas_hoy == 0 ? 'selected' : '' }}>
                                                                            Inactivo</option>
                                                                    @endempty
                                                                </select>
                                                                <span id="invalid_mostrar_entradas_segmentadas_hoy_r3"
                                                                    class="text-danger"></span>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <label for="mostrar_estadisticas_dia_anterior_r3">
                                                                    Estadísticas
                                                                    Día Anterior</label>
                                                                <select name="mostrar_estadisticas_dia_anterior_r3"
                                                                    id="mostrar_estadisticas_dia_anterior_r3"
                                                                    class="form-control">
                                                                    @empty($r3_option)
                                                                        <option value="1">Activo</option>
                                                                        <option value="0" selected>Inactivo</option>
                                                                    @else
                                                                        <option value="1"
                                                                            {{ $r3_option->mostrar_estadisticas_dia_anterior == 1 ? 'selected' : '' }}>
                                                                            Activo</option>
                                                                        <option value="0"
                                                                            {{ $r3_option->mostrar_estadisticas_dia_anterior == 0 ? 'selected' : '' }}>
                                                                            Inactivo</option>
                                                                    @endempty
                                                                </select>
                                                                <span id="invalid_mostrar_estadisticas_dia_anterior_r3"
                                                                    class="text-danger"></span>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <label for="mostrar_estadisticas_consolidadas_mes_r3">
                                                                    Estadísticas Consolidadas Mes</label>
                                                                <select name="mostrar_estadisticas_consolidadas_mes_r3"
                                                                    id="mostrar_estadisticas_consolidadas_mes_r3"
                                                                    class="form-control">
                                                                    @empty($r3_option)
                                                                        <option value="1">Activo</option>
                                                                        <option value="0" selected>Inactivo</option>
                                                                    @else
                                                                        <option value="1"
                                                                            {{ $r3_option->mostrar_estadisticas_consolidadas_mes == 1 ? 'selected' : '' }}>
                                                                            Activo</option>
                                                                        <option value="0"
                                                                            {{ $r3_option->mostrar_estadisticas_consolidadas_mes == 0 ? 'selected' : '' }}>
                                                                            Inactivo</option>
                                                                    @endempty
                                                                </select>
                                                                <span id="invalid_mostrar_estadisticas_consolidadas_mes_r3"
                                                                    class="text-danger"></span>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <label for="mostrar_estadisticas_consolidadas_anio_r3">
                                                                    Estadísticas Consolidadas Año</label>
                                                                <select name="mostrar_estadisticas_consolidadas_anio_r3"
                                                                    id="mostrar_estadisticas_consolidadas_anio_r3"
                                                                    class="form-control">
                                                                    @empty($r3_option)
                                                                        <option value="1">Activo</option>
                                                                        <option value="0" selected>Inactivo</option>
                                                                    @else
                                                                        <option value="1"
                                                                            {{ $r3_option->mostrar_estadisticas_consolidadas_anio == 1 ? 'selected' : '' }}>
                                                                            Activo</option>
                                                                        <option value="0"
                                                                            {{ $r3_option->mostrar_estadisticas_consolidadas_anio == 0 ? 'selected' : '' }}>
                                                                            Inactivo</option>
                                                                    @endempty
                                                                </select>
                                                                <span
                                                                    id="invalid_mostrar_estadisticas_consolidadas_anio_r3"
                                                                    class="text-danger"></span>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <label
                                                                    for="mostrar_estadisticas_comparativas_mes_actual_r3">
                                                                    Estadísticas Comparativas Mes Actual</label>
                                                                <select
                                                                    name="mostrar_estadisticas_comparativas_mes_actual_r3"
                                                                    id="mostrar_estadisticas_comparativas_mes_actual_r3"
                                                                    class="form-control">
                                                                    @empty($r3_option)
                                                                        <option value="1">Activo</option>
                                                                        <option value="0" selected>Inactivo</option>
                                                                    @else
                                                                        <option value="1"
                                                                            {{ $r3_option->mostrar_estadisticas_comparativas_mes_actual == 1 ? 'selected' : '' }}>
                                                                            Activo</option>
                                                                        <option value="0"
                                                                            {{ $r3_option->mostrar_estadisticas_comparativas_mes_actual == 0 ? 'selected' : '' }}>
                                                                            Inactivo</option>
                                                                    @endempty
                                                                </select>
                                                                <span
                                                                    id="invalid_mostrar_estadisticas_comparativas_mes_actual_r3"
                                                                    class="text-danger"></span>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <label
                                                                    for="mostrar_estadisticas_comparativas_mes_anterior_r3">
                                                                    Estadísticas Comparativas Mes Anterior</label>
                                                                <select
                                                                    name="mostrar_estadisticas_comparativas_mes_anterior_r3"
                                                                    id="mostrar_estadisticas_comparativas_mes_anterior_r3"
                                                                    class="form-control">
                                                                    @empty($r3_option)
                                                                        <option value="1">Activo</option>
                                                                        <option value="0" selected>Inactivo</option>
                                                                    @else
                                                                        <option value="1"
                                                                            {{ $r3_option->mostrar_estadisticas_comparativas_mes_anterior == 1 ? 'selected' : '' }}>
                                                                            Activo</option>
                                                                        <option value="0"
                                                                            {{ $r3_option->mostrar_estadisticas_comparativas_mes_anterior == 0 ? 'selected' : '' }}>
                                                                            Inactivo</option>
                                                                    @endempty
                                                                </select>
                                                                <span
                                                                    id="invalid_mostrar_estadisticas_comparativas_mes_anterior_r3"
                                                                    class="text-danger"></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
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
