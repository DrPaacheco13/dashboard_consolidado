<script>
    $(document).ready(function() {
        let data_r1;
        let data_r2;
        let data_r3;
        let data_vehicle;
        let data_tendencia;
        let data_mall;

        @if (!empty($datos_malls))
            @foreach ($datos_malls as $datos)
                data_mall = {!! json_encode($datos->mall) !!};
                console.log(data_mall);
                @if (!empty($datos->mall))
                    crearGraficoEntrada({!! json_encode($datos) !!}, 'acceso_mall_' + data_mall.id,
                        {!! isset($datos->aforo_segmentado_r0) ? json_encode($datos->aforo_segmentado_r0) : json_encode([]) !!},
                        {!! isset($datos->aforo_segmentado_r1) ? json_encode($datos->aforo_segmentado_r1) : json_encode([]) !!},
                        {!! isset($datos->aforo_segmentado_r2) ? json_encode($datos->aforo_segmentado_r2) : json_encode([]) !!},
                        {!! isset($datos->aforo_segmentado_r3) ? json_encode($datos->aforo_segmentado_r3) : json_encode([]) !!},
                        {!! isset($datos->aforo_segmentado_vehicle) ? json_encode($datos->aforo_segmentado_vehicle) : json_encode([]) !!},
                        {!! isset($datos->aforo_segmentado_tendencia)
                            ? json_encode($datos->aforo_segmentado_tendencia)
                            : json_encode([]) !!});
                @endif
            @endforeach
        @endif

    });

    function crearGraficoEntrada(datos, graficoId = 'acceso_mall_', data_r0, data_r1, data_r2, data_r3, data_vehicle,
        data_tendencia) {

        console.log('#####################################');
        console.log(datos.mall);
        console.log('#####################################');
        const categories = data_r1.length > 0 ? data_r1.map(item => item.segmento) : [];

        let series = [];
        let nombrer0 = '';
        let nombrer1 = '';
        let nombrer2 = '';
        let nombrer3 = '';
        let nombrerVehiculos = '';
        if (datos.mall.acceso_r0) {
            series.push({
                name: datos.mall.acceso_r0_nombre + " (" + datos.aforo_actual_r0[0].Entradas + ")",
                data: data_r0.map(data => data.Entrada)
            })
        }
        if (datos.mall.acceso_r1) {
            series.push({
                name: datos.mall.acceso_r1_nombre + " (" + datos.aforo_actual_r1[0].Entradas + ")",
                data: data_r1.map(data => data.Entrada)
            })
        }
        if (datos.mall.acceso_r2) {
            series.push({
                name: datos.mall.acceso_r2_nombre + " (" + datos.aforo_actual_r2[0].Entradas + ")",
                data: data_r2.map(data => data.Entrada)
            })
        }
        if (datos.mall.acceso_r3) {
            series.push({
                name: datos.mall.acceso_r3_nombre + " (" + datos.aforo_actual_r3[0].Entradas + ")",
                data: data_r3.map(data => data.Entrada)
            })
        }
        if (datos.mall.acceso_vehicle) {
            series.push({
                name: "VEHICULOS (" + datos.aforo_actual_vehicle[0].totalenter + ")",
                data: data_vehicle.map(data => data.Entrada)
            })
        }
        if (datos.mall.acceso_tendencia) {
            series.push({
                name: 'TENDENCIA VEHICULOS (' + datos.aforo_actual_tendencia[0].Entradas + ")",
                data: data_tendencia.map(data => data.Entrada)
            })
        }

        // Revisa si los datos están vacíos antes de intentar mapearlos
        // const categories =

        Highcharts.chart(graficoId, {
            colors: ['#f7a311', '#346DA4', '#7CB5EC', '#a9cef2'],
            chart: {
                type: "spline",
                zoomType: "xy",
                height: 250
            },
            title: {
                text: "Entradas Segmentadas",
                style: {
                    fontSize: '12px'
                }
            },
            xAxis: {
                crosshair: true,
                title: {
                    text: "Segmentos"
                },
                categories: categories
            },
            yAxis: {
                title: {
                    text: "Cantidad"
                }
            },
            legend: {
                enabled: true
            },
            credits: {
                enabled: false
            },
            series: series
        });
    }

    var graficoId = "EntradaHoy";
</script>
