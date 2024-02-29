@extends('layouts.layout_main_view')

@section('content')
    <div class="container">
        <div class="card card-body">
            <div class="row">
                <div class="col-12 text-center">
                    <h2><b>Listado de Malls</b></h2>
                </div>
            </div>
            <br>
            <div class="row table-responsive">
                <table class="table table-bordered table-hover w-100" id="table-resumen">
                    <thead>
                        <tr>
                            <th class="text-center">MALL</th>
                            <th class="text-center">VEHICULOS</th>
                            <th class="text-center">PERSONAS</th>
                            <th class="text-center">HOMBRES</th>
                            <th class="text-center">MUJERES</th>
                            <th class="text-center">ACCION</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (!empty($datos_malls))
                            @foreach ($datos_malls as $mall)
                                <tr>
                                    <td class="text-left">
                                        {{ !empty($mall->mall->nombre) ? StrUpper($mall->mall->nombre) : 'Sin Información' }}
                                    </td>
                                    <td class="text-right">
                                        {{ !empty($mall->aforo_actual_vehiculos) ? formatear_miles($mall->aforo_actual_vehiculos) : 'Sin Información' }}
                                    </td>
                                    <td class="text-right">
                                        {{ !empty($mall->aforo_actual_personas) ? formatear_miles($mall->aforo_actual_personas) : 'Sin Información' }}
                                    </td>
                                    <td class="text-right">
                                        {{ !empty($mall->total_hombres) ? round($mall->total_hombres, 2) . '%' : 'Sin Información' }}
                                    </td>
                                    <td class="text-right">
                                        {{ !empty($mall->total_mujeres) ? round($mall->total_mujeres, 2) . '%' : 'Sin Información' }}
                                    </td>
                                    <td class="text-center">
                                        <div class="btn-group">
                                            <a class="btn btn-sm btn-primary"
                                                href="{{ route('gerentes/ver-mall', ['mall_id' => $mall->mall->id]) }}"><i
                                                    class="fas fa-eye"></i> Detalles</a>
                                            <a class="btn btn-sm btn-success" href="{{ route('redirect/mall', ['id' => $mall->mall->id]) }}" type="button"><i class="fas fa-share"></i>
                                                Mall</a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
            </div>

        </div>
    </div>
@endsection
