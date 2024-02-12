@extends('layouts.layout_main_view')

@section('content')
    <div class="container">
        <div class="row mb-3 mt-3">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="text-center">Seleccione un rango de Fechas para Visualizar los Datos</h5>
                    </div>
                    <div class="card-body">
                        <form method="post" id="formulario" action="{{ route('searchDate.post') }}">
                            @csrf
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="fecha_inicial" class="label-formulario">Fecha Inicial <span
                                                        class="text-danger">*</span></label>
                                                <input min="2015-01-01" max="{{ GetDateToday() }}" name="fecha_inicial"
                                                    value="<?= !empty($fecha_inicial) ? $fecha_inicial : '' ?>"
                                                    id="fecha_inicial" class="form-control" type="date"
                                                    placeholder="Buscar por fecha" aria-label="Search"
                                                    style="text-align: center">
                                                <span id="invalid_fecha_inicial" class="text-danger"
                                                    style="font-size: 12px"></span>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="fecha_final" class="label-formulario">Fecha Final <span
                                                        class="text-danger">*</span></label>
                                                <input min="2015-01-01" max="{{ GetDateToday() }}" name="fecha_final"
                                                    value="<?= !empty($fecha_final) ? $fecha_final : '' ?>" id="fecha_final"
                                                    class="form-control" type="date" placeholder="Buscar por fecha2"
                                                    aria-label="Search" style="text-align: center">
                                                <span id="invalid_fecha_final" class="text-danger"
                                                    style="font-size: 12px"></span>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="opcion" class="label-formulario">Seleccione filtro <span
                                                        class="text-danger">*</span></label>
                                                <select class="form-control" style="text-align: center" name="opcion"
                                                    id="tipo_filtro">
                                                    <option <?= isset($opcion) && $opcion == 0 ? 'selected' : '' ?>
                                                        value="0">
                                                        Seleccione filtro</option>
                                                    <option <?= isset($opcion) && $opcion == 1 ? 'selected' : '' ?>
                                                        value="1">
                                                        Filtro por Día</option>
                                                    <option <?= isset($opcion) && $opcion == 2 ? 'selected' : '' ?>
                                                        value="2">
                                                        Filtro por Segmento</option>
                                                </select>
                                                <span id="invalid_tipo_filtro" class="text-danger"
                                                    style="font-size: 12px"></span>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="region" class="label-formulario">Seleccione Región <span
                                                        class="text-danger">*</span></label>
                                                <select class="form-control" style="text-align: center" name="region"
                                                    id="region">
                                                    <option value="0">Seleccionar</option>
                                                    @if ($mall->acceso_r1)
                                                        <option <?= isset($region) && $region == 1 ? 'selected' : '' ?>
                                                            value="1">
                                                            {{ $mall->acceso_r1_nombre }}
                                                        </option>
                                                    @endif
                                                    @if ($mall->acceso_r2)
                                                        <option <?= isset($region) && $region == 2 ? 'selected' : '' ?>
                                                            value="2">
                                                            {{ $mall->acceso_r2_nombre }}
                                                        </option>
                                                    @endif
                                                    @if ($mall->acceso_r3)
                                                        <option <?= isset($region) && $region == 3 ? 'selected' : '' ?>
                                                            value="3">
                                                            {{ $mall->acceso_r3_nombre }}
                                                        </option>
                                                    @endif
                                                </select>
                                                <span id="invalid_region" class="text-danger"
                                                    style="font-size: 12px"></span>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="col-md-6 d-flex justify-content-start">
                                    <div class="btn-group " role="group" aria-label="Button group name">
                                        <button class="btn btn-primary" id="btn_buscar" style="font-size: 14px"
                                            type="button">
                                            <i class="fas fa-search"></i> Buscar
                                        </button>
                                        <a class="btn btn-secondary" style="font-size: 14px"
                                            href="{{ route('searchDate') }}"><i class="fas fa-sync"></i>
                                            Limpiar Filtros</a>
                                        <button type="button" class="btn btn-danger" style="font-size: 14px"
                                            id="btn_exportar_pdf" disabled>
                                            <i class="fas fa-file-pdf"></i> Exportar PDF
                                        </button>
                                        <button type="button" class="btn btn-success" style="font-size: 14px"
                                            id="btn_exportar_excel" disabled>
                                            <i class="fas fa-file-excel pr-3"></i> Exportar EXCEL
                                        </button>
                                    </div>
                                </div>

                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-12 col_card" style="display: none">
                <div class="row">
                    <div class="col-md-12 card">
                        @if (empty($fecha_final) and empty($fecha_inicial))
                            <p style="text-align: center; font-size: 25px;">Entradas</p>
                        @elseif($fecha_inicial != $fecha_final)
                            <p style="text-align: center; font-size: 25px;">Entradas desde el
                                {{ ucwords(Carbon\Carbon::parse($fecha_inicial)->translatedFormat('j F Y')) }} hasta el
                                {{ ucwords(Carbon\Carbon::parse($fecha_final)->translatedFormat('j F Y')) }}</p>
                        @else
                            <p style="text-align: center; font-size: 25px;">Entradas del día
                                {{ ucwords(Carbon\Carbon::parse($fecha_inicial)->translatedFormat('j F')) }}</p>
                        @endif
                        <h1 class="display-6" style="text-align: center">
                            @if (empty($fecha_inicial) && empty($fecha_final))
                                0
                                @else{{ number_format($datos->tEntrada, 0, ',', '.') }}
                            @endif
                        </h1>
                    </div>
                </div>

                <div class="row">
                    <div id="EntradaHoy" class="col-md-12 card card-body"></div>
                </div>
            </div>
        </div>
        @if ($opcion == 2)
            <div class="col-md-12">
                <table class="table shadow-sm table-bordered table-hover bg-light table-striped-columns"
                    style="border-radius: 10px; text-align: right">
                    <thead>
                        <tr>
                            <th scope="col">Segmento</th>
                            <th scope="col">08:00</th>
                            <th scope="col">09:00</th>
                            <th scope="col">10:00</th>
                            <th scope="col">11:00</th>
                            <th scope="col">12:00</th>
                            <th scope="col">13:00</th>
                            <th scope="col">14:00</th>
                            <th scope="col">15:00</th>
                            <th scope="col">16:00</th>
                            <th scope="col">17:00</th>
                            <th scope="col">18:00</th>
                            <th scope="col">19:00</th>
                            <th scope="col">20:00</th>
                            <th scope="col">21:00</th>
                            <th scope="col">22:00</th>
                            <th scope="col">23:00</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <th scope="row">Entradas</th>

                            @foreach ($datos_segmentados as $key => $value)
                                <td>
                                    {{ $value }}
                                </td>
                            @endforeach
                        </tr>
                    </tbody>
                </table>
            </div>
        @endif
        @if ($opcion == 1)
            <div class="row col_card" style="display: none">
                <div id="EntradasPorDia" class="col-md-12 card">

                </div>
            </div>
        @endif
        <br>
        <div class="row col_card" style="display: none">
            <div id="graficoPorCamara" class="col-md-12 card">
            </div>
        </div>
    </div>
@endsection
