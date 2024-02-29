<?php

namespace App\Http\Controllers;

use App\Models\MarketingModel;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MarketingController extends Controller
{
    public function index()
    {
        $date = Carbon::now()->locale('es');
        $fechaMarketing = $date->translatedFormat('l j F Y');
        $dateAnt = Carbon::yesterday()->locale('es');
        $fechaMarketingAnt = $dateAnt->translatedFormat('l j F Y');
        $idmall = auth()->user()->id_mall;
        $roleid = auth()->user()->role_id;

        $rangoEtario = [];
        $logo_mall = '';
        // $idmall = 4;
        // pre_die($idmall);
        $Marketing = new MarketingModel();
        // $rangoEtario = $Marketing->rangoEtarioAll();
        $rangoEtario = GetDataApi('rango-etario-hoy', $idmall);
        // pre_die($rangoEtario);
        $rangoEtario = !empty($rangoEtario) ? $rangoEtario->rango_etario_hoy : [];

        $where_ms = [
            'estado' => true,
            'eliminado' => false,
            'mall_id' => $idmall
        ];
        //        pre_die($rangoEtario);

        $marketing_structure = QueryBuilder('view_marketing', $where_ms);
        if (!empty($marketing_structure)) {
            foreach ($rangoEtario as $rango) {
                foreach ($marketing_structure as $key) {
                    if ($rango->id == $key->entrada_marketing_id) {
                        $rango->titulo_entrada = $key->titulo_entrada;
                        // pre_die($rango);
                    }
                }
            }
        }
        $js_content = [
            '0' => 'layouts.marketing.js.MarketingDiaJS'
        ];
        $mall = GetRowByWhere('malls', ['id' => $idmall]);
        $valida_reload = true;
        $nav_marketing_dia = true;
        $seccion_flujo = StrUpper('Características de Clientes');
        $nombre_mall = StrUpper($mall->nombre);
        $acceso_mall = StrUpper($fechaMarketing);
        return view('layouts.marketing.index', compact(
            'nav_marketing_dia',
            'valida_reload',
            'nombre_mall',
            'acceso_mall',
            'seccion_flujo',
            'js_content',
            'logo_mall',
            'date',
            'fechaMarketing',
            'dateAnt',
            'idmall',
            'rangoEtario',
            'roleid',
        ));
    }

    public function index2()
    {
        $dateAnt = Carbon::yesterday()->locale('es');
        $fechaMarketingAnt = $dateAnt->translatedFormat('l j F Y');

        $idmall = auth()->user()->id_mall;
        $fechaMarketing = $dateAnt->translatedFormat('l j F Y');
        $MarketingModel = new MarketingModel();

        // $rangoEtarioAnterior = $MarketingModel->rangoEtarioAnterior();
        //pre_die($rangoEtarioAnterior);

        $rangoEtarioAnterior = GetDataApi('rango-etario-ayer', $idmall);
        // pre_die($rangoEtarioAnterior);
        $rangoEtarioAnterior = !empty($rangoEtarioAnterior) ? $rangoEtarioAnterior->rango_etario_ayer : [];

        $where_ms = [
            'estado' => true,
            'eliminado' => false,
            'mall_id' => $idmall
        ];
        $marketing_structure = QueryBuilder('view_marketing', $where_ms);
        if (!empty($marketing_structure)) {
            foreach ($rangoEtarioAnterior as $rango) {
                foreach ($marketing_structure as $key) {
                    if ($rango->id == $key->entrada_marketing_id) {
                        $rango->titulo_entrada = $key->titulo_entrada;
                    }
                }
            }
        }
        $valida_reload = true;
        $nav_marketing_anterior = true;
        $mall = GetRowByWhere('malls', ['id' => $idmall]);
        //$valida_reload = true;
        $seccion_flujo = StrUpper('Características de Clientes');
        $nombre_mall = StrUpper($mall->nombre);
        $acceso_mall = StrUpper($fechaMarketing);

        // $yesterday_text = GetYesterdayText();
        // pre_die($rangoEtarioAnterior);
        return view('layouts.marketing.index2', compact(
            'nav_marketing_anterior',
            'acceso_mall',
            'nombre_mall',
            'seccion_flujo',
            'valida_reload',
            // 'yesterday_text',
            'rangoEtarioAnterior',
            'fechaMarketingAnt',
            'idmall',
            'fechaMarketing'
        ));
    }

    public function MarketingHistorico(Request $request)
    {
        $fecha = trim($request->get('fecha'));
        $fecha2 = trim($request->get('fecha2'));
        $idmall = auth()->user()->id_mall;
        $rangoEtario = [];
        $datos = [];

        $region = $request->get('region');
        $post = $request->all();
        $MarketingModel = new MarketingModel();
        if (!empty($post)) {
            $region = $post['region'];
            $fecha_inicial = $post['fecha_inicial'];
            $fecha_final = $post['fecha_final'];
            $datos = $MarketingModel->GetRangoEtario($region, $fecha_inicial, $fecha_final);
            if (!empty($datos)) {
                $rsp = [
                    'tipo' => 'success',
                    'msg' => 'Datos cargados con éxito.',
                    'data' => !empty($datos[0]) ? $datos[0] : []
                ];
            } else {
                $rsp = [
                    'tipo' => 'error',
                    'msg' => 'No se han encontrado datos para cargar'
                ];
            }
            return json_encode($rsp);
        }
        /*if ($region == 1) {
            $rangoEtario = DB::connection('mysql_2')->table('personas_rf_historic')
                ->selectRaw('avg(hombres) as hombres, avg(mujeres) as mujeres, avg(`1`) as nino, avg(`2`) as adolecente, avg(`3`) as joven, avg(`4`) as adulto, avg(`5`) as anciano')
                ->whereBetween('date', [$fecha, $fecha2])
                ->where('ipaddress', '=', '192.168.1.212')
                ->get();
        } elseif ($region == 2) {
            $rangoEtario = DB::connection('mysql_2')->table('personas_rf_historic')
                ->selectRaw('avg(hombres) as hombres, avg(mujeres) as mujeres, avg(`1`) as nino, avg(`2`) as adolecente, avg(`3`) as joven, avg(`4`) as adulto, avg(`5`) as anciano')
                ->whereBetween('date', [$fecha, $fecha2])
                ->where('ipaddress', '=', '192.168.1.242')
                ->get();
        }*/

        $js_content = [
            '0' => 'layouts.js.GeneralJS',
            '1' => 'layouts.marketing.js.MarketingHistoricoJS'
        ];
        $valida_reload = true;
        return view('layouts.marketing.marketing_historico_view', compact(
            'valida_reload',
            'js_content',
            'fecha',
            'fecha2',
            'idmall',
            'rangoEtario',
            'region'
        ));
    }
}
