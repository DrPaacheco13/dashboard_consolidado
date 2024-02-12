@extends('layouts.layout_main_view')

@section('content')
    <div class="container" style="align-content: center">
        <div class="container">
            <div class="row d-flex justify-content-center">
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
                                {{ !empty($uActualizacion) ? $uActualizacion[0]->tiempo : 'Sin Información' }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row d-flex justify-content-center">
            <div class="col-md-4">
                <div class="small-box bg-success">
                    <div class="inner text-center">
                        <h2>Total entradas</h2>
                        <h4>{{ !empty($aforo_hoy) ? formatear_miles($aforo_hoy[0]->Entradas) : 'Sin información' }}</h4>
                    </div>
                    <div class="icon">
                        <i class="ion ion-stats-bars"></i>
                    </div>
                </div>
            </div>
            <hr style="margin-top: 23px;">
            <div id="EntradaHoy" class="col-md-12 shadow-sm chartHoy card graHoy" style="margin-top: 15px;"></div>
        </div>
        <hr>
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
            <div class="col-md-6 card shadow-sm">
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
                                @foreach ($aforo_ayer as $aforo)
                                    {{ number_format($aforo->totalenter, 0, ',', '.') }}
                                @endforeach
                            </td>
                        </tr>
                    </tbody>
                </table>
                <div style="text-align: center; margin-top: 50px;">
                    <i class="fa-solid fa-person-walking-arrow-right fa-10x"></i>
                </div>
            </div>
            <div class="col-md-6 card shadow-sm aforoDiaAnterior">
                <div>
                    <div id="containerDona"></div>
                </div>
            </div>
        </div>
    </div>
@endsection
