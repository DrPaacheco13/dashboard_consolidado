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
    @if (!empty($rangoEtarioAnterior))
        @foreach ($rangoEtarioAnterior as $entrada)
            <div class="container">
                <div class="row">
                    <header>
                        <h1 style="white-space: pre; font-size: 1.8rem; text-align: center">
                            {{ !empty($entrada->titulo_entrada) ? $entrada->titulo_entrada : 'Camara' }}</h1>
                        <br>
                    </header>
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




    {{-- -------------------------------------------------------------------------------------------- --}}
    @if (!empty($rangoEtarioAnterior))
        @foreach ($rangoEtarioAnterior as $entrada)
            <script>
                Highcharts.chart('chartGenero_' + {{ $entrada->id }}, {
                    colors: ['#2277EA', '#FF6961'],
                    chart: {
                        plotBackgroundColor: null,
                        plotBorderWidth: null,
                        plotShadow: false,
                        type: 'pie'
                    },
                    title: {
                        text: 'Género'
                    },
                    tooltip: {
                        pointFormat: '{series.name}: <b>{point.percentage:.2f}%</b>'
                    },
                    credits: {
                        enabled: false
                    },
                    accessibility: {
                        point: {
                            valueSuffix: '%'
                        }
                    },
                    plotOptions: {
                        pie: {
                            allowPointSelect: true,
                            cursor: 'pointer',
                            dataLabels: {
                                enabled: true,
                                format: '<b>{point.name}</b>: {point.percentage:.2f} %'
                            }
                        }
                    },
                    series: [{
                        name: 'Porcentaje',
                        colorByPoint: true,
                        data: [{
                                name: 'Hombres',
                                y: {{ !empty($entrada->hombres) ? $entrada->hombres : 0 }}
                            },
                            {
                                name: 'Mujeres',
                                y: {{ !empty($entrada->mujeres) ? $entrada->mujeres : 0 }}
                            }
                        ]
                    }]
                });
            </script>
            <script>
                Highcharts.chart('chartRango_' + {{ $entrada->id }}, {
                    colors: ['#33B2FF', '#9149c4', '#3e962c', '#F7A35C', '#dd5e5e'],
                    chart: {
                        plotBackgroundColor: null,
                        plotBorderWidth: null,
                        plotShadow: false,
                        type: 'pie'
                    },
                    title: {
                        text: 'Rango Etario'
                    },
                    tooltip: {
                        pointFormat: '{series.name}: <b>{point.percentage:.2f}%</b>'
                    },
                    credits: {
                        enabled: false
                    },
                    accessibility: {
                        point: {
                            valueSuffix: '%'
                        }
                    },
                    plotOptions: {
                        pie: {
                            allowPointSelect: true,
                            cursor: 'pointer',
                            dataLabels: {
                                enabled: true,
                                format: '<b>{point.name}</b>: {point.percentage:.2f} %'
                            }
                        }
                    },
                    series: [{
                        name: 'Porcentaje',
                        colorByPoint: true,
                        data: [{
                                name: 'Niños',
                                y: {{ !empty($entrada->nino) ? $entrada->nino : 0 }}
                            },
                            {
                                name: 'Adolecentes',
                                y: {{ !empty($entrada->adolescente) ? $entrada->adolescente : 0 }}
                            },
                            {
                                name: 'Jovenes',
                                y: {{ !empty($entrada->joven) ? $entrada->joven : 0 }}
                            },
                            {
                                name: 'Adultos',
                                y: {{ !empty($entrada->adulto) ? $entrada->adulto : 0 }}
                            },
                            {
                                name: 'Adulto Mayor',
                                y: {{ !empty($entrada->anciano) ? $entrada->anciano : 0 }}
                            }
                        ]
                    }]
                });
            </script>
        @endforeach
    @endif

@endsection
