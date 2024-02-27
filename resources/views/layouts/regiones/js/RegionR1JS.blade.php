{{-- Entradas Por Camara! --}}
@if (!empty($entradasCamaraAyer))
    <script type="text/javascript">
        Highcharts.chart("container", {
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
            const chart = Highcharts.chart('containerDona', {
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

<script type="text/javascript">
    Highcharts.chart("EntradaHoy", {
        colors: ['#f7a311', '#346DA4', '#7CB5EC', '#a9cef2'],
        chart: {
            type: "spline",
            zoomType: "xy"
        },
        title: {
            text: "Entrada"
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

<script>
    Highcharts.chart('acumuladoAnual', {
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
                        {{ $item->tEntradas }},
                    @else
                        0,
                    @endif
                @endforeach
            ],
        }]
    });
</script>

<script>
    Highcharts.chart('acumuladoMensual', {
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
                    @if (!empty($item))
                        '{{ $item->date }}',
                    @endif
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
                    @if (!empty($item->tEntrada))
                        {{ $item->tEntrada }},
                    @endif
                @endforeach
            ]
        }, {
            name: 'Entrada 2023',
            data: [
                @foreach ($datosMensualesAnt as $item)
                    @if (!empty($item->tEntrada))
                        {{ $item->tEntrada }},
                    @endif
                @endforeach
            ]
        }]
    });
</script>

<script>
    let datosMesActual = @json($comparativoMesActual ?? '');
    let datosMesAnterior = @json($comparativoMesAnterior ?? '');
    // console.log(datosMesActual);

    const diasSemana = ['Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes', 'Sabado', 'Domingo'];

    diasSemana.forEach(dia => {
        crearGraficoPorDia(dia, datosMesActual);
        // console.log(datosMesAnterior);
        if (Array.isArray(datosMesAnterior) && datosMesAnterior.length > 0) {
            console.log('siu');
            crearGraficoPorDia(dia, datosMesAnterior, 'ANT');
        }
    });

    // Función para filtrar los datos por día de la semana
    function filtrarDatosPorDia(dia, data) {
        if (!Array.isArray(data)) {
            console.error('Error: La variable "datos" no es un array.');
            return []; // o manejar el error de acuerdo a tus necesidades
        }
        return data.filter(item => item.dia === dia);
    }

    function crearGraficoPorDia(dia, data, ext = '') {
        const datosFiltrados = filtrarDatosPorDia(dia, data);
        let colors = obtenerColoresPorDia(dia);
        Highcharts.chart('comparativasMes' + dia + ext, {
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
