<?php

namespace App\Http\Controllers;

use App\Models\ConsultasModel;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;


class HomeController extends Controller
{
    public function logout()
    {
        //logout user
        auth()->logout();
        // redirect to homepage
        return redirect('/');
    }

    public function __construct()
    {
       
    }

    public function index()
    {
        $role = auth()->user()->role_id;
        $mall_id = auth()->user()->id_mall;

        $mall = GetRowByWhere('malls', ['id' => $mall_id]);
        if ($role == 3) {
            return redirect()->route('gerentes/administracion');
        } elseif ($mall->acceso_r0 == true) {
            $view_r0 = GetRowByWhere('view_region_r0', ['mall_id' => $mall->id]);
            return redirect()->route('acceso.r0', ['url' => $view_r0->url_region]);
        } elseif ($mall->acceso_r1 == true) {
            $view_r1 = GetRowByWhere('view_region_r1', ['mall_id' => $mall->id]);
            return redirect()->route('acceso.r1', ['url' => $view_r1->url_region]);
        } {
            return redirect()->route('vehicle');
        }
        // $ConsultaModel = new ConsultasModel();
        // $dHoy = [];
        // $dAyer = [];
        // $dAyerGrafico = [];
        // $semanaPasada = [];
        // $dHoyGrafico = [];
        // $uActualizacion = [];
        // $fechaSemanaPasada1 = [];
        // $fechaSemanaPasada2 = [];
        // $graficoAnual = [];
        // $id_mall = [];
        // $nombreMall = [];
        // $anioTotal = [];
        // $camaraPrueba = [];
        // $date = Carbon::now()->locale('es');
        // $fechaHoy = $date->translatedFormat('l j F Y');
        // $endDate = Carbon::now()->subDay()->translatedFormat('l j F Y');
        // $mesActual = $date->translatedFormat('F');
        // $mesActualGrafico = Carbon::now()->locale('ES')->translatedFormat('F');
        // $mesActualNumero = $date->translatedFormat('m');
        // $mesActualNumeroANT = $date->subMonth(1)->translatedFormat('m');
        // $mesAnterior = Carbon::now()->subMonth(1)->translatedFormat('F');
        // $idmall = auth()->user()->id_mall;
        // $dbname = NULL;

        // $logo_mall = null;
        // switch ($idmall) {
        //     case 1:
        //         $logo_mall = 'logoSFernando';
        //         $nombreMall = "San Fernando";
        //         break;
        //     case 2:
        //         $logo_mall = 'logoCB';
        //         $nombreMall = "Coquimbo";
        //         break;
        //     case 3:
        //         $logo_mall = 'logoTP';
        //         $nombreMall = "Trapenses";
        //         break;
        //     case 4:
        //         $logo_mall = 'logoPA';
        //         $nombreMall = "Panorámico";
        //         break;
        // }


        // $comparativoMesActual = $ConsultaModel->comparativoMesActual();
        // $comparativoMesAnterior = $ConsultaModel->comparativoMesAnterior();

        // $datosAnuales = $ConsultaModel->datosAnuales();
        // $datosMensuales = $ConsultaModel->datosMensuales();

        // $uActualizacion =  $ConsultaModel->uActualizacion();
        // $dHoyGrafico = $ConsultaModel->dHoyGrafico();
        // $dHoy = $ConsultaModel->getAforoHoy();
        // $dAyer = $ConsultaModel->dAyer();
        // $dAyerGrafico = $ConsultaModel->dAyerGrafico();
        // $camaraSectorAnterior = $ConsultaModel->camaraSectorAnterior();
        // $js_content = [
        //     '0' => 'js/HomeJS'
        // ];
        // return view('home', compact(
        //     'js_content',
        //     'logo_mall',
        //     'dHoy',
        //     'dAyer',
        //     'dAyerGrafico',
        //     'dHoyGrafico',
        //     'fechaHoy',
        //     'idmall',
        //     'uActualizacion',
        //     'endDate',
        //     'mesAnterior',
        //     'camaraSectorAnterior',
        //     'datosAnuales',
        //     'datosMensuales',
        //     'comparativoMesActual',
        //     'comparativoMesAnterior',
        //     'mesActual',
        // ));
    }

