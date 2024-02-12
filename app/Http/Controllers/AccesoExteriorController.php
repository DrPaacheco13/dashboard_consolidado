<?php

namespace App\Http\Controllers;

use App\Models\ExteriorModel;
use App\Models\TendenciasModel;
use App\Models\VehiculosModel;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AccesoExteriorController extends Controller
{
 
    public function index()
    {
        $date = Carbon::now()->locale('es');
        $fechaHoy = $date->translatedFormat('l j F Y');
        $mesActual = $date->translatedFormat('F');
        $mesAnterior = Carbon::now()->subMonth(1)->translatedFormat('F');
        $mesActualNumero = $date->translatedFormat('m');
        $mesActualNumeroANT = $date->subMonth(1)->translatedFormat('m');
        $endDate = Carbon::now()->subDay()->translatedFormat('l j F Y');

        $ExteriorModel = new ExteriorModel();
        
        $dHoyGraficoCamaras = $ExteriorModel->dHoyGraficoCamaras();
        $dHoy = $ExteriorModel->dHoy();
        $dAyer = $ExteriorModel->dAyer();
        $dAyerGrafico = $ExteriorModel->dAyerGrafico();
        $dHoyGrafico = $ExteriorModel->dHoyGrafico();
        $uActualizacion = $ExteriorModel->uActualizacion();
        $camaraSectorAnterior = $ExteriorModel->camaraSectorAnterior();
        $datosAnuales = $ExteriorModel->datosAnuales();
        $datosMensuales = $ExteriorModel->datosMensuales();
        
        $comparativoMesActual = $ExteriorModel->comparativoMesActualExterior();
        $comparativoMesAnterior = $ExteriorModel->comparativoMesAnteriorExterior();

        $idmall = auth()->user()->id_mall;

        $js_content = [
            '0' => 'layouts.exterior.js.AccesoExteriorJS'
        ];
        //pre_die($dAyerGrafico);
        return view('layouts.exterior.acceso_exterior', compact(
            'comparativoMesActual',
            'comparativoMesAnterior',
            'idmall',
            'js_content',
            'dHoy',
            'dAyer',
            'dAyerGrafico',
            'dHoyGrafico',
            'uActualizacion',
            'fechaHoy',
            'endDate',
            'datosAnuales',
            'camaraSectorAnterior',
            'mesActual',
            'datosMensuales',
            'mesAnterior',
            'dHoyGraficoCamaras'
        ));
    }
}
