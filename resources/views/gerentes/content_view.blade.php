<div class="container-xl">

    <div class="row">
        <div class="col-xl-9">
            <div id="segmentos_{{ $region }}" class="shadow-sm" style="margin-top: 15px;"></div>
        </div>
        <div class="col-xl-3 d-flex align-items-center text-center">
            <div class="card card-body">
                <br>
                {{-- <h3>Flujo de Clientes</h3> --}}
                {{-- <br> --}}
                <h3>Total Entradas</h3>
                <b>{{ !empty($aforo_actual[0]) ? formatear_miles($aforo_actual[0]->Entradas) : 0 }}</b>
                <br>
            </div>
        </div>
    </div>

    <?php /*
    <hr>
    <p class="display-8 datosOtros" style="margin-top: 10px;">
    <div class="row">
        <div class="col-md-3">
            <p class="datosHoy display-8" style="margin-left: 11px">
            <h5>Estadísticas del día anterior</h5>
        </div>
        <div class="col-md-6" style="text-align: center; margin-top: 15px">
            <h5>
                <p>{{ GetYesterdayText() }}</p>
            </h5>
        </div>
    </div>
    </p>
    <div class="row">
        <div class="col-md-{{ !empty((array)$entradasCamaraAyer) ? '4' : '6' }} card shadow-sm">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th style="font-size: 20px;">
                            Item
                        </th>
                        <th style="font-size: 20px;">
                            Número
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td style="font-size: 20px;">
                            Total entradas
                        </td>
                        <td style="font-size: 20px;">
                            {{ !empty($aforo_ayer) ? formatear_miles($aforo_ayer) : 'Sin Información' }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div style="text-align: center; margin-top: 50px;">
                <i class="fa-solid fa-person-walking-arrow-right fa-10x"></i>
            </div>
        </div>
        <div class="col-md-{{ !empty((array)$entradasCamaraAyer) ? '4' : '6' }} card shadow-sm">
            <div>
                <div id="containerDona_{{ $region }}"></div>
            </div>
        </div>
        @if (!empty((array) $entradasCamaraAyer))
            <div class="col-md-4 card shadow-sm">
                <div>
                    <div id="container_{{ $region }}"></div>
                </div>
            </div>
        @endif
    </div>
    <hr>
    <p class="display-8" style="margin-top: 10px;">
    <h5>Estadísticas consolidadas del mes</h5>
    </p>
    <div class="row">
        <div class="col-md-12 card shadow-sm">
            <div>
                <div id="acumuladoMensual_{{ $region }}"></div>
            </div>
        </div>
    </div>
    <hr>

    <p class="display-8 datosOtros" style="margin-top: 10px;">
    <h5>Estadísticas consolidadas del año</h5>
    </p>
    <div class="row">
        <div class="col-md-12 card shadow-sm">
            <div>
                <div id="acumuladoAnual_{{ $region }}"></div>
            </div>
        </div>
    </div>
    <hr>
    {{-- ------------------------------------------------------------------------------------------------------------------------------- --}}
    <h5>Estadísticas comparativas del mes de {{ mesActualTexto() }}</h5>
    <h6 style="font-size: 11px;">Para visualizar cantidad, posicionar mouse encima de la barra</h6>
    </p>
    <div class="row">
        {{-- <div>
                    <div id="comparativasMes"></div>
                </div> --}}
        <div class="col-md-4 card shadow-sm">
            <div id="comparativasMesLunes_{{ $region }}"></div>
        </div>
        <div class="col-md-4 card shadow-sm">
            <div id="comparativasMesMartes_{{ $region }}"></div>
        </div>
        <div class="col-md-4 card shadow-sm">
            <div id="comparativasMesMiercoles_{{ $region }}"></div>
        </div>
        <div class="col-md-6 card shadow-sm">
            <div id="comparativasMesJueves_{{ $region }}"></div>
        </div>
        <div class="col-md-6 card shadow-sm">
            <div id="comparativasMesViernes_{{ $region }}"></div>
        </div>
    </div>
    &nbsp;
    <div class="row">
        <div class="col-md-6 card shadow-sm">
            <div id="comparativasMesSabado_{{ $region }}"></div>
        </div>
        <div class="col-md-6 card shadow-sm">
            <div id="comparativasMesDomingo_{{ $region }}"></div>
        </div>
    </div>

    <hr>

    {{-- ------------------------------------------------------------------------------------------------------------------------------- --}}
    {{-- ------------------------------------------------------------------------------------------------------------------------------- --}}
    <h5>Estadísticas comparativas del mes de {{ mesAnteriorTexto() }}</h5>
    <h6 style="font-size: 11px;">Para visualizar cantidad, posicionar mouse encima de la barra</h6>
    </p>
    <div class="row" style="anchor: 2000px;">
        {{-- <div>
                <div id="comparativasMes"></div>
            </div> --}}
        <div class="col-md-4 card shadow-sm">
            <div id="comparativasMesLunesANT_{{ $region }}"></div>
        </div>
        <div class="col-md-4 card shadow-sm">
            <div id="comparativasMesMartesANT_{{ $region }}"></div>
        </div>
        <div class="col-md-4 card shadow-sm">
            <div id="comparativasMesMiercolesANT_{{ $region }}"></div>
        </div>
        <div class="col-md-6 card shadow-sm">
            <div id="comparativasMesJuevesANT_{{ $region }}"></div>
        </div>
        <div class="col-md-6 card shadow-sm">
            <div id="comparativasMesViernesANT_{{ $region }}"></div>
        </div>
    </div>
    &nbsp;
    <div class="row">
        <div class="col-md-6 card shadow-sm">
            <div id="comparativasMesSabadoANT_{{ $region }}"></div>
        </div>
        <div class="col-md-6 card shadow-sm">
            <div id="comparativasMesDomingoANT_{{ $region }}"></div>
        </div>
    </div>
    */
    ?>
