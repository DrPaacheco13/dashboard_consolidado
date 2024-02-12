<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class VehiculosModel extends Model
{
    protected $connection = 'mysql_1';

    public function __construct()
    {
        configureDatabaseConnection();
    }

    public function uActualizacion()
    {
        $this->setTable('dashboard_process');
        $data = $this->selectRaw('time_format(timeupdate, "%H:%i") tiempo')
            ->where('id', '=', 1)
            ->first();
        return json_decode($data);
    }

    public function salidasVehiculos()
    {
        $this->setTable('vehiculos_total_dia');
        $data = $this->selectRaw('totalexit, totalenter, estadia')
            ->first();
        return json_decode($data);
    }
    public function salidasVehiculosTendencia()
    {
        $this->setTable('vehiculos_total_dia');
        $data = $this->selectRaw('personas, totalenter, estadia')
            ->first();
        return json_decode($data);
    }

    public function patenteVehiculos()
    {
        $this->setTable('vehiculos_estadisticas_dia');
        $data = $this->select('*')
            ->get();
        return json_decode($data);
    }

    public function segmentoVehiculos()
    {
        $this->setTable('vehiculos_segmento_dia');
        $data = $this->selectRaw('totalexit, totalenter, segmento')
            ->get();
        return json_decode($data);
    }

    public function topVehiculos()
    {
        $this->setTable('vehiculos_detalle');
        $data = $this->selectRaw('count(patente) as cantidad, patente')
            ->whereRaw('month(date) = month(curdate()) and patente != "Unknown" and patente != "######"')
            ->groupBy('patente')
            ->orderBy('cantidad', 'desc')
            ->limit('10')
            ->get();
        return json_decode($data);
    }

    public function dAyer()
    {
        $this->setTable('vehiculos_detalle_mes');
        $data = $this->select('totalenter')
            ->orderBy('id', 'desc')
            ->limit('1')
            ->get();
        return json_decode($data);
    }

    public function camaraSectorAnterior()
    {
        $this->setTable('vehiculos_entradas_camara_dia_ant');
        $data = $this->select('cameraindexcode', 'nombre', 'totalenternum as tEntrada')
            ->get();
        return json_decode($data);
    }

    public function dAyerGrafico()
    {
        $this->setTable('vehiculos_segmento_dia_ant');
        $data = $this->select('totalenter as Entradas', 'segmento')
            ->get();
        return json_decode($data);
    }

    public function dHoyGrafico()
    {
        $this->setTable('vehiculos_segmento_dia');
        $data = $this->select('totalenter as Entrada', 'segmento')
            ->get();
        return json_decode($data);
    }

    public function datosAnuales()
    {
        $this->setTable('vehiculos_total_mes');
        $data = $this->select('totalenter as tEntradas', 'month as mes', 'year')
            ->where('year', '=', '2023')
            ->where('totalenter', '>', '0')
            ->get();
        return json_decode($data);
    }

    public function datosMensuales()
    {
        $this->setTable('vehiculos_detalle_mes');
        $data = $this->selectRaw('totalenter as tEntrada, date_format(date, "%d-%m") as date')
            ->whereRaw('date_format(date, "%m-%y") like date_format(curdate(), "%m-%y")')
            ->orderBy('date')
            ->get();
        return json_decode($data);
    }

    public function patentesFechaTexto($texto, $fecha)
    {
        $this->setTable('vehiculos_estadia');

        $data = $this->selectRaw('patente, horaentrada color, horasalida tipo, date_format(date, "%d/%m/%Y") as date, estadia time')
            ->where('patente', 'LIKE', '%' . $texto . '%')
            ->whereDate('date', '=', $fecha)
            ->orderBy('id', 'desc')
            ->paginate(10);
        return $data;
    }

    public function patentesFechaFechaTexto($texto, $fecha, $fecha2)
    {
        $this->setTable('vehiculos_estadia');
        $data = $this->selectRaw('patente, horaentrada color, horasalida tipo, date_format(date, "%d/%m/%Y") as date, estadia time')
            ->where('patente', 'LIKE', '%' . $texto . '%')
            ->whereBetween('date', [$fecha, $fecha2])
            ->orderBy('id', 'desc')
            ->paginate(10);
        return $data;
    }

    // public function patentesTexto($texto)
    // {
    //     // $this->setTable('vehiculos_estadia');
    //     // $data = $this->selectRaw('patente, horaentrada color, horasalida tipo, date_format(date, "%d/%m/%Y") as date, estadia time')
    //     //     ->where('patente', 'LIKE', '%' . $texto . '%')->orderBy('date', 'desc')->paginate(10);

    //     $this->setTable('vehiculos_detalle');

    //     $dataDetalle = $this->selectRaw('patente, time as color, "Sin Salida" as tipo, date_format(date, "%d/%m/%Y") as date, "Sin Salida" as time')
    //         ->where('patente', 'LIKE', '%' . $texto . '%')
    //         ->whereRaw('date = CURDATE()')
    //         ->groupBy('patente', 'date')
    //         ->havingRaw('COUNT(*) = 1') // Asegura que solo haya un registro (ingreso) por patente y fecha
    //         ->orderBy('date', 'desc')
    //         ->orderBy('time', 'asc')
    //         ->take(10)
    //         ->get();

    //     return $dataDetalle;
    // }
    public function patentesTexto2($texto, $page = 1, $perPage = 10)
    {
        $this->setTable('vehiculos_estadia');

        $fechaInicial = Carbon::now()->subDay(); // Un día antes de la fecha y hora actual
        $fechaFinal = Carbon::now();

        $data = $this->where('patente', 'LIKE', '%' . $texto . '%')
            ->whereBetween('date', [$fechaInicial, $fechaFinal])
            ->select('patente', 'horaentrada as color', 'horasalida as tipo', DB::raw('date_format(date, "%d/%m/%Y") as date'), 'estadia as time');

        $this->setTable('vehiculos_detalle');

        $dataDetalle = $this->where('patente', 'LIKE', '%' . $texto . '%')
            ->whereBetween('date', [$fechaInicial, $fechaFinal])
            //->whereRaw('date = CURDATE()')
            ->groupBy('patente', 'date')
            ->havingRaw('COUNT(*) = 1') // Asegura que solo haya un registro (ingreso) por patente y fecha
            ->select('patente', 'time as color', DB::raw('"Sin Salida" as tipo'), DB::raw('date_format(date, "%d/%m/%Y") as date'), DB::raw('"Sin Salida" as time'));

        //$totalResults = 1000;
        //$totalPages = ceil($totalResults / $perPage);
        $result = $data->union($dataDetalle)->distinct()->orderBy('date', 'desc')->orderBy('time', 'asc')->skip(($page - 1) * $perPage)->take($perPage)->get();

        //        $totalResults = $result->count();

        return [
            'result' => $result,
            'totalPages' => 3,
        ];
    }
    public function patentesTexto1($texto, $page = 1, $perPage = 10)
    {
        $this->setTable('vehiculos_estadia');
        $fechaInicial = Carbon::now()->subDay(); // Un día antes de la fecha y hora actual
        $fechaFinal = Carbon::now();

        $sqlEstadia = $this->select('patente', 'horaentrada as color', 'horasalida as tipo', 'date', 'estadia as time')
            ->where('patente', 'LIKE', '%' . $texto . '%')
            ->whereBetween('date', [$fechaInicial, $fechaFinal]);

        $this->setTable('vehiculos_detalle');

        $sqlDetalle = $this->select('patente', DB::raw('time as color'), DB::raw('"Sin Salida" as tipo'), 'date', DB::raw('"Sin Salida" as time'))
            ->where('patente', 'LIKE', '%' . $texto . '%')
            ->whereBetween('date', [$fechaInicial, $fechaFinal])
            ->groupBy('patente', 'date')
            ->havingRaw('COUNT(*) = 1');

        $totalCount = $sqlEstadia->union($sqlDetalle)->count();

        $offset = ($page - 1) * $perPage;

        $result = $sqlEstadia->union($sqlDetalle)
            ->orderBy('patente', 'asc')
            ->skip($offset)
            ->take($perPage)
            ->get();

        $totalPages = ceil($totalCount / $perPage);

        return [
            'result' => $result,
            'totalPages' => $totalPages,
        ];
    }
    // use Illuminate\Support\Facades\DB;
    // use Carbon\Carbon;

    public function patentesTexto($texto, $page = 1, $perPage = 100, $fechaInicial, $fechaFinal)
    {
        $this->setTable('vehiculos_estadia');

        $fechaInicial = !empty($fechaInicial) ? Carbon::parse($fechaInicial) : Carbon::now()->subDay();
        $fechaFinal = !empty($fechaFinal) ? Carbon::parse($fechaFinal) : Carbon::now();

        $commonColumns = ['patente', 'date'];

        $sqlEstadia = $this->select([...$commonColumns, 'horaentrada as color', 'horasalida as tipo', 'estadia as time'])
            ->where('patente', 'LIKE', '%' . $texto . '%')
            ->whereBetween('date', [$fechaInicial, $fechaFinal])
            ->whereRaw("CHAR_LENGTH(patente) = 6");

        $sqlDetalle = null;
        if (!empty($texto)) {
            $sqlDetalle = $this->getSqlDetalle($texto, $fechaInicial, $fechaFinal);
        }

        $result = $this->getResult($sqlEstadia, $sqlDetalle, $texto, $page, $perPage);

        return [
            'result' => $result,
            'fecha_inicial' => $fechaInicial,
            'fecha_final' => $fechaFinal
        ];
    }

    protected function getSqlDetalle($texto, $fechaInicial, $fechaFinal)
    {
        $this->setTable('vehiculos_detalle');
        $commonColumns = ['patente', 'date'];

        return $this->select([...$commonColumns, DB::raw('time as color'), DB::raw('"Sin Salida" as tipo'), DB::raw('"Sin Salida" as time')])
            ->where('patente', 'LIKE', '%' . $texto . '%')
            ->whereBetween('date', [$fechaInicial, $fechaFinal])
            ->groupBy('patente', 'date')
            ->havingRaw('COUNT(*) = 1')
            ->whereRaw("CHAR_LENGTH(patente) = 6");
    }

    protected function getResult($sqlEstadia, $sqlDetalle, $texto, $page, $perPage)
    {
        if (!empty($sqlDetalle)) {
            $totalPages = ceil($sqlEstadia->union($sqlDetalle)->count() / $perPage);
            $result = $sqlEstadia->union($sqlDetalle);
        } else {
            $totalPages = ceil($sqlEstadia->count() / $perPage);
            $result = $sqlEstadia;
        }

        return $result->orderBy('patente', 'asc')
            ->skip(($page - 1) * $perPage)
            ->take($perPage)
            ->get();
    }



    public function patentesTexto4($texto, $page = 1, $perPage = 10)
    {
        $this->setTable('vehiculos_estadia');
        $fechaInicial = Carbon::now()->subDay(); // Un día antes de la fecha y hora actual
        $fechaFinal = Carbon::now();

        $sqlEstadia = "
        SELECT
            patente,
            horaentrada AS color,
            horasalida AS tipo,
            date AS date,
            estadia AS time
        FROM vehiculos_estadia
        WHERE patente LIKE '%{$texto}%'
            AND date BETWEEN '{$fechaInicial}' AND '{$fechaFinal}'
    ";

        $this->setTable('vehiculos_detalle');

        $sqlDetalle = "
        SELECT
            patente,
            time AS color,
            'Sin Salida' AS tipo,
            date AS date,
            'Sin Salida' AS time
        FROM vehiculos_detalle
        WHERE patente LIKE '%{$texto}%'
            AND date BETWEEN '{$fechaInicial}' AND '{$fechaFinal}'
        GROUP BY patente, date
        HAVING COUNT(*) = 1
    ";

        $offset = ($page - 1) * $perPage;

        $sql = "($sqlEstadia UNION $sqlDetalle) ORDER BY patente ASC LIMIT $offset, $perPage";

        $result = DB::connection('mysql_1')->select($sql);

        $totalPages = ceil(count($result) / $perPage);

        return [
            'result' => $result,
            'totalPages' => $totalPages,
        ];
    }
}
