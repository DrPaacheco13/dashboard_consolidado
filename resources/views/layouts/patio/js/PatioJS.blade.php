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
                @foreach ($camaraSectorAnterior as $item)
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
                @foreach ($camaraSectorAnterior as $dAyer)
                    {{ abs($dAyer->tEntrada) }},
                @endforeach
            ],
            borderColor: "#5997DE"
        }]
    });
</script>
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
                        @foreach ($dAyerGrafico as $item)
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
                        @foreach ($dAyerGrafico as $tPersonasAnts)
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
                @foreach ($datosAnuales as $item)
                    '{{ $item->mes }}',
                @endforeach
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
            name: 'Cantidad Personas Columnas',
            type: 'column',
            data: [
                @foreach ($datosAnuales as $item)
                    {{ $item->tEntradas }},
                @endforeach
            ],

        }, {
            name: 'Cantidad Personas Lineal',
            type: 'spline',
            data: [
                @foreach ($datosAnuales as $item)
                    {{ $item->tEntradas }},
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
            text: 'Estadísticas del mes de {{ $mesActual }}'
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
            name: 'Entrada',
            data: [
                @foreach ($datosMensuales as $item)
                    {{ $item->tEntrada }},
                @endforeach
            ]
        }]
    });
</script>
<script>
    let datosMesAnterior = @json($comparativoMesAnterior ?? []);
    let datosMesActual = @json($comparativoMesActual ?? []);

    const diasSemana = ['Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes', 'Sabado', 'Domingo'];

    diasSemana.forEach(dia => {
        crearGraficoPorDia(dia, datosMesActual);
        crearGraficoPorDia(dia, datosMesAnterior, 'ANT');
    });

    // Función para filtrar los datos por día de la semana
    function filtrarDatosPorDia(dia, datos) {
        return datos.filter(item => item.dia === dia);
    }

    function crearGraficoPorDia(dia, data, ext = '') {
        const datosFiltrados = filtrarDatosPorDia(dia, data);
        console.log(dia);
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