    public function index2()
    {

        $uActualizacion = DB::connection('mysql_2')->select('SELECT time_format(timeupdate, "%H:%i") tiempo
                                                            FROM   dashboard_process
                                                            WHERE  id = 1');

        $idmall = auth()->user()->id_mall;

        $date = Carbon::now()->locale('es');
        $fechaHoy = $date->translatedFormat('l j F Y');
        $endDate = Carbon::now()->subDay()->translatedFormat('l j F Y');

        $graficoAnual = DB::connection('mysql_2')->table('total_personas_mes_r2')
            ->select(DB::raw('totalentradas tEntradas, mes'))
            ->get();

        $fechaSemanaPasada1 = DB::connection('mysql_2')->table('semana_r2_historic')
            ->select(DB::raw('date_format(date, "%d-%m-%Y") Fecha1'))
            ->where('id', '=', '1')
            ->get();

        $fechaSemanaPasada2 = DB::connection('mysql_2')->table('semana_r2_historic')
            ->select(DB::raw('date_format(date, "%d-%m-%Y") Fecha2'))
            ->where('id', '=', '7')
            ->get();

        $aforoActual = DB::connection('mysql_2')->table('total_personas_dia')
            ->select(DB::raw('totalenternum Entrada, totalexitnum Salida, aforo as Aforo, ocupacion Porcentaje'))
            ->where('id', '=', '2')
            ->get();

        $dHoyGrafico = DB::connection('mysql_2')->table('personas_segmento_dia_r2')
            ->select(DB::raw('totalenternum Entrada, totalexitnum Salida, aforo as Aforo'))
            ->get();

        $dHoy = DB::connection('mysql_2')->table('total_personas_dia')
            ->select(DB::raw('totalenternum Entradas, totalexitnum Salidas, aforo as Aforo, ocupacion Porcentaje, 1560 - aforo as Restante'))
            ->where('id', '=', '2')
            ->get();

        $dAyer = DB::connection('mysql_2')->table('personas_dia_ant_r2')
            ->select(DB::raw('totalenternum as Entradas, totalexitnum as Salidas, aforomax as AforoMaximo, aforomin as AforoMinimo, ocupacion'))
            ->get();

        $dAyerGrafico = DB::connection('mysql_2')->table('personas_segmento_dia_ant_r2')
            ->select(DB::raw('totalenternum as Entradas, segmento'))
            ->get();

        $semanaPasada = DB::connection('mysql_2')->table('semana_r2_historic')
            ->select(DB::raw('dia as dia, max as maximo, promedio as promedio, aforo'))
            ->get();

        $idmall = auth()->user()->id_mall;
        $icon = '';

        switch ($idmall) {
            case '1':
                $icon = 'logoSFernando';
                $nombreMall = "San Fernando";

                break;
            case '2':
                $icon = 'logoCB';
                $nombreMall = "Panorámico";

                break;
            case '3':
                $icon = 'logoTP';
                $nombreMall = "Coquimbo";

                break;
            case '4':
                $icon = 'logoPA';
                break;
            default:
                $icon = 'logoSFernando';
                break;
        }

        return view('layouts.patio', compact(
            'dHoy',
            'dAyer',
            'dAyerGrafico',
            'dHoyGrafico',
            'uActualizacion',
            'semanaPasada',
            'date',
            'fechaHoy',
            'endDate',
            'fechaSemanaPasada1',
            'fechaSemanaPasada2',
            'graficoAnual',
            'idmall',
            'nombreMall',
            'endDate'
        ));
    }

    public function index3()
    {
        $dHoy = DB::connection('mysql_2')->table('total_personas_dia')
            ->select(DB::raw('totalenternum Entradas, totalexitnum Salidas, aforo as Aforo, ocupacion Porcentaje, 1560 - aforo as Restante'))
            ->where('id', '=', '2')
            ->get();

        return view('layouts.patio_concentrado', compact('dHoy'));
    }

    public function index4()
    {
        $uActualizacion = DB::connection('mysql_2')->select('SELECT time_format(timeupdate, "%H:%i") tiempo
                                                            FROM   dashboard_process
                                                            WHERE  id = 1');

        $idmall = auth()->user()->id_mall;

        switch ($idmall) {
            case 1:
                $nombreMall = "San Fernando";
                $dHoy = DB::connection('mysql_2')->table('total_personas_dia')
                    ->select(DB::raw('totalenternum Entradas, totalexitnum Salidas'))
                    ->where('id', '=', '1')
                    ->get();
                break;
            case 2:
                $nombreMall = "Panorámico";
                $dHoy = DB::connection($dbname)->table('total_personas_dia')
                    ->select(DB::raw('totalenternum Entradas, totalexitnum Salidas'))
                    ->where('id', '=', '1')
                    ->get();
                break;
            case 3:
                $nombreMall = "Coquimbo";
                $dHoy = DB::connection($dbname)->table('total_personas_dia')
                    ->select(DB::raw('total_enterNum Entradas, total_exitNum Salidas'))
                    ->where('id', '=', '1')
                    ->get();
                break;
        }
        return view('layouts.accesos', compact('dHoy', 'uActualizacion', 'nombreMall'));
    }
}
