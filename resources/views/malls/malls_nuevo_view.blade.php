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
            /* Cambia el color al pasar el ratón sobre el botón */
        }
    </style>
    <div class="container">
        <div class="card">
            <div class="card-header d-flex justify-content-center">
                <h4>Formulario de Nuevo Mall</h4>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <form action="{{ route('malls/nuevo.post') }}" method="post" id="formulario"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="row d-flex justify-content-center">
                                <div class="col-md-1"></div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="nombre">Nombre Mall</label>
                                        <input type="text" id="nombre" name="nombre" class="form-control"
                                            placeholder="Ingrese nombre...">
                                        <span id="invalid_nombre" class="text-danger"></span>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="descripcion">Descripcion</label>
                                        <input type="text" id="descripcion" name="descripcion" class="form-control"
                                            placeholder="Ingrese descripcion...">
                                        <span id="invalid_descripcion" class="text-danger"></span>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="distribucion_id">Distribución</label>
                                        <select name="distribucion_id" id="distribucion_id" class="form-control">
                                            <option value="0">Seleccionar</option>
                                            <option value="1">MALL VIVO</option>
                                            <option value="2">MALL ESPACIO URBANO</option>
                                        </select>
                                        <span id="invalid_distribucion_id" class="text-danger"></span>
                                    </div>
                                </div>
                                <div class="col-md-1"></div>
                                {{-- <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="estado">Estado</label>
                                        <select name="estado" id="estado" class="form-control">
                                            <option value="1">Activo</option>
                                            <option value="0">Inactivo</option>
                                        </select>
                                        <span id="invalid_estado" class="text-danger"></span>
                                    </div>
                                </div> --}}
                            </div>

                            <div class="row d-flex justify-content-center">
                                <div class="col-md-4 text-center">
                                    <label for="logo">Logo Mall</label>
                                    <div class="form-group">
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
                                        <img class="bg-secondary bg-gradient" style="--bs-bg-opacity: .5;" width="200"
                                            height="200" id="logo_prev" alt="">
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
                                        <div class="card card-info">
                                            <div class="card-header">
                                                <h4 class="card-title w-100">
                                                    <a class="d-block w-100" style="text-decoration: none"
                                                        data-toggle="collapse" href="#collapseDB">
                                                        Configuración Base de Datos
                                                    </a>
                                                </h4>
                                            </div>
                                            <div id="collapseDB" class="collapse show" data-parent="#accordion">
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            <div class="form-group" id="col_nombre_r1">
                                                                <label for="db_host">Host/Ip</label>
                                                                <input type="text" id="db_host" name="db_host"
                                                                    class="form-control" placeholder="Ingrese Host/Ip...">
                                                                <span id="invalid_db_host" class="text-danger"></span>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <label for="db_port">Puerto</label>
                                                                <input type="text" id="db_port" name="db_port"
                                                                    class="form-control" placeholder="Ingrese Puerto...">
                                                                <span id="invalid_db_port" class="text-danger"></span>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <label for="db_user">Usuario</label>
                                                                <input type="text" id="db_user" name="db_user"
                                                                    class="form-control" placeholder="Ingrese Usuario...">
                                                                <span id="invalid_db_user" class="text-danger"></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row d-flex justify-content-center">
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <label for="db_name">Base de Datos</label>
                                                                <input type="text" id="db_name" name="db_name"
                                                                    class="form-control"
                                                                    placeholder="Ingrese Base de Datos...">
                                                                <span id="invalid_db_name" class="text-danger"></span>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <label for="db_password">Contraseña</label>
                                                                <input type="text" id="db_password" name="db_password"
                                                                    class="form-control"
                                                                    placeholder="Ingrese Contraseña...">
                                                                <span id="invalid_db_password" class="text-danger"></span>
                                                            </div>
                                                        </div>
                                                        <div
                                                            class="col-md-4 d-flex justify-content-center align-items-center pt-3">
                                                            <button class="btn btn-info" type="button"
                                                                style="display: show; color: white;"
                                                                id="btn_validar_db"><i class="fas fa-check-circle pr-1"
                                                                    style="color: white;"></i>Validar</button>
                                                            <button class="btn btn-info" type="button"
                                                                id="btn_modificar_db" onclick="HabilitarCamposDB()"
                                                                style=" color: white; display: none"><i
                                                                    class="fas fa-pencil-square pr-1"
                                                                    style="color: white;"></i>Modificar</button>
                                                        </div>

                                                        <div class="col-md-12">
                                                            <span class="text-green" style="display: none"
                                                                id="msg_db">Base de Datos conectada con éxito.</span>
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
                                                                <div class="col-12" id="col_alerta_mkt">
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


                                                                </div>

                                                                <div class="row" style="display: none" id="row_camaras">
                                                                    <div class="col-md-12 text-right">
                                                                        <button id="btn_agregar_camara" onclick="AgregarInputsCamara()" type="button" class="btn btn-info text-white"><i class="fas fa-plus-circle text-white"></i> Agregar Cámara</button>
                                                                    </div>
                                                                    <div class="col-md-12" id="col_camaras">
                                                                        <br>
                                                                        <div class="row d-flex justify-content-center pb-3">
                                                                            <div class="col-md-3">
                                                                                <input type="text" id="marketing_id_1" name="camaras[0][marketing_id]" placeholder="Ingrese INDEXCODE de cámara" class="form-control text-center">
                                                                            </div>
                                                                            <div class="col-md-7">
                                                                                <input type="text" id="nombre_camara_1" name="camaras[0][nombre_camara]" placeholder="Ingrese Nombre de cámara" class="form-control">
                                                                            </div>
                                                                        </div>
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
                                                                    <option value="1">Activo</option>
                                                                    <option value="0" selected>Inactivo</option>
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
                                                                    <option value="1">Activo</option>
                                                                    <option value="0" selected>Inactivo</option>
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
                                                                    <option value="1">Activo</option>
                                                                    <option value="0" selected>Inactivo</option>
                                                                </select>
                                                                <span id="invalid_acceso_r0" class="text-danger"></span>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="form-group" id="col_nombre_r1">
                                                                <label for="acceso_r0_nombre">Nombre Acceso R0</label>
                                                                <input type="text" id="acceso_r0_nombre"
                                                                    name="acceso_r0_nombre" class="form-control"
                                                                    placeholder="Ingrese Nombre Acceso...">
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
                                                                    <option value="1">Activo</option>
                                                                    <option value="0" selected>Inactivo</option>
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
                                                                    <option value="1">Activo</option>
                                                                    <option value="0" selected>Inactivo</option>
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
                                                                    <option value="1">Activo</option>
                                                                    <option value="0" selected>Inactivo</option>
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
                                                                    <option value="1">Activo</option>
                                                                    <option value="0" selected>Inactivo</option>
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
                                                                    <option value="1">Activo</option>
                                                                    <option value="0" selected>Inactivo</option>
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
                                                                    <option value="1">Activo</option>
                                                                    <option value="0" selected>Inactivo</option>
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
                                                                    <option value="1">Activo</option>
                                                                    <option value="0" selected>Inactivo</option>
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
                                                                    <option value="1">Activo</option>
                                                                    <option value="0" selected>Inactivo</option>
                                                                </select>
                                                                <span id="invalid_acceso_r1" class="text-danger"></span>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="form-group" id="col_nombre_r1">
                                                                <label for="acceso_r1_nombre">Nombre Acceso R1</label>
                                                                <input type="text" id="acceso_r1_nombre"
                                                                    name="acceso_r1_nombre" class="form-control"
                                                                    placeholder="Ingrese Nombre Acceso...">
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
                                                                    <option value="1">Activo</option>
                                                                    <option value="0" selected>Inactivo</option>
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
                                                                    <option value="1">Activo</option>
                                                                    <option value="0" selected>Inactivo</option>
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
                                                                    <option value="1">Activo</option>
                                                                    <option value="0" selected>Inactivo</option>
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
                                                                    <option value="1">Activo</option>
                                                                    <option value="0" selected>Inactivo</option>
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
                                                                    <option value="1">Activo</option>
                                                                    <option value="0" selected>Inactivo</option>
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
                                                                    <option value="1">Activo</option>
                                                                    <option value="0" selected>Inactivo</option>
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
                                                                    <option value="1">Activo</option>
                                                                    <option value="0" selected>Inactivo</option>
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
                                                                    <option value="1">Activo</option>
                                                                    <option value="0" selected>Inactivo</option>
                                                                </select>
                                                                <span id="invalid_acceso_r2" class="text-danger"></span>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="form-group" id="col_nombre_r1">
                                                                <label for="acceso_r2_nombre">Nombre Acceso R2</label>
                                                                <input type="text" id="acceso_r2_nombre"
                                                                    name="acceso_r2_nombre" class="form-control"
                                                                    placeholder="Ingrese Nombre Acceso...">
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
                                                                    <option value="1">Activo</option>
                                                                    <option value="0" selected>Inactivo</option>
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
                                                                    <option value="1">Activo</option>
                                                                    <option value="0" selected>Inactivo</option>
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
                                                                    <option value="1">Activo</option>
                                                                    <option value="0" selected>Inactivo</option>
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
                                                                    <option value="1">Activo</option>
                                                                    <option value="0" selected>Inactivo</option>
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
                                                                    <option value="1">Activo</option>
                                                                    <option value="0" selected>Inactivo</option>
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
                                                                    <option value="1">Activo</option>
                                                                    <option value="0" selected>Inactivo</option>
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
                                                                    <option value="1">Activo</option>
                                                                    <option value="0" selected>Inactivo</option>
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
                                                                    <option value="1">Activo</option>
                                                                    <option value="0" selected>Inactivo</option>
                                                                </select>
                                                                <span id="invalid_acceso_r3" class="text-danger"></span>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="form-group" id="col_nombre_r1">
                                                                <label for="acceso_r3_nombre">Nombre Acceso R3</label>
                                                                <input type="text" id="acceso_r3_nombre"
                                                                    name="acceso_r3_nombre" class="form-control"
                                                                    placeholder="Ingrese Nombre Acceso...">
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
                                                                    <option value="1">Activo</option>
                                                                    <option value="0" selected>Inactivo</option>
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
                                                                    <option value="1">Activo</option>
                                                                    <option value="0" selected>Inactivo</option>
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
                                                                    <option value="1">Activo</option>
                                                                    <option value="0" selected>Inactivo</option>
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
                                                                    <option value="1">Activo</option>
                                                                    <option value="0" selected>Inactivo</option>
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
                                                                    <option value="1">Activo</option>
                                                                    <option value="0" selected>Inactivo</option>
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
                                                                    <option value="1">Activo</option>
                                                                    <option value="0" selected>Inactivo</option>
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
                                                                    <option value="1">Activo</option>
                                                                    <option value="0" selected>Inactivo</option>
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
