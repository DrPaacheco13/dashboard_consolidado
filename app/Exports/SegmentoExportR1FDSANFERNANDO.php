<?php

namespace App\Exports;

use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class SegmentoExportR1FDSANFERNANDO implements FromView, ShouldAutoSize
{
    use Exportable;

    public function __construct($fecha, $fecha2, $seleccion)
    {
        $this->fecha =  $fecha;
        $this->fecha2 = $fecha2;
        $this->seleccion = $seleccion;
    }

    public function view(): View
    {
        $fecha  = $this->fecha;
        $fecha2 = $this->fecha2;
        $date = Carbon::now();
        $idmall = auth()->user()->id_mall;
        $seleccion = $this->seleccion;
        // $tipoExport = $this->tipoExport;
        if($seleccion == 1){
            $nombre = "Acceso General";
        }
        
            $datosSegmentoEntrada = DB::connection('mysql_2')->table('datos_estadisticos_dia_r1')
                ->select('totalenternum', 'date')
                ->whereBetween('date', [$fecha, $fecha2])
                ->get();
        

        return view('layouts.buscar.excelxDia', compact( 'date', 'datosSegmentoEntrada', 'nombre', 'idmall'));
    }
}
