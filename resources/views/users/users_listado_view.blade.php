@extends('layouts.layout_main_view')

@section('content')
    <div class="container">
        <div class="row card card-body">
            <div class="col-12 text-right">
                <a href="{{ route('users/nuevo') }}" class="btn btn-info text-white">
                    <i class="fas fa-plus-circle"></i>
                    <b>Nuevo Usuario</b>
                </a>
            </div>
            <div class="col-md-12 table-responsive">
                <table id="table_users" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th class="text-center">#</th>
                            <th class="text-center" style="white-space: nowrap">NOMBRE</th>
                            <th class="text-center" style="white-space: nowrap">EMAIL</th>
                            <th class="text-center" style="white-space: nowrap">ROL</th>
                            <th class="text-center" style="white-space: nowrap">MALL</th>
                            <th class="text-center" style="white-space: nowrap">DISTRIBUCIÓN</th>
                            <th class="text-center" style="white-space: nowrap">ESTADO</th>
                            <th class="text-center" style="white-space: nowrap">ACCIONES</th>
                        </tr>
                    <tbody>
                        @if (!empty($users))
                            @php
                                $count = 1;
                            @endphp
                            @foreach ($users as $user)
                                <tr id="row_{{ $user->id }}">
                                    <td>{{ $user->id }}</td>
                                    <td class="text-left" style="white-space: nowrap">
                                        {{ !empty($user->name) ? $user->name : 'Sin Información' }}
                                    </td>
                                    <td class="text-left" style="white-space: nowrap">
                                        {{ !empty($user->email) ? $user->email : 'Sin Información' }}
                                    </td>
                                    <td class="text-left" style="white-space: nowrap">
                                        {{ !empty($user->nombre_rol) ? $user->nombre_rol : 'Sin Información' }}
                                    </td>
                                    <td class="text-left" style="white-space: nowrap">
                                        {{ !empty($user->nombre_mall) ? ($user->role_id != 3 ? $user->nombre_mall : 'TODOS LOS MALLS') : 'Sin Información' }}
                                    </td>
                                    <td class="text-left" style="white-space: nowrap">
                                        {{ !empty($user->nombre_distribucion) ? $user->nombre_distribucion : 'Sin Información' }}
                                    </td>
                                    <td class="text-center" style="white-space: nowrap">
                                        <span
                                            class="badge badge-{{ !empty($user->estado) ? ($user->estado == true ? 'success' : 'danger') : 'danger' }}">
                                            {{ !empty($user->estado) ? ($user->estado == true ? 'Activo' : 'Inactivo') : 'Inactivo' }}
                                        </span>
                                    </td>
                                    {{-- <td class="text-center" style="white-space: nowrap">
                                        {{ !empty($user->created_at) ? ordenar_fechaHumano($user->created_at) : 'Sin Información' }}
                                    </td> --}}
                                    <td class="text-center" style="white-space: nowrap">
                                        <div class="btn-group">
                                            <a href="{{ 'editar/' . $user->id }}" class="btn btn-sm btn-info text-white"
                                                rel="noopener noreferrer"><i class="fas fa-pencil-alt"></i> Editar</a>
                                            <a class="btn btn-sm btn-danger text-white mall_delete"
                                                onclick="EliminarUsuario({{ $user->id }})" type="button"><i
                                                    class="fas fa-trash"></i> Eliminar</a>
                                        </div>
                                    </td>
                                </tr>
                                @php
                                    $count++;
                                @endphp
                            @endforeach
                        @endif
                    </tbody>
                    </thead>
                </table>
            </div>
        </div>
    </div>
@endsection
