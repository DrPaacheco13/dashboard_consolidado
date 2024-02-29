<?php

namespace App\Http\Controllers;

use App\Models\TendenciasModel;
use App\Models\VehiculosModel;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VehiculosController extends Controller
{
    public function index()
    {
        $date = Carbon::now()->locale('es');
        $fechaHoy = $date->translatedFormat('l j F Y');
        $endDate = Carbon::now()->subDay()->translatedFormat('l j F Y');
        $mesActual = $date->translatedFormat('F');
        $roleid = auth()->user()->role_id;
        $idmall = auth()->user()->id_mall;
        $VehiculosModel = new VehiculosModel();
        $view_vehicle = GetRowByWhere('view_vehicle', ['mall_id' => $idmall]);  
        $salidasVehiculos = null;
        if($view_vehicle->mostrar_flujo_personas){
            $salidasVehiculos = GetDataApi('salidas-vehiculos', $idmall, ", personas");
            // $salidasVehiculos = $VehiculosModel->salidasVehiculosTendencia();
        }else{
            $salidasVehiculos = GetDataApi('salidas-vehiculos', $idmall, ', totalexit');
            // pre_die($salidasVehiculos);
        }
        // $patenteVehiculos = $VehiculosModel->patenteVehiculos();
        
        //pre_die($salidasVehiculos);

        // $dHoyGrafico = $VehiculosModel->dHoyGrafico();
        // $dAyer = $VehiculosModel->dAyer();
        // $dAyerGrafico = $VehiculosModel->dAyerGrafico();
        // $camaraSectorAnterior = $VehiculosModel->camaraSectorAnterior();
        // // pre_die($datosAnuales);
        // $datosAnuales = $VehiculosModel->datosAnuales();
        // $datosMensuales = $VehiculosModel->datosMensuales();
        $vehiculos = GetDataApi('vehiculos', $idmall);
        // pre_die($vehiculos);
        $time_actualizacion = !empty($vehiculos->time_actualizacion) ? $vehiculos->time_actualizacion : [];
        $aforo_hoy_grafico = !empty($vehiculos->aforo_hoy_grafico) ? $vehiculos->aforo_hoy_grafico : [];
        $aforo_ayer = !empty($vehiculos->aforo_ayer) ? $vehiculos->aforo_ayer : [];
        $aforo_ayer_grafico = !empty($vehiculos->aforo_ayer_grafico) ? $vehiculos->aforo_ayer_grafico : [];
        $camara_sector_anterior = !empty($vehiculos->camara_sector_anterior) ? $vehiculos->camara_sector_anterior : [];
        $datos_anuales = !empty($vehiculos->datos_anuales) ? $vehiculos->datos_anuales : [];
        $datos_mensuales = !empty($vehiculos->datos_mensuales) ? $vehiculos->datos_mensuales : [];
       
        $js_content = [
            '0' => 'vehiculos/js/VehiculoJS'
        ];
        
        // pre_die($time_actualizacion);
        $mall = GetRowByWhere('malls', ['id' => $idmall]);
        $logo_mall = !empty($mall->imagen) ? $mall->imagen : '';
        $nombre_mall = !empty($mall->nombre) ? StrUpper($mall->nombre) : '';
        //$acceso_mall = !empty($mall->acceso_r1_nombre) ? $mall->acceso_r1_nombre : '';
        // $nav_acceso_r1 = true;
        $nav_acceso_vehicle = true;
        $seccion_flujo = 'FLUJO DE VEHICULOS';
        $salidasVehiculos = !empty($salidasVehiculos->salidas_vehiculos) ? $salidasVehiculos->salidas_vehiculos[0] : [];
        return view('vehiculos.home', compact(
            'logo_mall',
            'nombre_mall',
            //'acceso_mall',
            'nav_acceso_vehicle',
            'seccion_flujo',
            'js_content',
            'view_vehicle',
            'salidasVehiculos',
            'fechaHoy',
            'time_actualizacion',
            'endDate',
            'aforo_ayer',
            'camara_sector_anterior',
            'aforo_hoy_grafico',
            'datos_anuales',
            'mesActual',
            'datos_mensuales',
            'aforo_ayer_grafico',
            'idmall',
            'roleid'
        ));
    }

    //TENDENCIA PERSONAS X VEHICULOS
    public function vehiculosPersonas()
    {
        $date = Carbon::now()->locale('es');
        $fechaHoy = $date->translatedFormat('l j F Y');
        $endDate = Carbon::now()->subDay()->translatedFormat('l j F Y');
        $mesAnterior = Carbon::now()->subMonth(1)->translatedFormat('F');
        $mesActualNumero = $date->translatedFormat('m');
        $mesActualNumeroANT = $date->subMonth(1)->translatedFormat('m');
        $Consulta = new TendenciasModel();
        $idmall = auth()->user()->id_mall;

        
        $tendencia = GetDataApi('tendencia', $idmall);
        
        // $uActualizacion = $Consulta->uActualizacion();
        // $dHoy = $Consulta->dHoy();
        // $dHoyGrafico = $Consulta->dHoyGrafico();
        // $dAyer = $Consulta->dAyer();
        // $dAyerGrafico = $Consulta->dAyerGrafico();

        $uActualizacion = !empty($tendencia->time_actualizacion) ? $tendencia->time_actualizacion : [];
        
        $aforo_hoy = !empty($tendencia->aforo_hoy) ? $tendencia->aforo_hoy : [];
        $aforo_hoy_grafico = !empty($tendencia->aforo_hoy_grafico) ? $tendencia->aforo_hoy_grafico : [];
        $aforo_ayer = !empty($tendencia->aforo_ayer) ? $tendencia->aforo_ayer : [];
        $aforo_ayer_grafico = !empty($tendencia->aforo_ayer_grafico) ? $tendencia->aforo_ayer_grafico : [];


        $js_content = [
            '0' => 'vehiculos.js.TendenciasJS'
        ];
        $seccion_flujo = 'FLUJO DE VEHICULOS';

        return view('vehiculos.tendencia_personas', compact(
            'js_content',
            'date',
            'fechaHoy',
            'endDate',
            'mesAnterior',
            'mesActualNumero',
            'mesActualNumeroANT',
            'uActualizacion',
            'aforo_hoy_grafico',
            'aforo_ayer_grafico',
            'aforo_hoy',
            'idmall',
            'aforo_ayer'
        ));
    }

    public function BuscarPatente(Request $request)
    {
        $post = $request->all();
        $rsp = [];
        $idmall = auth()->user()->id_mall;

        if (!empty($post)) {

            $data = !empty($post) ? $post['data'] : [];
            $texto = !empty($data['texto']) ? $data['texto'] : '';
            $fecha_inicial = !empty($data['fecha_inicial']) ? $data['fecha_inicial'] : '';
            $fecha_final = !empty($data['fecha_final']) ? $data['fecha_final'] : '';
            $page = !empty($data['page']) ? $data['page'] : '';
            $perPage = 10; // Número de resultados por página por defecto es 10
            $VehiculosModel = new VehiculosModel();
            $result = $VehiculosModel->patentesTexto($texto, $page, $perPage, $fecha_inicial, $fecha_final);
            $post_data = [
                'texto' => $texto,
                'fecha_inicial' => $fecha_inicial,
                'fecha_final' => $fecha_final,
                'page' => $page,
                'per_page', $perPage
            ];
            $endpoint = 'buscar-patentes';
            // pre_die($endpoint);
            // $result = GetDataApi($endpoint, $idmall, '', 'post', $post_data);
            if (!empty($result)) {
                $rsp = [
                    'tipo' => 'success',
                    'title' => 'Gestión de Vehiculos',
                    'msg' => 'Datos cargados con éxito.',
                    'data' => $result,
                ];
                http_response_code(200); // Código de estado HTTP: 200 OK
            } else {
                $rsp = [
                    'tipo' => 'warning',
                    'title' => 'Gestión de Vehiculos',
                    'msg' => 'No se han encontado resultados para los filtros establecidos.'
                ];
                http_response_code(404); // Código de estado HTTP: 200 OK
            }
        } else {
            $rsp = [
                'tipo' => 'error',
                'title' => 'Error de Validación',
                'msg' => 'Datos no recibidos por el servidor'
            ];
            http_response_code(400); // Código de estado HTTP: 200 OK
        }
        header('Content-Type: application/json');
        echo json_encode($rsp);
        exit;
    }

    public function buscarPatentes(Request $request)
    {
        $post = $request->all();
        $idmall = auth()->user()->id_mall;

        $texto = NULL;
        $fecha = NULL;
        $fecha2 = NULL;
        $data_fecha = $request->session()->get('data_fecha');
        if (!empty($post)) {
            $texto = trim($request->get('texto'));
            $fecha = trim($request->get('fecha'));
            $fecha2 = trim($request->get('fecha2'));
            $data_fechas = [
                'patente' => $texto,
                'fecha_inicio' => $fecha,
                'fecha_final' => $fecha2
            ];
            $request->session()->put('data_fechas', $data_fechas);
        }

        $Consulta = new VehiculosModel();

        // if (empty($fecha2)) {
        //     $patentes = $Consulta->patentesFechaTexto($texto, $fecha);
        // } else {
        //     $patentes = $Consulta->patentesFechaFechaTexto($texto, $fecha, $fecha2);
        // }

        // if (empty($fecha) && empty($fecha2)) {
        //     //    $patentes = $Consulta->patentesTexto($texto);
        // }
        $mall =GetRowByWhere('malls', ['id' => $idmall]);
        $patentes = [];
        $js_content = [
            '0' => 'layouts.js.GeneralJS',
            '1' => 'vehiculos.js.SearchVehiculoJS'
        ];
        $vehicle_search = true;
        $valida_reload = true;
        $seccion_flujo = 'FLUJO DE VEHICULOS';
        $nombre_mall = !empty($mall->nombre) ? StrUpper($mall->nombre) : '';
        $acceso_mall = 'BUSQUEDA DE PATENTES';
        $nav_acceso_search_vehicle = TRUE;

        return view('vehiculos.search', compact(
            'nav_acceso_search_vehicle',
            'js_content',
            'patentes',
            'acceso_mall',
            'nombre_mall',
            'seccion_flujo',
            'vehicle_search',
            'texto',
            'fecha',
            'valida_reload',
            'fecha2',
            'idmall',
        ));
    }
}
