@extends('layouts.layout_main_view')

@section('content')
    <div class="container">
        <div class="card card-body">
            <div class="row">
                <div class="col-2">
                    <a href="{{ route('gerentes/resumen') }}" class="btn btn-info text-white" onclick="cargando()" rel="noopener noreferrer">
                    <i class="fas fa-arrow-left"></i> Atrás
                    </a>
                </div>
                <div class="col-10 text-center">
                    <h2><b>Resumen de {{ !empty($nombre_mall) ? $nombre_mall : 'Mall' }}</b></h2>
                </div>
            </div>
            <br>

            <div class="row">
                <div class="col-12 col-sm-12">
                    <div class="card card-primary card-outline card-outline-tabs">
                        <div class="card-header p-0 border-bottom-0">
                            <ul class="nav nav-tabs" id="custom-tabs-four-tab" role="tablist">
                                @if (!empty($accesos_habilitados))
                                    @php
                                        $contador = 0;
                                    @endphp
                                    @foreach ($accesos_habilitados as $key => $acceso)
                                        @if (strpos($key, 'data_acceso_') === false)
                                            <li class="nav-item">
                                                <a class="nav-link {{ $contador == 0 ? 'active' : '' }}"
                                                    id="{{ $key }}-tab" data-toggle="pill"
                                                    href="#{{ $key }}" role="tab"
                                                    aria-controls="{{ $key }}"
                                                    aria-selected="{{ $contador == 0 ? 'true' : 'false' }}">{{ $acceso }}</a>
                                            </li>
                                            @php
                                                $contador++;
                                            @endphp
                                        @endif
                                    @endforeach
                                @endif
                            </ul>
                        </div>
                        <div class="card-body">
                            <div class="tab-content" id="custom-tabs-four-tabContent">
                                @if (!empty($accesos_habilitados))
                                    <script>
                                        let datosMesAnterior = []
                                        let datosMesActual = []
                                        let diasSemana = []
                                    </script>
                                    @php
                                        $contador = 0;
                                    @endphp
                                    @foreach ($accesos_habilitados as $key => $accesos)
                                        @if (strpos($key, 'data_acceso_') !== false)
                                            @php
                                                $k = str_replace('data_acceso_', '', $key);
                                            @endphp
                                            <div class="tab-pane fade {{ $contador == 0 ? 'show active' : '' }}"
                                                role="tabpanel" aria-labelledby="{{ $k }}-tab"
                                                id="{{ $k }}">
                                                @if ($k == 'vehicle')
                                                    @include('gerentes.content_vehicle_view', $accesos)
                                                @elseif ($k == 'marketing')
                                                    @include('gerentes.content_marketing_view', $accesos)
                                                @else
                                                    @include('gerentes.content_view', $accesos)
                                                @endif
                                            </div>
                                            @php
                                                $contador++;
                                            @endphp
                                        @endif
                                    @endforeach
                                @endif
                            </div>
                        </div>
                        <!-- /.card -->
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
