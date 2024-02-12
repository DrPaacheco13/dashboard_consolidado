@extends('layouts.layout_main_view')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-1"></div>
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header">
                        <h5 class="text-center">Seleccione una fecha para visualizar</h5>
                    </div>
                    <div class="card-body">
                        <form method="POST" id="formulario">
                            @csrf
                            <div class="row">
                                <div class="col-md-3 text-center">
                                    <div class="form-group">
                                        <label for="region" class="label-formulario">Seleccione región <span
                                                class="text-danger">*</span></label>
                                        <select class="form-control" style="text-align: center" name="region"
                                            id="region">
                                            <option {{ empty($region) ? 'selected' : '' }} value="0">
                                                Seleccione región
                                            </option>
                                            <option {{ !empty($region) && $region == 1 ? 'selected' : '' }} value="1">
                                                Región General
                                            </option>
                                            <option {{ !empty($region) && $region == 2 ? 'selected' : '' }} value="2">
                                                Región Externa
                                            </option>
                                        </select>
                                        <span id="invalid_region" class="text-danger"></span>
                                    </div>
                                </div>
                                <div class="col-md-3 text-center">
                                    <div class="form-group">
                                        <label for="fecha_inicial" class="label-formulario">Fecha Inicial <span
                                                class="text-danger">*</span></label>
                                        <input name="fecha_inicial"
                                            value="{{ !empty($fecha_inicial) ? $fecha_inicial : '' }}" id="fecha_inicial"
                                            class="form-control mr-sm-2" type="date" aria-label="Search"
                                            style="text-align: center" max="{{ GetDateToday() }}">
                                        <span id="invalid_fecha_inicial" class="text-danger"></span>
                                    </div>
                                </div>
                                <div class="col-md-3 text-center">
                                    <div class="form-group">
                                        <label for="fecha_final" class="label-formulario">Fecha Final<span
                                                class="text-danger">*</span></label>
                                        <input name="fecha_final" value="{{ !empty($fecha_final) ? $fecha_final : '' }}"
                                            id="fecha_final" class="form-control mr-sm-2 text-center" type="date"
                                            aria-label="Search" max="{{ GetDateToday() }}">
                                        <span id="invalid_fecha_final" class="text-danger"></span>
                                    </div>
                                </div>
                                <div class="col-md-3 d-flex justify-content-center align-items-end">
                                    <button class="btn btn-primary" type="button" id="btn_search">
                                        <i class="fas fa-spinner"></i>
                                        Cargar datos
                                    </button>
                                </div>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <style>
        .v-line {
            border-left: 0.5px solid rgb(197, 197, 197);
            height: 150%;
            left: 50%;
            position: absolute;
        }
    </style>
    {{-- -------------------------------------------------------------------------------------------- --}}
    <hr>
    <div class="container" style="display: none" id="container_grafico">
        <div class="row">
            <header>
                @if ($region == 1)
                    <h1 style="white-space: pre; font-size: 1.8rem; text-align: center">Cámara Acceso Lyon</h1>
                @elseif($region == 2)
                    <h1 style="white-space: pre; font-size: 1.8rem; text-align: center">Cámara Acceso P2</h1>
                @endif
                <br>
            </header>
            <div class=" col-md-6 card mt-1">
                <figure class="highcharts-figure">
                    <div id="chartHM"></div>
                </figure>
                <div class="col-md-12">
                    <div class="" style="">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <h3 style="text-align: left; text-decoration: underline">Visitantes</h3>
                                </div>
                            </div>
                            <table class="table table-hover table-visitantes">
                                <thead>
                                    <tr>
                                        <th>
                                            Ítem
                                        </th>
                                        <th>
                                            Porcentaje
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>
                                            Hombres
                                        </td>
                                        <td>
                                            @foreach ($rangoEtario as $item)
                                                {{ number_format($item->hombres, 2, ',', '.') }}%
                                            @endforeach
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            Mujeres
                                        </td>
                                        <td>
                                            @foreach ($rangoEtario as $item)
                                                {{ number_format($item->mujeres, 2, ',', '.') }}%
                                            @endforeach
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card mt-1">
                    <figure class="highcharts-figure">
                        <div id="chartRango"></div>
                    </figure>
                    <div class="col-md-12">
                        <div class="">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <h3 style="text-align: left; text-decoration: underline">Rango de Edad</h3>
                                    </div>
                                </div>
                                <table class="table table-hover table-rango-edad">
                                    <thead>
                                        <tr>
                                            <th>
                                                Ítem
                                            </th>
                                            <th>
                                                Rango
                                            </th>
                                            <th>
                                                Porcentaje
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>
                                                Niños
                                            </td>
                                            <td>
                                                0 - 11
                                            </td>
                                            <td>
                                                @foreach ($rangoEtario as $item)
                                                    {{ number_format($item->nino, 2, ',', '.') }}%
                                                @endforeach
                                            </td>
                                        </tr>

                                        <tr>
                                            <td>
                                                Adolescentes
                                            </td>
                                            <td>
                                                12 - 18
                                            </td>
                                            <td>
                                                @foreach ($rangoEtario as $item)
                                                    {{ number_format($item->adolecente, 2, ',', '.') }}%
                                                @endforeach
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                Joven
                                            </td>
                                            <td>
                                                19 - 26
                                            </td>
                                            <td>
                                                @foreach ($rangoEtario as $item)
                                                    {{ number_format($item->joven, 2, ',', '.') }}%
                                                @endforeach
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                Adulto
                                            </td>
                                            <td>
                                                27 - 59
                                            </td>
                                            <td>
                                                @foreach ($rangoEtario as $item)
                                                    {{ number_format($item->adulto, 2, ',', '.') }}%
                                                @endforeach
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                Adulto Mayor
                                            </td>
                                            <td>
                                                60 +
                                            </td>
                                            <td>
                                                @foreach ($rangoEtario as $item)
                                                    {{ number_format($item->anciano, 2, ',', '.') }}%
                                                @endforeach
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
