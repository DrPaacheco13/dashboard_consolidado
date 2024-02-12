
{{-- Entradas Por Camara! --}}
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
                @foreach ($camara_sector_anterior as $item)
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
                @foreach ($camara_sector_anterior as $dAyer)
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
                        @foreach ($aforo_ayer_grafico as $item)
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
                        @foreach ($aforo_ayer_grafico as $tPersonasAnts)
                            {{ $tPersonasAnts->Entrada }},
                        @endforeach
                    ]
                }]
            });
        });
    }
</script>

{{-- Total Entradas Dia Actual --}}
{{-- Total de entradas por mes
--}}
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
                @foreach ($aforo_hoy_grafico as $item)
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
                @foreach ($aforo_hoy_grafico as $toDay)
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
                @foreach ($datos_anuales as $item)
                    '{{ $item->mes }} - {{ $item->year }}',
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
            name: 'Cantidad de vehiculos',
            type: 'column',
            data: [
                @foreach ($datos_anuales as $item)
                    {{ $item->tEntrada }},
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
                @foreach ($datos_mensuales as $item)
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
                @foreach ($datos_mensuales as $item)
                    {{ $item->tEntrada }},
                @endforeach
            ]
        }]
    });
</script>
