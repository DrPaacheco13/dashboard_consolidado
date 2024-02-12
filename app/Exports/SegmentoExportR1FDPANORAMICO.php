<?php

namespace App\Exports;

use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class SegmentoExportR1FDPANORAMICO implements FromView, ShouldAutoSize
{
    use Exportable;

    public function __construct($fecha, $fecha2)
    {
        $this->fecha =  $fecha;
        $this->fecha2 = $fecha2;
    }

    public function view(): View
    {
        $fecha  = $this->fecha;
        $fecha2 = $this->fecha2;
        $idmall = auth()->user()->id_mall;
        $date = Carbon::now();
        // $tipoExport = $this->tipoExport;
        
            $datosSegmentoEntrada = DB::connection('mysql_5')->table('datos_estadisticos_dia_r1')
                ->select('totalenternum', 'date')
                ->whereBetween('date', [$fecha, $fecha2])
                ->get();
        

        return view('layouts.buscar.excelxDia', compact( 'date', 'datosSegmentoEntrada', 'idmall'));
    }
}
