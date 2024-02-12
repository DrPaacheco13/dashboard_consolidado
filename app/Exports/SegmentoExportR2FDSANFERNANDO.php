<?php

namespace App\Exports;

use App\Models\PDFModel;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class SegmentoExportR2FDSANFERNANDO implements FromView, ShouldAutoSize
{
    use Exportable;
    protected $fecha;
    protected $fecha2;
    protected $seleccion;

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
        $seleccion = $this->seleccion;
        $idmall = auth()->user()->id_mall;
        $Consulta = new PDFModel();
        // $tipoExport = $this->tipoExport;

        $datos_segmentados = [];
        
        if ($seleccion == 1) {
            $datos_segmentados = $Consulta->DatosSegmentadosExcelxDiaR1($fecha, $fecha2);
        } elseif ($seleccion == 2) {
            $nombre = "Segundo Piso";
            $datos_segmentados = $Consulta->DatosSegmentadosExcelxDiaR2($fecha, $fecha2);
        } elseif ($seleccion == 3) {
        }

        pre_die($datos_segmentados);

        return view('layouts.buscar.excelxDia', compact('date', 'datosSegmentoEntrada', 'nombre', 'idmall'));
    }
}
