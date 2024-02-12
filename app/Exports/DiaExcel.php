<?php

namespace App\Exports;

use App\Models\PDFModel;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class DiaExcel implements FromView, ShouldAutoSize
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
        $mall = QueryBuilder('malls', ['id' => $idmall]);
        $namemall = !empty($mall) ? $mall[0]->nombre : 'Sin Información';

        $datos_segmentados = [];

        $nombre_acceso = '';
        if ($seleccion == 1) {
            $nombre_acceso = 'Acceso General';
            $datos_segmentados = $Consulta->DatosSegmentadosExcelxDiaR1($fecha, $fecha2);
        } elseif ($seleccion == 2) {
            $nombre_acceso = 'Acceso Exterior';
            $datos_segmentados = $Consulta->DatosSegmentadosExcelxDiaR2($fecha, $fecha2);
        } elseif ($seleccion == 3) {
            $nombre_acceso = 'Acceso Patio Comida';
        }


        return view('layouts.buscar.excelxDia', compact('date', 'nombre_acceso', 'namemall', 'datos_segmentados', 'idmall'));
    }
}
