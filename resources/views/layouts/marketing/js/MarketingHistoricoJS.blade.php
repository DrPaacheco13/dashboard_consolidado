<script type="text/javascript">
    $(document).ready(function() {
        $('#region').change(function() {
            ValidaCampos('region', true, 'select', 'Seleccione Región');
        });
        $('#fecha_inicial').change(function() {
            ValidaCampos('fecha_inicial', true, 'fecha', 'Seleccione Fecha Inicial');
        });
        $('#fecha_final').change(function() {
            ValidaCampos('fecha_final', true, 'fecha', 'Seleccione Fecha Final');
            validarFechas($('#fecha_inicial').val(), $('#fecha_final').val());
        });

        $('#btn_search').click(function() {
            let region_valida = ValidaCampos('region', true, 'select', 'Seleccione Región');
            let fecha_inicial_valida = ValidaCampos('fecha_inicial', true, 'fecha',
                'Seleccione Fecha Inicial');
            let fecha_final_valida = ValidaCampos('fecha_final', true, 'fecha',
                'Seleccione Fecha Final');

            if (region_valida == 1 && fecha_inicial_valida == 1 && fecha_final_valida == 1) {
                let fecha_valida = validarFechas($('#fecha_inicial').val(), $('#fecha_final').val());

                if (fecha_valida === true) {
                    cargando();
                    let region_val = $('#region').val();
                    let fecha_inicial_val = $('#fecha_inicial').val();
                    let fecha_final_val = $('#fecha_final').val();
                    ObtenerDatos(region_val, fecha_inicial_val, fecha_final_val)
                    toastr.success(
                        'Datos de marketing filtrados con éxito.',
                        'Gestión de Marketing');
                } else {
                    toastr.error(fecha_valida, 'Error de Validación');
                }
            } else {
                toastr.error('1 o más campos son obligatorios, completalos para continuar...',
                    'Error de Validación');
            }
        });
    });

    function ObtenerDatos(region, fecha_inicial, fecha_final) {
        var csrfToken = $('meta[name="csrf-token"]').attr('content');
        if (region != '' && fecha_final != '' && fecha_final != '') {
            $.ajax({
                type: 'POST',
                url: '{{ route('marketing_historico.post') }}', // Nombre del script PHP
                data: {
                    _token: csrfToken,
                    region: region,
                    fecha_inicial: fecha_inicial,
                    fecha_final: fecha_final,
                }, // Datos a enviar
                dataType: 'json',
                success: function(response) {
                    let respuesta = JSON.stringify(response);
                    let obj = $.parseJSON(respuesta);
                    let tipo = obj['tipo'];
                    let resultado = obj['msg'];

                    if (tipo == 'error') {
                        toastr.error(
                            'Ha ocurrido un error al intentar obtener datos para los filtros indicados, recarga la página e intenta nuevamente por favor.',
                            'Error de Validación');
                    } else {
                        let data = obj['data'];
                        GenerarGrafico(data);
                    }

                },
                error: function(error) {
                    console.log(JSON.stringify(error));
                    toastr.error(`Error Interno`, "Error de Validación")
                }
            });
        } else {
            toastr.error('1 o más campos son obligatorios, completalos para continuar...',
                'Error de Validación');
        }
    }

    function CrearGraficos(data, chartContainerId, chartTitle, categories, colors) {
        $(document).ready(function() {
            let seriesData = categories.map(function(category) {
                return {
                    name: category,
                    y: parseFloat(redondearDecimal(data[category]))
                };
            });
            console.log('seriesData');
            console.log(seriesData);

            Highcharts.chart(chartContainerId, {
                colors: colors,
                chart: {
                    plotBackgroundColor: null,
                    plotBorderWidth: null,
                    plotShadow: false,
                    type: 'pie'
                },
                title: {
                    text: chartTitle
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
                    data: seriesData
                }]
            });
        });
    }

    function GenerarGrafico(data) {
        // Mostrar el contenedor de gráficos
        $('#container_grafico').show();
        console.log(data);

        // Crear el gráfico de visitantes en el contenedor 'chartHM'
        // Llenar la tabla de visitantes con los datos
        $('.table-visitantes tbody').html(`
        <tr>
            <td>Hombres</td>
            <td>${redondearDecimal(data.hombres)}%</td>
        </tr>
        <tr>
            <td>Mujeres</td>
            <td>${redondearDecimal(data.mujeres)}%</td>
        </tr>
    `);

        // Llenar la tabla de rango de edad con los datos
        $('.table-rango-edad tbody').html(`
        <tr>
            <td>Niños</td>
            <td>0 - 11</td>
            <td>${redondearDecimal(data.nino)}%</td>
        </tr>
        <tr>
            <td>Adolescentes</td>
            <td>12 - 18</td>
            <td>${redondearDecimal(data.adolecente)}%</td>
        </tr>
        <tr>
            <td>Joven</td>
            <td>19 - 26</td>
            <td>${redondearDecimal(data.joven)}%</td>
        </tr>
        <tr>
            <td>Adulto</td>
            <td>27 - 59</td>
            <td>${redondearDecimal(data.adulto)}%</td>
        </tr>
        <tr>
            <td>Adulto Mayor</td>
            <td>60 +</td>
            <td>${redondearDecimal(data.anciano)}%</td>
        </tr>
    `);
        try {
            const colorsHM = ['#2277EA', '#FF6961'];
            const categoriesHM = ['hombres', 'mujeres'];
            CrearGraficos(data, 'chartHM', 'Género', categoriesHM, colorsHM);

            const colorsRango = ['#33B2FF', '#9149c4', '#3e962c', '#F7A35C', '#dd5e5e'];
            const categoriesRango = ['nino', 'adolecente', 'joven', 'adulto', 'anciano'];
            CrearGraficos(data, 'chartRango', 'Rango Etario', categoriesRango, colorsRango);
            Swal.close();
        } catch (error) {
            console.log(error);
        }

    }
</script>
