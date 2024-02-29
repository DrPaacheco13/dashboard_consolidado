<div class="container" style="align-content: center">

    <div class="row">
        <div class="col-xl-9">
            <div id="EntradaHoy" class="col-md-12 shadow-sm chartHoy card graHoy" style="margin-top: 15px;"></div>
        </div>
        <div class="col-xl-3 d-flex align-items-center text-center">
            <div class="card card-body">
                <br>
                <h3>Flujo de Vehiculos</h3>
                <br>
                <p>Total Entradas</p>
                <b>{{ !empty($aforo_actual[0]) ? formatear_miles($aforo_actual[0]->totalenter) : 0 }}</b>
                <br>
                <p>Estadía Promedio</p>
                <b>{{ !empty($aforo_actual[0]) ? $aforo_actual[0]->estadia : 0 }}</b>
                <br>
            </div>
        </div>
    </div>
    <?php /* 
    <div class="row">
        <div class="col-md-4 card shadow-sm">
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
                            @foreach ($aforo_ayer as $tPersonasAnt)
                                {{ number_format($tPersonasAnt->totalenter, 0, ',', '.') }}
                            @endforeach
                        </td>
                    </tr>
                </tbody>
            </table>
            <div style="text-align: center; margin-top: 50px;">
                <i class='bx bxs-car' style="font-size: 250px"></i>
            </div>
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
    <p class="display-8 datosOtros" style="margin-top: 10px;">
    <h5>Estadísticas consolidadas del mes</h5>
    </p>
    <div class="row">
        <div class="col-md-12 card shadow-sm aforoDiaAnterior">
            <div>
                <div id="acumuladoMensual"></div>
            </div>
        </div>
    </div>
    <hr>

    <p class="display-8 datosOtros" style="margin-top: 10px;">
    <h5>Estadísticas consolidadas del año</h5>
    </p>
    <div class="row">
        <div class="col-md-12 card shadow-sm aforoDiaAnterior">
            <div>
                <div id="acumuladoAnual"></div>
            </div>
        </div>
    </div>
*/
    ?>

</div>

<?php /*
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
--}} */
?>
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
<?php /*
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
*/
?>
