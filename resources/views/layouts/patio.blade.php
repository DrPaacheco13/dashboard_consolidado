@extends('layouts.layout_main_view')

@section('content')
    <div class="border-0 pb-0">
        <div class="row align-items-center" style="margin-left: 5%;">
            <h1 class="display-6 mb-0" style="text-align: center; margin-top: 25px;">Flujos Clientes - Vivo San Fernando -
                Patio de Comidas</h1>
        </div>
    </div>
    <div class="container" style="align-content: center">
        <div class="linea"></div>
        <div class="container">
            <hr>
            <div class="row">
                <div class="col-md-3">
                    <p class="datosHoy display-8" style="margin-left: 11px">
                    <h5>Estadísticas del día actual</h5>
                </div>
                <div class="col-md-6" style="text-align: center; margin-top: 15px">
                    <h5>
                        <p>{{ ucwords($fechaHoy) }}</p>
                    </h5>
                </div>
                <div class="col-md-3" style=" text-align: end;">
                    </p>
                    <p class="datosHoy display-8">
                    <h5>Última Actualización: @foreach ($uActualizacion as $item)
                            {{ $item->tiempo }}</h5>
                    @endforeach
                    </p>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-2 card shadow-sm aforo-dia">
                <div class="card-body texto-box">
                    <h6>Total Entradas</h6>
                    <br>
                    <div class="texto-ini">
                        @foreach ($dHoy as $item)
                            <h3>{{ number_format($item->Entradas, 0, ',', '.') }}</h3>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="col-md-2 card shadow-sm aforo-dia">
                <div class="card-body">
                    <h6>Total Salidas</h6>
                    <br>
                    @foreach ($dHoy as $item)
                        <h3>{{ number_format($item->Salidas, 0, ',', '.') }}</h3>
                    @endforeach
                </div>
            </div>
            <div class="col-md-2 card shadow-sm aforo-dia">
                <div class="card-body">
                    <h6>Aforo Aproximado</h6>
                    <br>
                    @foreach ($dHoy as $item)
                        <h3>{{ number_format(abs($item->Aforo), 0, ',', '.') }}</h3>
                    @endforeach
                </div>
            </div>
            <div class="col-md-2 card shadow-sm aforo-dia">
                <div class="card-body">
                    <h6>Porcentaje de Aforo</h6>
                    <br>
                    @foreach ($dHoy as $item)
                        <h3>{{ number_format($item->Porcentaje, 2, ',', '.') }}%</h3>
                    @endforeach
                </div>
            </div>
            <div class="col-md-2 card shadow-sm aforo-dia">
                <div class="card-body">
                    <h6>Aforo Máximo</h6>
                    <br>
                    @foreach ($dHoy as $item)
                        <h3>1.560</h3>
                    @endforeach
                </div>
            </div>
            <div id="EntradaVsSalidaHoy" class="col-md-5 shadow-sm chartHoy card graHoy" style="margin-top: 15px;"></div>
            <div id="TendenciaAforoHoy" class="col-md-5 shadow-sm chartHoy card graHoy" style="margin-top: 15px;"></div>
        </div>
        <hr>
        <div class="row">
            <div class="col-md-3">
                <p class="datosHoy display-8" style="margin-left: 11px">
                <h5>Estadísticas del día anterior</h5>
            </div>
            <div class="col-md-6" style="text-align: center; margin-top: 15px">
                <h5>
                    <p>{{ ucwords($endDate) }}</p>
                </h5>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4 card shadow-sm">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>
                                Item
                            </th>
                            <th>
                                Número
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                                Total Entradas
                            </td>
                            <td>
                                @foreach ($dAyer as $tPersonasAnts)
                                    {{ number_format($tPersonasAnts->Entradas, 0, ',', '.') }}
                                @endforeach
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Total Salidas
                            </td>
                            <td>
                                @foreach ($dAyer as $tPersonasAnts)
                                    {{ number_format($tPersonasAnts->Salidas, 0, ',', '.') }}
                                @endforeach
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Aforo Maximo
                            </td>
                            <td>
                                @foreach ($dAyer as $tPersonasAnts)
                                    {{ number_format($tPersonasAnts->AforoMaximo, 0, ',', '.') }}
                                @endforeach
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Aforo Minimo
                            </td>
                            <td>
                                @foreach ($dAyer as $tPersonasAnts)
                                    {{ number_format(abs($tPersonasAnts->AforoMinimo)) }}
                                @endforeach
                            </td>
                        </tr>
                        <tr>
                            <td>
                                % de Ocupación Máx.
                            </td>
                            <td>
                                @foreach ($dAyer as $tPersonasAnts)
                                    {{ number_format($tPersonasAnts->ocupacion, 2) }}%
                                @endforeach
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="col-md-4 card shadow-sm aforoDiaAnterior">
                <div>
                    <div id="containerDona"></div>
                </div>
            </div>
            <div class="col-md-4 card shadow-sm aforoDiaAnterior">
                <div>
                    <div id="container"></div>
                </div>
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="col-md-3">
                <p class="datosHoy display-8" style="margin-left: 11px">
                <h5>Estadísticas consolidadas</h5>
            </div>
            <div class="col-md-6" style="text-align: center; margin-top: 15px">
                <h5>
                    Semana del @foreach ($fechaSemanaPasada1 as $item)
                {{ $item->Fecha1 }}
                @endforeach al @foreach ($fechaSemanaPasada2 as $item2)
                    {{ $item2->Fecha2 }}
                @endforeach
                </h5>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4 card shadow-sm aforoDiaAnterior">
                <div>
                    <div id="acumuladoSemanaPasada"></div>
                </div>
            </div>
            <div class="col-md-4 card shadow-sm aforoDiaAnterior">
                <div>
                    <div id="promedioDiasSP"></div>
                </div>
            </div>
            <div class="col-md-4 card shadow-sm aforoDiaAnterior">
                <div>
                    <div id="comportamientoAforo"></div>
                </div>
            </div>
        </div>
        <hr>
        {{-- --------------------------------------------------------------------------------- --}}
        <p class="display-8 datosOtros" style="margin-top: 10px;">
        <h5>Estadísticas Consolidadas del año</h5>
        </p>
        <div class="row">
            <div class="col-md-12 card shadow-sm aforoDiaAnterior">
                <div>
                    <div id="acumuladoAnual"></div>
                </div>
            </div>
        </div>
        <hr>

    </div>
    {{-- Scripts --}}
    {{-- % Aforo Maximo y Minimo --}}
    <script type="text/javascript">
        Highcharts.chart("container", {
            colors: ['#346DA4', '#7CB5EC', '#a9cef2'],
            chart: {
                type: "spline",
                zoomType: "xy"
            },
            title: {
                text: "Tendencia Aforo"
            },
            xAxis: {
                crosshair: true,
                title: {
                    text: "Year"
                }
            },
            yAxis: {
                title: {
                    text: "Cantidad"
                }
            },
            xAxis: {
                categories: ['08:00', '09:00', '10:00', '11:00', '12:00', '13:00', '14:00', '15:00',
                    '16:00', '17:00', '18:00', '19:00', '20:00', '21:00', '22:00', '23:00'
                ]
            },
            legend: {
                enabled: true
            },
            credits: {
                enabled: false
            },
            series: [{
                name: "Tendencia de Flujo",
                data: [
                    @foreach ($dAyerGrafico as $dAyer)
                        {{ abs($dAyer->aforo) }},
                    @endforeach
                ],
                borderColor: "#5997DE"
            }]
        });
    </script>

    <script>
        {
            document.addEventListener('DOMContentLoaded', function() {
                const chart = Highcharts.chart('containerDona', {
                    colors: ['#f7a311', '#346DA4', '#7CB5EC', '#a9cef2'],
                    chart: {
                        type: 'line'
                    },
                    title: {
                        text: 'Salidas vs Entradas'
                    },
                    xAxis: {
                        categories: ['08:00', '09:00', '10:00', '11:00', '12:00', '13:00', '14:00', '15:00',
                            '16:00', '17:00', '18:00', '19:00', '20:00', '21:00', '22:00', '23:00'
                        ]
                    },
                    yAxis: {
                        title: {
                            text: 'Aforo'
                        }
                    },
                    credits: {
                        enabled: false
                    },
                    series: [{
                        name: 'Entradas',
                        data: [
                            @foreach ($dAyerGrafico as $tPersonasAnts)
                                {{ $tPersonasAnts->Entradas }},
                            @endforeach
                        ]
                    }, {
                        name: 'Salidas',
                        data: [
                            @foreach ($dAyerGrafico as $tPersonasAnts)
                                {{ $tPersonasAnts->Salidas }},
                            @endforeach
                        ]
                    }]
                });
            });
        }
    </script>
    {{-- Chart Datos Acumulados Semana Pasada --}}

    <script>
        {
            Highcharts.chart('acumuladoSemanaPasada', {
                colors: ['#346DA4', '#7CB5EC', '#a9cef2'],
                chart: {
                    type: 'column',
                    zoomType: 'y'
                },
                title: {
                    text: 'Ingresos máximos por día'
                },
                xAxis: {
                    categories: ['Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes', 'Sabado', 'Domingo'],
                    title: {
                        text: null
                    },
                    accessibility: {
                        description: 'Días'
                    }
                },
                yAxis: {
                    title: {
                        text: 'Promedio Máximo por Dia'
                    },
                    labels: {
                        overflow: 'justify'
                    }
                },
                plotOptions: {
                    column: {
                        dataLabels: {
                            enabled: true
                        }
                    }
                },
                legend: {
                    enabled: true
                },
                credits: {
                    enabled: false
                },
                series: [{
                    name: 'Maximos por Día',
                    data: [
                        @foreach ($semanaPasada as $semanaMaximos)
                            {{ $semanaMaximos->maximo }},
                        @endforeach
                    ],
                    borderColor: '#949494'
                }]
            });

        }
    </script>

    {{-- Promedio Visitas Diarias --}}

    <script>
        {
            document.addEventListener('DOMContentLoaded', function() {
                const chart = Highcharts.chart('promedioDiasSP', {
                    colors: ['#f7a311', '#346DA4', '#7CB5EC', '#a9cef2'],
                    chart: {
                        type: 'line'
                    },
                    title: {
                        text: 'Promedio Visitas Diarias'
                    },
                    xAxis: {
                        categories: ['Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes', 'Sabado',
                            'Domingo'
                        ]
                    },
                    yAxis: {
                        title: {
                            text: 'Aforo'
                        }
                    },
                    credits: {
                        enabled: false
                    },
                    series: [{
                        name: 'Entradas',
                        data: [
                            @foreach ($semanaPasada as $semanaMaximos)
                                {{ $semanaMaximos->promedio }},
                            @endforeach
                        ]
                    }]
                });
            });
        }
    </script>

    {{-- Comportamiento del Aforo --}}

    <script>
        {
            Highcharts.chart('comportamientoAforo', {
                colors: ['#346DA4', '#7CB5EC', '#a9cef2'],
                chart: {
                    type: 'column',
                    zoomType: 'y'
                },
                title: {
                    text: 'Comportamiento del Aforo'
                },
                xAxis: {
                    categories: ['Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes', 'Sabado', 'Domingo'],
                    title: {
                        text: null
                    },
                    accessibility: {
                        description: 'Countries'
                    }
                },
                yAxis: {
                    title: {
                        text: ''
                    },
                    labels: {
                        overflow: 'justify'
                    }
                },
                plotOptions: {
                    column: {
                        dataLabels: {
                            enabled: true
                        }
                    }
                },
                tooltip: {
                    stickOnContact: true,
                    backgroundColor: 'rgba(255, 255, 255, 0.93)'
                },
                legend: {
                    enabled: true
                },
                credits: {
                    enabled: false
                },
                series: [{
                    name: 'Aforo',
                    data: [
                        @foreach ($semanaPasada as $semanaMaximos)
                            {{ $semanaMaximos->aforo }},
                        @endforeach
                    ],
                    borderColor: '#949494'
                }]
            });
        }
    </script>
    <script type="text/javascript">
        Highcharts.chart("EntradaVsSalidaHoy", {
            colors: ['#f7a311', '#346DA4', '#7CB5EC', '#a9cef2'],
            chart: {
                type: "spline",
                zoomType: "xy"
            },
            title: {
                text: "Entrada VS Salida"
            },
            xAxis: {
                crosshair: true,
                title: {
                    text: "Year"
                }
            },
            yAxis: {
                title: {
                    text: "Cantidad"
                }
            },
            xAxis: {
                categories: ['08:00', '09:00', '10:00', '11:00', '12:00', '13:00', '14:00', '15:00',
                    '16:00', '17:00', '18:00', '19:00', '20:00', '21:00', '22:00', '23:00'
                ]
            },
            legend: {
                enabled: true
            },
            credits: {
                enabled: false
            },
            series: [{
                    name: "Entrada",
                    data: [
                        @foreach ($dHoyGrafico as $toDay)
                            {{ $toDay->Entrada }},
                        @endforeach
                    ]
                },
                {
                    name: "Salida",
                    data: [
                        @foreach ($dHoyGrafico as $toDay)
                            {{ $toDay->Salida }},
                        @endforeach
                    ]
                }
            ]
        });
    </script>
    <script type="text/javascript">
        Highcharts.chart("TendenciaAforoHoy", {
            colors: ['#346DA4', '#7CB5EC', '#a9cef2'],
            chart: {
                type: "spline",
                zoomType: "xy"
            },
            title: {
                text: "Tendencia Aforo"
            },
            xAxis: {
                crosshair: true,
                title: {
                    text: "Year"
                }
            },
            yAxis: {
                title: {
                    text: "Cantidad"
                }
            },
            xAxis: {
                categories: ['08:00', '09:00', '10:00', '11:00', '12:00', '13:00', '14:00', '15:00',
                    '16:00', '17:00', '18:00', '19:00', '20:00', '21:00', '22:00', '23:00'
                ]
            },
            legend: {
                enabled: true
            },
            credits: {
                enabled: false
            },
            series: [{
                name: "Tendencia de Flujo",
                data: [
                    @foreach ($dHoyGrafico as $toDay)
                        {{ abs($toDay->Aforo) }},
                    @endforeach
                ],
                borderColor: "#5997DE"
            }]
        });
    </script>

    <script>
        Highcharts.chart('acumuladoAnual', {
            colors: ['#346DA4', '#f7a311', '#7CB5EC', '#a9cef2'],
            chart: {
                zoomType: 'xy'
            },
            title: {
                text: 'Estadisticas por Mes',
                align: 'center'
            },
            xAxis: [{
                categories: ['Julio', 'Agosto', 'Septiembre', 'Octubre'],
                crosshair: true
            }],
            yAxis: [{ // Primary yAxis
                labels: {
                    style: {
                        color: Highcharts.getOptions().colors[1]
                    }
                },
                title: {
                    text: 'Cantidad',
                    style: {
                        color: Highcharts.getOptions().colors[1]
                    }
                }
            }, { // Secondary yAxis
                title: {
                    text: ''
                },
                opposite: true
            }],
            tooltip: {
                shared: true
            },
            legend: {
                enable: true,
            },
            credits:{
                enabled: false
            },
            series: [{
                name: 'Cantidad Personas Columnas',
                type: 'column',
                yAxis: 1,
                data: [@foreach ($graficoAnual as $anual)
                        {{ abs($anual->tEntradas) }},
                    @endforeach
                ],

            }, {
                name: 'Cantidad Personas Lineal',
                type: 'spline',
                data: [@foreach ($graficoAnual as $anual)
                        {{ abs($anual->tEntradas) }},
                    @endforeach
                ],
            }]
        });
    </script>
@endsection
