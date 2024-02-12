@extends('layouts.layout_main_view')
@section('content')

    <style>
        .v-line {
            border-left: 0.5px solid rgb(197, 197, 197);
            height: 150%;
            left: 50%;
            position: absolute;
        }
    </style>
    {{-- -------------------------------------RANGO ETARIO ID = 1------------------------------------------------------- --}}
    @if (!empty($rangoEtario))
        @foreach ($rangoEtario as $entrada)
            <div class="container">
                <div class="row d-flex justify-content-center">
                    <div class="col-md-4">
                        <div class="info-box mb-3">
                            <span class="info-box-icon bg-primary elevation-1"><i class="fas fa-clock"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text"><b>Última Actualización</b></span>
                                <span class="info-box-number">
                                    {{ !empty($entrada) ? $entrada->time : 'Sin Información' }}
                                </span>
                            </div>
                        </div>
                    </div>
                    <header>
                        <br>
                        <h1 class="text-center">
                            {{ !empty($entrada->titulo_entrada) ? $entrada->titulo_entrada : 'Datos' }}
                        </h1>
                        <br>
                    </header>

                </div>
                <div class="row">
                    <div class=" col-md-6 card mt-1">
                        <figure class="highcharts-figure">
                            <div id="chartGenero_{{ $entrada->id }}"></div>
                        </figure>
                        <div class="col-md-12">
                            <div class="" style="">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <h3 style="text-align: left; text-decoration: underline">Visitantes</h3>
                                        </div>
                                    </div>
                                    <table class="table table-hover">
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
                                                    {{ !empty($entrada->hombres) ? formatear_miles_coma($entrada->hombres) : 'Sin Información' }}%
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    Mujeres
                                                </td>
                                                <td>
                                                    {{ !empty($entrada->mujeres) ? formatear_miles_coma($entrada->mujeres) : 'Sin Información' }}%
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
                                <div id="chartRango_{{ $entrada->id }}"></div>
                            </figure>
                            <div class="col-md-12">
                                <div class="">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <h3 style="text-align: left; text-decoration: underline">Rango de Edad</h3>
                                            </div>
                                        </div>
                                        <table class="table table-hover">
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
                                                        {{ !empty($entrada->nino) ? formatear_miles_coma($entrada->nino) . '%' : 'Sin Información' }}
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td>
                                                        Adolecentes
                                                    </td>
                                                    <td>
                                                        12 - 18
                                                    </td>
                                                    <td>
                                                        {{ !empty($entrada->adolescente) ? formatear_miles_coma($entrada->adolescente) . '%' : 'Sin Información' }}
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
                                                        {{ !empty($entrada->joven) ? formatear_miles_coma($entrada->joven) . '%' : 'Sin Información' }}
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
                                                        {{ !empty($entrada->adulto) ? formatear_miles_coma($entrada->adulto) . '%' : 'Sin Información' }}
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
                                                        {{ !empty($entrada->anciano) ? formatear_miles_coma($entrada->anciano) . '%' : 'Sin Información' }}
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
            <hr>
        @endforeach
    @endif


@endsection
