@extends('layouts.layout_main_view')

@section('content')

    <div class="container">
        <div class="card card-body">
            <div class="row d-flex justify-content-center">
                <style>
                    .highcharts-figure,
                    .highcharts-data-table table {
                        min-width: 260px;
                        max-width: 300px;
                        margin: 1em auto;
                    }
                </style>
                @if (!empty($datos_malls))
                    @foreach ($datos_malls as $mall)
                        @if ($mall->mall)
                            <div class="col-md-12 mb-3">
                                <div class="card h-100 w-100">
                                    <div class="card-header d-flex">
                                        <h1 class="card-title ml-auto pt-2" style="font-size: 22px">
                                            <b>{{ $mall->mall->nombre }}</b> <br>
                                        </h1>
                                        @if ($mall->mall)
                                            <h6 class="ml-auto">
                                                <a href="{{ route('redirect/mall', ['id' => $mall->mall->id]) }}"
                                                    style="text-decoration: none; color: white; font-size: 12px;"
                                                    class="btn bg-gradient-success btn-xs">
                                                    Ver Mall <i class="fas fa-share"></i></a>
                                            </h6>
                                        @endif
                                    </div>
                                    <div class="card-body">
                                        <div class="text-center" id="acceso_mall_{{ $mall->mall->id }}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif

                        {{-- @if ($mall->mall->acceso_r0)
                            <div class="col-md-4 mb-3">
                                <div class="card h-100 w-100">
                                    <div class="card-header d-flex justify-content-between">
                                        <h1 class="card-title text-center" style="font-size: 12px">
                                            {{ $mall->mall->nombre }} <br> {{ $mall->mall->acceso_r0_nombre }}
                                        </h1>
                                        <h6 class="text-center" style="margin-left: 40%">
                                            <a href="{{ route('redirect/mall', ['id' => $mall->mall->id]) }}"
                                                style="text-decoration: none; color: white; font-size: 12px;"
                                                class="btn bg-gradient-success btn-xs">
                                                Ver Mall <i class="fas fa-share"></i></a>
                                        </h6>
                                    </div>
                                    <div class="card-body d-flex justify-content-center align-items-center">
                                        <div class="row-span-1 text-center" id="acceso_r0_{{ $mall->mall->id }}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif --}}
                        {{-- 
                        @if ($mall->mall->acceso_r1)
                            <div class="col-md-4 mb-3">
                                <div class="card h-100 w-100">
                                    <div class="card-header d-flex justify-content-between">
                                        <h1 class="card-title text-left" style="font-size: 12px">
                                            {{ $mall->mall->nombre }} <br> {{ $mall->mall->acceso_r1_nombre }}
                                        </h1>
                                        @if (!$mall->mall->acceso_r0)
                                            <h6 class="text-center" style="margin-left: 40%">
                                                <a href="{{ route('redirect/mall', ['id' => $mall->mall->id]) }}"
                                                    style="text-decoration: none; color: white; font-size: 12px;"
                                                    class="btn bg-gradient-success btn-xs">
                                                    Ver Mall <i class="fas fa-share"></i></a>
                                            </h6>
                                        @endif
                                    </div>
                                    <div class="card-body d-flex justify-content-between align-items-center">
                                        <div class="row-span-1 text-center" id="acceso_r1_{{ $mall->mall->id }}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                        @if ($mall->mall->acceso_r2)
                            <div class="col-md-4 mb-3">
                                <div class="card h-100 w-100">
                                    <div class="card-header d-flex justify-content-center">
                                        <h1 class="card-title text-center" style="font-size: 12px">
                                            {{ $mall->mall->nombre }} <br> {{ $mall->mall->acceso_r2_nombre }}
                                        </h1>
                                    </div>
                                    <div class="card-body d-flex justify-content-center align-items-center">
                                        <div class="row-span-1 text-center" id="acceso_r2_{{ $mall->mall->id }}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                        @if ($mall->mall->acceso_r3)
                            <div class="col-md-4 mb-3">
                                <div class="card h-100 w-100">
                                    <div class="card-header d-flex justify-content-center">
                                        <h1 class="card-title text-center" style="font-size: 12px">
                                            {{ $mall->mall->nombre }} - {{ $mall->mall->acceso_r3_nombre }}
                                        </h1>
                                    </div>
                                    <div class="card-body d-flex justify-content-center align-items-center">
                                        <div class="row-span-1 text-center" id="acceso_r3_{{ $mall->mall->id }}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                        @if ($mall->mall->acceso_vehicle)
                            <div class="col-md-4 mb-3">
                                <div class="card h-100 w-100">
                                    <div class="card-header d-flex justify-content-center">
                                        <h1 class="card-title text-center" style="font-size: 12px">
                                            {{ $mall->mall->nombre }} <br> VEHICULOS
                                        </h1>
                                        @if (!$mall->mall->acceso_r0 && !$mall->mall->acceso_r1 && !$mall->mall->acceso_r2 && !$mall->mall->acceso_r3)
                                            <h6 class="text-center" style="margin-left: 40%">
                                                <a href="{{ route('redirect/mall', ['id' => $mall->mall->id]) }}"
                                                    style="text-decoration: none; color: white; font-size: 12px;"
                                                    class="btn bg-gradient-success btn-xs">
                                                    Ver Mall <i class="fas fa-share"></i></a>
                                            </h6>
                                        @endif
                                    </div>
                                    <div class="card-body d-flex justify-content-center align-items-center">
                                        <div class="row-span-1 text-center" id="acceso_vehicle_{{ $mall->mall->id }}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                        @if ($mall->mall->acceso_tendencia)
                            <div class="col-md-4 mb-3">
                                <div class="card h-100 w-100">
                                    <div class="card-header d-flex justify-content-center">
                                        <h1 class="card-title text-center" style="font-size: 12px">
                                            {{ $mall->mall->nombre }} <br> VEHICULOS TENDENCIAS
                                        </h1>
                                    </div>
                                    <div class="card-body d-flex justify-content-center align-items-center">
                                        <div class="row-span-1 text-center" id="acceso_tendencia_{{ $mall->mall->id }}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif --}}
                    @endforeach
                @endif
            </div>

        </div>
    </div>
@endsection
