@extends('layouts.layout_main_view')

@section('content')
    <div class="container">
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
                                {{ !empty($timeActualizacion) ? $timeActualizacion[0]->tiempo : 'Sin Información' }}
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
                        <h2>Total Entradas</h2>
                        <h4>{{ !empty($aforoHoy) ? formatear_miles($aforoHoy[0]->Entradas) : 'Sin Información' }}</h4>
                    </div>
                    <div class="icon">
                        <i class="ion ion-stats-bars"></i>
                    </div>
                </div>
            </div>
            <hr>
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
            <div class="col-md-{{ !empty($entradasCamaraAyer) ? '4' : '6' }} card shadow-sm">
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
                                {{ !empty($aforoAyer) ? formatear_miles($aforoAyer[0]->totalenternum) : 'Sin Información' }}
                            </td>
                        </tr>
                    </tbody>
                </table>
                <div style="text-align: center; margin-top: 50px;">
                    <i class="fa-solid fa-person-walking-arrow-right fa-10x"></i>
                </div>
            </div>
            <div class="col-md-{{ !empty($entradasCamaraAyer) ? '4' : '6' }} card shadow-sm aforoDiaAnterior">
                <div>
                    <div id="containerDona"></div>
                </div>
            </div>
            @if (!empty($entradasCamaraAyer))
                <div class="col-md-4 card shadow-sm aforoDiaAnterior">
                    <div>
                        <div id="container"></div>
                    </div>
                </div>
            @endif
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
        <hr>
        {{-- ------------------------------------------------------------------------------------------------------------------------------- --}}
        <h5>Estadísticas comparativas del mes de {{ mesActualTexto() }}</h5>
        <h6 style="font-size: 11px;">Para visualizar cantidad, posicionar mouse encima de la barra</h6>
        </p>
        <div class="row" style="anchor: 2000px;">
            {{-- <div>
                        <div id="comparativasMes"></div>
                    </div> --}}
            <div class="col-md-2 card shadow-sm" style="width: 264px;">
                <div id="comparativasMesLunes"></div>
            </div>
            <div class="col-md-2 card shadow-sm" style="width: 264px;">
                <div id="comparativasMesMartes"></div>
            </div>
            <div class="col-md-2 card shadow-sm" style="width: 264px;">
                <div id="comparativasMesMiercoles"></div>
            </div>
            <div class="col-md-2 card shadow-sm" style="width: 264px;">
                <div id="comparativasMesJueves"></div>
            </div>
            <div class="col-md-2 card shadow-sm" style="width: 264px;">
                <div id="comparativasMesViernes"></div>
            </div>
        </div>
        &nbsp;
        <div class="row">
            <div class="col-md-6 card shadow-sm">
                <div id="comparativasMesSabado"></div>
            </div>
            <div class="col-md-6 card shadow-sm">
                <div id="comparativasMesDomingo"></div>
            </div>
        </div>

        <hr>

        {{-- ------------------------------------------------------------------------------------------------------------------------------- --}}
        {{-- ------------------------------------------------------------------------------------------------------------------------------- --}}
        <h5>Estadísticas comparativas del mes de {{ mesAnteriorTexto() }}</h5>
        <h6 style="font-size: 11px;">Para visualizar cantidad, posicionar mouse encima de la barra</h6>
        </p>
        <div class="row" style="anchor: 2000px;">
            {{-- <div>
                    <div id="comparativasMes"></div>
                </div> --}}
            <div class="col-md-2 card shadow-sm" style="width: 264px;">
                <div id="comparativasMesLunesANT"></div>
            </div>
            <div class="col-md-2 card shadow-sm" style="width: 264px;">
                <div id="comparativasMesMartesANT"></div>
            </div>
            <div class="col-md-2 card shadow-sm" style="width: 264px;">
                <div id="comparativasMesMiercolesANT"></div>
            </div>
            <div class="col-md-2 card shadow-sm" style="width: 264px;">
                <div id="comparativasMesJuevesANT"></div>
            </div>
            <div class="col-md-2 card shadow-sm" style="width: 264px;">
                <div id="comparativasMesViernesANT"></div>
            </div>
        </div>
        &nbsp;
        <div class="row">
            <div class="col-md-6 card shadow-sm">
                <div id="comparativasMesSabadoANT"></div>
            </div>
            <div class="col-md-6 card shadow-sm">
                <div id="comparativasMesDomingoANT"></div>
            </div>
        </div>
    </div>
@endsection
