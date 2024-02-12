@extends('layouts.layout_main_view')

@section('content')
    <style>
        /* Estilo del preload */
        .preload {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100%;
        }

        .preload-spinner {
            border: 8px solid #f3f3f3;
            border-top: 8px solid #3498db;
            border-radius: 50%;
            width: 50px;
            height: 50px;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }
    </style>
    <style>
        .img-logo {
            max-width: 100%;
            max-height: 100%;
        }

        .logo-content {
            height: 100px;
            margin-left: 10px;
            margin-top: 10px
        }

        .texto-ini {
            max-width: 100%;
            max-height: 100%;
        }

        .texto-box {
            height: 100%;
        }
    </style>
    <div class="container">
        <div class="row">
            <div class="card col-md-3">
                <div class="card-body">
                    <form action="{{ route('search.post') }}" method="post" style="text-align: center" id="formulario">
                        @csrf
                        <div class="mb-3">
                            <label for="patente" class="form-label">Indique Patente</label>
                            <input class="form-control mr-sm-2" type="text" name="patente" value="{{ $texto }}"
                                id="patente" placeholder="Buscar por patente" style="text-align: center">
                            <span id="invalid_patente" class="form-text text-danger"></span>

                        </div>
                        <div class="mb-3">
                            <label for="fecha_inicial" class="form-label">Fecha Inicial</label>
                            <input class="form-control mr-sm-2" type="date" name="fecha" id="fecha_inicial"
                                value="" min="2015-01-01" max="{{ GetDateToday() }}"
                                style="text-align: center">
                            <span id="invalid_fecha_inicial" class="form-text text-danger"></span>
                        </div>
                        <div class="mb-3">
                            <label for="" class="form-label">Fecha Final</label>
                            <input class="form-control mr-sm-2" type="date" name="fecha2" id="fecha_final"
                                value="" min="2015-01-01" max="{{ GetDateToday() }}"
                                style="text-align: center">
                            <span id="invalid_fecha_final" class="form-text text-danger"></span>
                        </div>
                        <div class="btn-group" role="group" aria-label="Basic example">
                            <button class="btn btn-success" style="font-size: 14px" id="btn_buscar" type="button"><i
                                    class="fas fa-search"></i>
                                Buscar</button>
                            <a class="btn btn-secondary" style="font-size: 14px" href="{{ route('search') }}"><i
                                    class="fas fa-sync"></i>
                                Limpiar Filtros</a>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-md-9 card">
                <div class="card-body">
                    <div class="row h-100">
                        <div class="col-md-12">
                            <table id="table-patentes" class="table pb-3">
                                <thead>
                                    <th style="text-align: center;">N°</th>
                                    <th style="text-align: center;">Patente</th>
                                    <th style="text-align: center;">Hora Entrada</th>
                                    <th style="text-align: center;">Hora Salida</th>
                                    <th style="text-align: center;">Fecha</th>
                                    <th style="text-align: center;">Tiempo Estimado</th>
                                </thead>
                                <tbody id="tbody">
                                </tbody>
                            </table>
                        </div>
                        <div class="col-12 d-flex justify-content-center align-items-center">
                            <div class="text-center preload-spinner" id="preload-spinner">
                            </div>
                            <br>
                        </div>
                        <br>
                        <br>
                        <div class="col-12">
                            <div class="d-flex justify-content-center" id="pagination-buttons">
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