</div>

<script type="text/javascript">
    Highcharts.chart("segmentos_{{ $region }}", {
        colors: ['#f7a311', '#346DA4', '#7CB5EC', '#a9cef2'],
        chart: {
            type: "spline",
            zoomType: "xy"
        },
        title: {
            text: "Flujo de Clientes",
            style: {
                fontSize: '30px' // Tamaño de letra para el título del gráfico
            }
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
            categories: [
                @foreach ($personasSegmentoHoy as $item)
                    '{{ $item->segmento }}',
                @endforeach
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
                @foreach ($personasSegmentoHoy as $toDay)
                    {{ $toDay->Entrada }},
                @endforeach
            ]
        }]
    });
</script>


<?php
/*
{{-- Entradas Por Camara! --}}
@if (!empty($entradasCamaraAyer))
    <script type="text/javascript">
        Highcharts.chart("container_{{ $region }}", {
            colors: ['#346DA4', '#7CB5EC', '#a9cef2'],
            chart: {
                type: "bar",
                zoomType: "xy"
            },
            title: {
                text: "Entradas por cámaras"
            },
            plotOptions: {
                column: {
                    dataLabels: {
                        enabled: true
                    }
                }
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
                categories: [
                    @foreach ($entradasCamaraAyer as $item)
                        '{{ $item->nombre }}',
                    @endforeach
                ]
            },
            legend: {
                enabled: true
            },
            credits: {
                enabled: false
            },
            series: [{
                name: "Entradas",
                data: [
                    @foreach ($entradasCamaraAyer as $dAyer)
                        {{ abs($dAyer->tEntrada) }},
                    @endforeach
                ],
                borderColor: "#5997DE"
            }]
        });
    </script>
@endif
{{-- Entradas VS Salida Día Anterior --}}
<script>
    {
        document.addEventListener('DOMContentLoaded', function() {
            const chart = Highcharts.chart('containerDona_{{ $region }}', {
                colors: ['#346DA4', '#f7a311', '#7CB5EC', '#a9cef2'],
                chart: {
                    type: 'line'
                },
                title: {
                    text: 'Entradas'
                },
                xAxis: {
                    categories: [
                        @foreach ($personasSegmentoAyer as $item)
                            '{{ $item->segmento }}',
                        @endforeach
                    ]
                },
                yAxis: {
                    title: {
                        text: 'Cantidad'
                    }
                },
                credits: {
                    enabled: false
                },
                series: [{
                    name: 'Entradas',
                    data: [
                        @foreach ($personasSegmentoAyer as $tPersonasAnts)
                            {{ $tPersonasAnts->Entradas }},
                        @endforeach
                    ]
                }]
            });
        });
    }
</script>

{{-- Total Entradas Dia Actual --}}



<script>
    Highcharts.chart('acumuladoAnual_{{ $region }}', {
        colors: ['#346DA4', '#f7a311', '#7CB5EC', '#a9cef2'],
        title: {
            text: 'Total de entradas por mes',
            align: 'center'
        },
        xAxis: [{
            categories: [
                'Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio',
                'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'
            ],
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
        plotOptions: {
            column: {
                dataLabels: {
                    enabled: true
                }
            }
        },
        tooltip: {
            shared: true
        },
        legend: {
            enable: true,
        },
        credits: {
            enabled: false
        },
        series: [{
            name: 'Cantidad Personas 2024',
            type: 'column',
            data: [
                @foreach ($datosAnuales as $item)
                    @if (!empty($item->tEntradas))
                        {{ $item->tEntradas }},
                    @else
                        0,
                    @endif
                @endforeach
            ],

        }, {
            name: 'Cantidad Personas 2023',
            type: 'column',
            data: [
                @foreach ($datosAnualesAnt as $item)
                    @if (!empty($item))
                        {{ $item->tEntradas ?? ($item->tEntrada ?? 0) }},
                    @else
                        0,
                    @endif
                @endforeach

            ]
        }]
    });
</script>
<script>
    Highcharts.chart('acumuladoMensual_{{ $region }}', {
        colors: ['#346DA4', '#f7a311', '#7CB5EC', '#a9cef2'],
        chart: {
            type: 'column',
        },
        title: {
            text: 'Estadísticas del mes de {{ mesActualTexto() }}'
        },
        xAxis: {
            categories: [
                @foreach ($datosMensuales as $item)
                    '{{ $item->date }}',
                @endforeach
            ],
            title: {
                text: null
            }
        },
        yAxis: {
            title: {
                text: 'Cantidad'
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
            borderColor: '#555',
            backgroundColor: 'rgba(255, 255, 255, 0.93)'
        },
        legend: {
            enabled: true
        },
        credits: {
            enabled: false
        },
        series: [{
            name: 'Entrada 2024',
            data: [
                @foreach ($datosMensuales as $item)
                    {{ $item->tEntrada }},
                @endforeach
            ]
        }, {
            name: 'Entrada 2023',
            type: 'column',
            data: [
                @if (!empty($datosMensualesAnt))
                    @foreach ($datosMensualesAnt as $item)
                        @if (!empty($item))
                            {{ $item->tEntrada }},
                        @else
                            0,
                        @endif
                    @endforeach
                @endif
            ]
        }]
    });
</script>

<script>
    datosMesAnterior = @json($comparativoMesAnterior ?? []);
    datosMesActual = @json($comparativoMesActual ?? []);

    diasSemana = ['Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes', 'Sabado', 'Domingo'];

    diasSemana.forEach(dia => {
        crearGraficoPorDia(dia, datosMesActual);
        crearGraficoPorDia(dia, datosMesAnterior, 'ANT');
        setTimeout(() => {}, 15);
    });

    // Función para filtrar los datos por día de la semana
    function filtrarDatosPorDia(dia, datos) {
        return datos.filter(item => item.dia === dia);
    }

    function crearGraficoPorDia(dia, data, ext = '') {
        const datosFiltrados = filtrarDatosPorDia(dia, data);
        let colors = obtenerColoresPorDia(dia);
        Highcharts.chart('comparativasMes' + dia + ext + '_{{ $region }}', {
            colors: colors,
            chart: {
                type: 'column',
            },
            title: {
                text: dia
            },
            xAxis: {
                categories: datosFiltrados.map(item => item.date),
                title: {
                    text: null
                }
            },
            yAxis: {
                title: {
                    text: 'Cantidad'
                },
                labels: {
                    overflow: 'justify'
                }
            },
            tooltip: {
                stickOnContact: true,
                borderColor: '#555',
                backgroundColor: 'rgba(255, 255, 255, 0.93)'
            },
            legend: {
                enabled: true
            },
            credits: {
                enabled: false
            },
            series: [{
                name: 'Entrada',
                data: datosFiltrados.map(item => item.entrada)
            }]
        });
    }

    function obtenerColoresPorDia(dia) {
        let colors;
        switch (dia) {
            case 'Domingo':
                colors = ['#3C07A3', '#f7a11', '#7CB5EC', '#a9cef2'];
                break;
            case 'Sabado':
                colors = ['#6D071A', '#f7a11', '#7CB5EC', '#a9cef2'];
                break;
            case 'Viernes':
                colors = ['#898989', '#f7a11', '#7CB5EC', '#a9cef2'];
                break;
            case 'Jueves':
                colors = ['#4F8D44', '#f7a11', '#7CB5EC', '#a9cef2'];
                break;
            case 'Miercoles':
                colors = ['#FF9601', '#f7a311', '#7CB5EC', '#a9cef2'];
                break;
            case 'Martes':
                colors = ['#FB3437', '#f7a11', '#7CB5EC', '#a9cef2'];
                break;
            case 'Lunes':
            default:
                colors = ['#346DA4', '#f7a11', '#7CB5EC', '#a9cef2'];
                break;
        }
        return colors;
    }
</script>
*/
?>
