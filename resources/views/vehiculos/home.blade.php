@extends('layouts.layout_main_view')

@section('content')
    <div class="container" style="align-content: center">

        <div class="container">
            <div class="row d-flex justify-content-center">
                {{-- <div class="col-md-3">
                    <p class="datosHoy display-8" style="margin-left: 11px">
                    <h5>Estadísticas del día</h5>
                </div> --}}
                <div class="col-md-4">

                    <div class="info-box mb-3">
                        <span class="info-box-icon bg-primary elevation-1"><i class="fas fa-calendar"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text"><b>Estadísticas Del Día</b></span>
                            <span class="info-box-number">{{ ucwords($fechaHoy) }}</span>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="info-box mb-3">
                        <span class="info-box-icon bg-primary elevation-1"><i class="fas fa-clock"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text"><b>Última Actualización</b></span>
                            <span class="info-box-number">
                                {{ !empty($time_actualizacion[0]) ? $time_actualizacion[0]->tiempo : 'Sin Información' }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row d-flex justify-content-center">
            @if ($view_vehicle->mostrar_flujo_personas)
                <div class="col-md-4">
                    <div class="small-box bg-primary">
                        <div class="inner text-left">
                            <h2>Total Flujo Personas</h2>
                            <h4>{{ !empty($salidasVehiculos) ? formatear_miles($salidasVehiculos->personas) : 'Sin Información' }}
                            </h4>
                        </div>
                        <div class="icon">
                            <i class="fas fa-users"></i>
                        </div>
                    </div>
                </div>
            @endif
            @if ($view_vehicle->mostrar_total_entradas)
                <div class="col-md-4">
                    <div class="small-box bg-success">
                        <div class="inner text-center">
                            <h2>Total Entradas</h2>
                            <h4>{{ !empty($salidasVehiculos) ? formatear_miles($salidasVehiculos->totalenter) : 'Sin Información' }}
                            </h4>
                        </div>
                        <div class="icon">
                            <i class="ion ion-stats-bars"></i>
                        </div>
                    </div>
                </div>
            @endif
            @if ($view_vehicle->mostrar_estadia_promedio)
                <div class="col-md-4">
                    <div class="small-box bg-info">
                        <div class="inner text-left">
                            <h2>Estadía Promedio</h2>
                            <h4>{{ !empty($salidasVehiculos) ? ($salidasVehiculos->estadia) : 'Sin Información' }}
                            </h4>
                        </div>
                        <div class="icon">
                            <i class="far fa-clock"></i>
                        </div>
                    </div>
                </div>
            @endif
            <hr>
            <div id="EntradaHoy" class="col-md-12 shadow-sm chartHoy card graHoy" style="margin-top: 15px;"></div>
        </div>
        <p class="display-8 datosOtros" style="margin-top: 10px;">
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
        </p>
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
    </div>
@endsection
