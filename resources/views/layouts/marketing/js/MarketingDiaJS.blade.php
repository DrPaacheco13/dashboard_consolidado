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
