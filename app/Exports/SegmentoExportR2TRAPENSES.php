<?php

namespace App\Exports;

use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;

class SegmentoExportR2TRAPENSES implements FromView, ShouldAutoSize, WithHeadings
{
    use Exportable;

    public function headings(): array
    {
        return [
            'Fecha',
            'Segmento 08',
            'Segmento 09',
            'Segmento 10',
            'Segmento 11',
            'Segmento 12',
            'Segmento 13',
            'Segmento 14',
            'Segmento 15',
            'Segmento 16',
            'Segmento 17',
            'Segmento 18',
            'Segmento 19',
            'Segmento 20',
            'Segmento 21',
            'Segmento 22',
            'Segmento 23',
        ];
    }

    public function __construct($fecha, $fecha2, $seleccion)
    {
        $this->fecha =  $fecha;
        $this->fecha2 = $fecha2;
        $this->seleccion = $seleccion;
        // $this->tipoExport = $tipoExport;
    }

    public function view(): View
    {
        $fecha  = $this->fecha;
        $fecha2 = $this->fecha2;
        $date = Carbon::now();
        $seleccion = $this->seleccion;
        $idmall = auth()->user()->id_mall;

        if($seleccion == 2){
            $nombre = "Segundo_Piso";
        }

            $datosSegmentoEntrada = DB::connection('mysql_4')->table('datos_seg_historicos_r2')
                ->select(DB::raw('sum(`08`) as Ocho, sum(`09`) as Nueve,
                            sum(`10`) as Diez, sum(`11`) as Once,
                            sum(`12`) as Doce, sum(`13`) as Trece,
                            sum(`14`) as Catorce, sum(`15`) as Quince,
                            sum(`16`) as Dieciseis, sum(`17`) as Diecisiete,
                            sum(`18`) as Dieciocho, sum(`19`) as Diecinueve,
                            sum(`20`) as Veinte, sum(`21`) as Veintiuno,
                            sum(`22`) as Veintidos, sum(`23`) as Veintitres', 'Tipo'), 'date')
                ->whereBetween('date', [$fecha, $fecha2])
                ->where('Tipo', '=', 'Total Entradas')
                ->groupBy('Tipo', 'date')
                ->get();
       

        return view('layouts.buscar.excel', compact('datosSegmentoEntrada', 'date', 'nombre', 'seleccion', 'idmall'));
    }
}
