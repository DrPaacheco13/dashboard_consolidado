<?php

namespace App\Exports;

use App\Models\PDFModel;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;

class SegmentoExcel implements FromView, ShouldAutoSize, WithHeadings
{
    use Exportable;
    protected $fecha;
    protected $fecha2;
    protected $seleccion;
    protected $idmall;
    protected $region;

    public function headings(): array
    {
        return [
            'Fecha',
            'Segmento',
            'Entrada',
        ];
    }

    public function __construct($fecha, $fecha2, $seleccion, $idmall)
    {
        $this->fecha = $fecha;
        $this->fecha2 = $fecha2;
        $this->seleccion = $seleccion;
        $this->idmall = $idmall;
    }

    public function view(): View
    {
        $date = Carbon::now();
        $idmall = $this->idmall;
        $seleccion = $this->seleccion;
        $Consulta = new PDFModel();
        $mall = QueryBuilder('malls', ['id' => $idmall]);
        if ($seleccion == 1) {
            $datos_segmentados = $Consulta->GetSegmentoEntradaGroupR1($this->fecha, $this->fecha2);
        } elseif ($seleccion == 2) {
            $datos_segmentados = $Consulta->GetSegmentoEntradaGroupR2($this->fecha, $this->fecha2);
        } elseif ($seleccion == 3) {
        }
        $nombre_mall = !empty($mall) ? $mall[0]->nombre : 'Sin Información';
        return view('layouts.buscar.excel', compact('datos_segmentados', 'seleccion', 'date', 'idmall', 'nombre_mall'));
    }
}
