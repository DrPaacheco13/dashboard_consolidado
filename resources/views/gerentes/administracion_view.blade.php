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
                    @endforeach
                @endif
            </div>

        </div>
    </div>
    
@endsection
