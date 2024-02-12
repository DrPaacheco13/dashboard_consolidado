<script>
    $(document).ready(function() {
        @if (!empty($datos_segmentados))
            $('#btn_exportar_pdf').prop('disabled', false);
            $('#btn_exportar_excel').prop('disabled', false);
            $('.col_card').css('display', 'block');
        @endif
        $('#fecha_inicial').change(function() {
            ValidaCampos('fecha_inicial', true, 'fecha');
        });

        $('#fecha_final').change(function() {
            ValidaCampos('fecha_final', true, 'fecha');
        });
        $('#tipo_filtro').change(function() {
            ValidaCampos('tipo_filtro', true, 'tipo_filtro', 'Campo Obligatorio');
        });
        $('#region').change(function() {
            ValidaCampos('region', true, 'select', 'Campo Obligatorio');
        });

        let nombre = $('#nombre').val();


        $('#btn_buscar').click(function() {
            let fecha_inicial = $('#fecha_inicial').val();
            let fecha_final = $('#fecha_final').val();
            let tipo_filtro = $('#tipo_filtro').val();
            let region = $('#region').val();

            let v_fecha_inicial = ValidaCampos('fecha_inicial', true, 'fecha');
            let v_fecha_final = ValidaCampos('fecha_final', true, 'fecha');
            let v_tipo_filtro = ValidaCampos('tipo_filtro', true, 'tipo_filtro', 'Campo Obligatorio');
            let v_region = ValidaCampos('region', true, 'select', 'Campo Obligatorio');

            if (v_fecha_inicial == 1 && v_fecha_final == 1 && v_tipo_filtro == 1 && v_region == 1) {
                let valida_fecha = validarFechas(fecha_inicial, fecha_final);
                if (valida_fecha === true) {
                    cargando();
                    $('#formulario').submit();
                } else {
                    toastr.error('Corroborar datos de fecha e intentar nuevamente por favor',
                        'Error de Validación');
                }
            } else {
                toastr.error('1 o más campos son requeridos. Por favor, ingréselos',
                    'Error de Validación');
            }
        });
        $('#btn_exportar_pdf').click(function(event) {
            let v_fecha_inicial = ValidaCampos('fecha_inicial', true, 'fecha');
            let v_fecha_final = ValidaCampos('fecha_final', true, 'fecha');
            let v_tipo_filtro = ValidaCampos('tipo_filtro', true, 'tipo_filtro', 'Campo Obligatorio');
            if (v_fecha_inicial == 0 || v_fecha_final == 0 || v_tipo_filtro == 0) {
                toastr.error('1 o más campos son requeridos. Por favor, ingréselos',
                    'Error de Validación');
                event.preventDefault();
            } else {
                window.open('{{ route('searchDate.pdf') }}', '_blank');
            }
        });

        $('#btn_exportar_excel').click(function(event) {
            let v_fecha_inicial = ValidaCampos('fecha_inicial', true, 'fecha');
            let v_fecha_final = ValidaCampos('fecha_final', true, 'fecha');
            let v_tipo_filtro = ValidaCampos('tipo_filtro', true, 'tipo_filtro');
            if (v_fecha_inicial == 0 || v_fecha_final == 0 || v_tipo_filtro == 0) {
                toastr.error('1 o más campos son requeridos. Por favor, ingréselos',
                    'Error de Validación');
                event.preventDefault();
            } else {
                window.open('{{ route('searchDate.excel') }}', '_blank');
            }
        });


    });
</script>

@if (empty($fecha_inicial) && empty($fecha_final))
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
                categories: ['08:00', '09:00', '10:00', '11:00', '12:00', '13:00', '14:00', '15:00',
                    '16:00',
                    '17:00', '18:00', '19:00', '20:00', '21:00', '22:00', '23:00'
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
                data: []
            }]
        });
    </script>
@else
    <script type="text/javascript">
        Highcharts.chart("EntradaHoy", {
            colors: ['#346DA4', '#f7a311', '#7CB5EC', '#a9cef2'],
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
                categories: ['08:00', '09:00', '10:00', '11:00', '12:00', '13:00', '14:00', '15:00',
                    '16:00',
                    '17:00', '18:00', '19:00', '20:00', '21:00', '22:00', '23:00'
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
                    @foreach ($datos_segmentados as $key => $value)
                        @if (is_numeric($value))
                            {{ $value }},
                        @endif
                    @endforeach
                ]
            }]
        });
    </script>
@endif

@if (empty($fecha_inicial) && empty($fecha_final))
    <script type="text/javascript">
        Highcharts.chart("graficoPorCamara", {
            colors: ['#f7a311', '#346DA4', '#7CB5EC', '#a9cef2'],
            chart: {
                type: "spline",
                zoomType: "xy"
            },
            title: {
                text: "Entradas por Cámara"
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
                categories: []
            },
            legend: {
                enabled: true
            },
            credits: {
                enabled: false
            },
            series: [{
                name: "Entrada",
                data: []
            }]
        });
    </script>
@else
    <script type="text/javascript">
        Highcharts.chart("graficoPorCamara", {
            colors: ['#346DA4', '#f7a311', '#7CB5EC', '#a9cef2'],
            chart: {
                type: "bar",
                zoomType: "xy"
            },
            title: {
                text: "Entradas por Cámara"
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
                    @foreach ($graficoPorCamara as $item)
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
                    @foreach ($graficoPorCamara as $item)
                        {{ $item->Entradas }},
                    @endforeach
                ]
            }]
        });
    </script>
@endif

<script type="text/javascript">
    Highcharts.chart("EntradasPorDia", {
        colors: ['#346DA4', '#f7a311', '#7CB5EC', '#a9cef2'],
        chart: {
            type: "column"
        },
        title: {
            text: "Entradas"
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
                @foreach ($graficoPorDia as $item)
                    '{{ $item->date }}',
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
                @foreach ($graficoPorDia as $item)
                    {{ $item->Entradas }},
                @endforeach
            ]
        }]
    });
</script>
