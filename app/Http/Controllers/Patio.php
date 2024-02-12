<?php

namespace App\Http\Controllers;

use App\Models\ConsultasModel;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Patio extends Controller
{
    public function index2()
    {
        $ConsultasModel = new ConsultasModel();
        $uActualizacion = $ConsultasModel->uActualizacion();
        $date = Carbon::now()->locale('es');
        $fechaHoy = $date->translatedFormat('l j F Y');
        $mesActual = $date->translatedFormat('F');
        $mesAnterior = Carbon::now()->subMonth(1)->translatedFormat('F');
        $mesActualNumero = $date->translatedFormat('m');
        $mesActualNumeroANT = $date->subMonth(1)->translatedFormat('m');
        $endDate = Carbon::now()->subDay()->translatedFormat('l j F Y');

        $idmall = auth()->user()->id_mall;
        $roleid = auth()->user()->role_id;

        $fechaSemanaPasada1 = $ConsultasModel->fechaSemanaPasada1();

        $fechaSemanaPasada2 = $ConsultasModel->fechaSemanaPasada2();

        $dHoyGrafico = $ConsultasModel->dHoyGraficoPatio();
        $dHoy = $ConsultasModel->getAforoHoyPatio();
        $dAyer = $ConsultasModel->dAyerPatio();
        $dAyerGrafico = $ConsultasModel->dAyerGraficoPatio();
        $datosAnuales = $ConsultasModel->datosAnualesPatio();
        $datosMensuales = $ConsultasModel->datosMensualesPatio();
        $camaraSectorAnterior = $ConsultasModel->camaraSectorAnteriorPatio();
        $comparativoMesActual = $ConsultasModel->comparativoMesActualPatio();
        $comparativoMesAnterior = $ConsultasModel->comparativoMesAnteriorPatio();

        $semanaPasada = $ConsultasModel->semanaPasada();

        $js_content = [
            '0' => 'layouts.patio.js.PatioJS'
        ];
        //pre_die($dHoy);
        //pre_die($dAyer);

        return view('layouts.patio.patio', compact(
            'js_content',
            'comparativoMesActual',
            'comparativoMesAnterior',
            'camaraSectorAnterior',
            'dHoy',
            'dAyer',
            'dAyerGrafico',
            'dHoyGrafico',
            'uActualizacion',
            'semanaPasada',
            'date',
            'fechaHoy',
            'endDate',
            'datosAnuales',
            'datosMensuales',
            'mesActual',
            'mesAnterior',
            'idmall',
            'roleid'
        ));
    }

    public function index3()
    {

        $idmall = auth()->user()->id_mall;
        $nombreMall = [];

        switch ($idmall) {
            case 1:
                $nombreMall = "San Fernando";
                $dHoy = DB::connection('mysql_2')->table('total_personas_dia')
                    ->select(DB::raw('totalenternum Entradas'))
                    ->where('id', '=', '2')
                    ->get();
                break;
            default:
                $dHoy = [];
                $nombreMall = "Error";
                '<h1>Pagina Prohibida</h1>';
        }

        return view('layouts.patio.monitor', compact('dHoy', 'nombreMall'));
    }
}
