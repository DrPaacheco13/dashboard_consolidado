@if (!empty($rangoEtario))
    <div class="container">
        @foreach ($rangoEtario as $entrada)
            <div class="card card-body">
                {{-- <div class="row d-flex justify-content-center">
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
                
            </div> --}}
                <div class="row">
                    <div class="col-12">

                        <h3 class="text-center">
                            {{ !empty($entrada->titulo_entrada) ? $entrada->titulo_entrada : 'Sin Asignar' }}
                        </h3>
                    </div>
                    <div class="col-md-6">
                        <figure class="highcharts-figure">
                            <div id="chartGenero_{{ $entrada->id }}"></div>
                        </figure>
                    </div>
                    <div class="col-md-6 d-flex align-items-center">
                        <table class="table table-bordered text-center">
                            <thead>
                                <tr>
                                    <th colspan="2">VISITANTES</th>
                                    {{-- <th>CANTIDAD</th> --}}
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Hombres</td>
                                    <td class="text-right">
                                        {{ !empty($entrada->hombres) ? formatear_miles_coma($entrada->hombres) : 'Sin Información' }}%
                                    </td>
                                    <!-- Aquí debes reemplazar $cantidad_hombres con la variable que contiene la cantidad de visitantes hombres -->
                                </tr>
                                <tr>
                                    <td>Mujeres</td>
                                    <td class="text-right">
                                        {{ !empty($entrada->mujeres) ? formatear_miles_coma($entrada->mujeres) : 'Sin Información' }}%
                                    </td>
                                    <!-- Aquí debes reemplazar $cantidad_mujeres con la variable que contiene la cantidad de visitantes mujeres -->
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <figure class="highcharts-figure">
                            <div id="chartRango_{{ $entrada->id }}"></div>
                        </figure>
                    </div>
                    <div class="col-md-6 d-flex align-items-center">
                        <table class="table table-bordered text-center">
                            <thead>
                                <tr>
                                    <th class="text-center" colspan="2">
                                        RANGOS DE EDAD
                                    </th>
                                    {{-- <th>
                                    Rango
                                </th>
                                <th>
                                    Porcentaje
                                </th> --}}
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        Niños
                                    </td>
                                    {{-- <td>
                                    0 - 11
                                </td> --}}
                                    <td class="text-right">
                                        {{ !empty($entrada->nino) ? formatear_miles_coma($entrada->nino) . '%' : 'Sin Información' }}
                                    </td>
                                </tr>

                                <tr class="text-center">
                                    <td>
                                        Adolecentes
                                    </td>
                                    {{-- <td>
                                    12 - 18
                                </td> --}}
                                    <td class="text-right">
                                        {{ !empty($entrada->adolescente) ? formatear_miles_coma($entrada->adolescente) . '%' : 'Sin Información' }}
                                    </td>
                                </tr>
                                <tr class="text-center">
                                    <td>
                                        Joven
                                    </td>
                                    {{-- <td>
                                    19 - 26
                                </td> --}}
                                    <td class="text-right">
                                        {{ !empty($entrada->joven) ? formatear_miles_coma($entrada->joven) . '%' : 'Sin Información' }}
                                    </td>
                                </tr>
                                <tr class="text-center">
                                    <td>
                                        Adulto
                                    </td>
                                    {{-- <td>
                                    27 - 59
                                </td> --}}
                                    <td class="text-right">
                                        {{ !empty($entrada->adulto) ? formatear_miles_coma($entrada->adulto) . '%' : 'Sin Información' }}
                                    </td>
                                </tr>
                                <tr class="text-center">
                                    <td>
                                        Adulto Mayor
                                    </td>
                                    {{-- <td>
                                    60 +
                                </td> --}}
                                    <td class="text-right">
                                        {{ !empty($entrada->anciano) ? formatear_miles_coma($entrada->anciano) . '%' : 'Sin Información' }}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    <hr>
@endif

@if (!empty($rangoEtario))
    @foreach ($rangoEtario as $entrada)
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
