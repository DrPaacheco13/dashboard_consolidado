@extends('layouts.layout_main_view')

@section('content')
    <div class="container">
        <div class="row card card-body">
            <div class="col-12 text-right">
                <a href="{{ route('malls/nuevo') }}" class="btn btn-info text-white">
                    <i class="fas fa-plus-circle"></i>
                    <b>Nuevo Mall</b>
                </a>
            </div>
            <div class="col-md-12">
                <table id="table_malls" class="table table-bordered table-striped table-responsive">
                    <thead>
                        <tr>
                            <th class="text-center">#</th>
                            <th class="text-center" style="white-space: nowrap">NOMBRE MALL</th>
                            {{-- <th class="text-center" style="white-space: nowrap">DESCRIPCION</th> --}}
                            <th class="text-center" style="white-space: nowrap">ACCESO R1</th>
                            <th class="text-center" style="white-space: nowrap">ACCESO R2</th>
                            <th class="text-center" style="white-space: nowrap">ACCESO R3</th>
                            <th class="text-center" style="white-space: nowrap">ACCESO TENDENCIA</th>
                            <th class="text-center" style="white-space: nowrap">ACCESO VEHICULOS</th>
                            <th class="text-center" style="white-space: nowrap">ESTADO</th>
                            <th class="text-center" style="white-space: nowrap">FECHA CREADO</th>
                            <th class="text-center" style="white-space: nowrap">ACCIONES</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (!empty($malls))
                            @php
                                $count = 1;
                            @endphp
                            @foreach ($malls as $mall)
                                <tr id="row_{{ $mall->id }}">
                                    <input type="hidden" id="nombre_mall_{{ $mall->id }}" value="{{ $mall->nombre }}">
                                    <td>{{ $count }}</td>
                                    <td class="text-left" style="white-space: nowrap">
                                        {{ !empty($mall->nombre) ? $mall->nombre : 'Sin Información' }}
                                    </td>
                                    {{-- <td class="text-left">
                                        {{ !empty($mall->descripcion) ? $mall->descripcion : 'Sin Información' }}
                                    </td> --}}
                                    <td class="text-center">
                                        <span
                                            class="badge badge-{{ isset($mall->acceso_r1) ? ($mall->acceso_r1 == true ? 'success' : 'warning') : 'warning' }}">
                                            {{ isset($mall->acceso_r1) ? ($mall->acceso_r1 == true ? 'Habilitado' : 'Inhabilitado') : 'Inhabilitado' }}
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <span
                                            class="badge badge-{{ isset($mall->acceso_r2) ? ($mall->acceso_r2 == true ? 'success' : 'warning') : 'warning' }}">
                                            {{ isset($mall->acceso_r2) ? ($mall->acceso_r2 == true ? 'Habilitado' : 'Inhabilitado') : 'Inhabilitado' }}
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <span
                                            class="badge badge-{{ isset($mall->acceso_r3) ? ($mall->acceso_r3 == true ? 'success' : 'warning') : 'warning' }}">
                                            {{ isset($mall->acceso_r3) ? ($mall->acceso_r3 == true ? 'Habilitado' : 'Inhabilitado') : 'Inhabilitado' }}
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <span
                                            class="badge badge-{{ isset($mall->acceso_tendencia) ? ($mall->acceso_tendencia == true ? 'success' : 'warning') : 'warning' }}">
                                            {{ isset($mall->acceso_tendencia) ? ($mall->acceso_tendencia == true ? 'Habilitado' : 'Inhabilitado') : 'Inhabilitado' }}
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <span
                                            class="badge badge-{{ isset($mall->acceso_vehicle) ? ($mall->acceso_vehicle == true ? 'success' : 'warning') : 'warning' }}">
                                            {{ isset($mall->acceso_vehicle) ? ($mall->acceso_vehicle == true ? 'Habilitado' : 'Inhabilitado') : 'Inhabilitado' }}
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <span
                                            class="badge badge-{{ isset($mall->estado) ? ($mall->estado == true ? 'success' : 'danger') : 'danger' }}">
                                            {{ isset($mall->estado) ? ($mall->estado == true ? 'Activo' : 'Inactivo') : 'Sin Información' }}
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        {{ !empty($mall->created_at) ? ordenar_fechaHumano($mall->created_at) : 'Sin Información' }}
                                    </td>
                                    <td class="text-center" style="white-space: nowrap">
                                        <div class="btn-group">
                                            <a href="{{ 'editar/' . $mall->id }}" class="btn btn-sm btn-info text-white"
                                                rel="noopener noreferrer"><i class="fas fa-pencil-alt"></i> Editar</a>
                                            <a class="btn btn-sm btn-danger text-white btn_deleted" type="button"
                                                id="{{ $mall->id }}">
                                                <i class="fas fa-trash"></i>
                                                Eliminar
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                @php
                                    $count++;
                                @endphp
                            @endforeach
                        @else
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modal-eliminar">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Eliminar Mall</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <h4>
                        ¿Estas seguro que quieres eliminar el Mall: <b id="nombre_mall_eliminar"></b>?
                    </h4>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-danger" onclick="EliminarMall()">Eliminar</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
@endsection
