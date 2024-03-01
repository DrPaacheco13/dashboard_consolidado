<?php

namespace App\Http\Controllers;

use App\Models\ConsultasModel;
use App\Models\GerentesModel;
use App\Models\MallsModel;
use App\Models\TendenciasModel;
use App\Models\UsersModel;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GerenteController extends Controller
{


    public function __construct()
    {
        // $this->middleware('auth');
    }

    public function index()
    {
        $idmall = auth()->user()->id_mall;
        $distribucion_id = auth()->user()->distribucion_id;
        $role_id = auth()->user()->role_id;

        // pre_die($distribucion_id);
        $datos_malls = GetDataApi('administracion-gerente', $distribucion_id);
        // pre_die($datos_malls);
        $datos_malls = $datos_malls->malls;

        $data = [
            'nav_gerente_administracion' => true,
            'datos_malls' => !empty($datos_malls) ? $datos_malls : [],
            'no_top' => true,
            'idmall' => $idmall,
            'role_id' => $role_id,
            'js_content' => [
                0 => 'layouts/js/GeneralJS',
                1 => 'gerentes/js/AdministracionJS',
            ],
        ];
        // pre_die($datos)
        return view('gerentes.administracion_view', $data);
    }

    public function RedirectMall($mall_id)
    {
        if (!is_numeric($mall_id)) {
            return redirect('gerentes/resumen');
        }
        $role_id = auth()->user()->role_id;
        if ($role_id < 3) {
            return redirect('logoutSession');
        }
        $distribucion_id = auth()->user()->distribucion_id;
        $user_id = auth()->user()->id;
        $where_user = [
            // 'id_mall' => $mall_id,
            'user_id_reference' => $user_id,
            'estado' => true,
            'distribucion_id' => $distribucion_id,
            'deleted' => false,
            'temporal_user' => true,
        ];
        $user_temporal = GetRowByWhere('users', $where_user);

        if (empty($user_temporal)) {
            $this->GenerarUserTemporal($mall_id, $user_id, $distribucion_id);
            $user_temporal = GetRowByWhere('users', $where_user);
        } else {
            if ($user_temporal->id_mall !== $mall_id) {
                UpdateRow('users', ['id_mall' => $mall_id, 'updated_at' => GetTimeStamps()], $user_temporal->id);
            }
        }
        auth()->logout();
        auth()->loginUsingId($user_temporal->id);
        return redirect('/');
    }

    public function GerenteRetorna($distribucion_id, $user_id_reference)
    {
        $user_where = [
            'id' => $user_id_reference,
            'distribucion_id' => $distribucion_id,
            'estado' => true,
            'deleted' => false,
            'role_id' => 3,
        ];
        $user = GetRowByWhere('users', $user_where);
        // pre_die($user);
        if (empty($user)) {
            auth()->logout();
            return redirect('login');
        }
        auth()->logout();
        auth()->loginUsingId($user->id);
        return redirect('gerentes/resumen');
    }

    public function ResumenMalls()
    {
        $idmall = auth()->user()->id_mall;
        $distribucion_id = auth()->user()->distribucion_id;
        $datos_malls = GetDataApi('resumen-malls', $distribucion_id);
        // pre_die($datos_malls);
        // pre('kie');
        // pre_die($datos_malls);

        $data = [
            'resumen' => true,
            'datos_malls' => !empty($datos_malls) ? $datos_malls : [],
            'no_top' => true,
            'idmall' => $idmall,
            // 'role_id' => $role_id,
            'js_content' => [
                0 => 'layouts/js/GeneralJS',
                1 => 'gerentes/js/ResumenJS',
            ],
        ];
        // pre_die($datos)
        return view('gerentes.resumen_view', $data);
    }

    public function VerMall($mall_id)
    {

        $mall = GetRowByWhere('malls', ['estado' => true, 'deleted' => false, 'id' => $mall_id]);
        $accesos_habilitados = [];

        $accesos = ['r0', 'r1', 'r2', 'r3', 'vehicle', 'tendencia', 'marketing'];

        $aforo_actual = '';
        $aforoAyer = '';
        $personasSegmentoAyer = '';
        $personasSegmentoHoy = '';
        $timeActualizacion = '';
        $entradasCamaraAyer = '';
        $datosAnuales = '';
        $datosAnualesAnt = '';
        $datosMensuales = '';
        $datosMensualesAnt = '';
        $comparativoMesActual = '';
        $comparativoMesAnterior = '';
        $time_actualizacion = '';
        $aforo_hoy_grafico = '';
        $aforo_ayer = '';
        $aforo_ayer_grafico = '';
        $camara_sector_anterior = '';
        $datos_anuales = '';
        $datos_mensuales = '';

        foreach ($accesos as $acceso) {
            if (isset($mall->{'acceso_' . $acceso}) && $mall->{'acceso_' . $acceso} == true  || $acceso == 'marketing') {
                $reg = '';
                $rangoEtario = '';
                if ($acceso == 'r0') {
                    $reg = 'region0';
                }
                if ($acceso == 'r1') {
                    $reg = 'region1';
                }
                if ($acceso == 'r2') {
                    $reg = 'region2';
                }
                if ($acceso == 'r3') {
                    $reg = 'region3';
                }
                if ($acceso == 'vehicle') {
                    $reg = 'vehiculos';
                }
                if ($acceso == 'tendencia') {
                    $reg = 'tendencia';
                }
                if ($acceso == 'marketing') {
                    $reg = 'rango-etario-hoy';
                    $region = GetDataApi($reg, $mall_id);
                    $rangoEtario = !empty($region) ? $region->rango_etario_hoy : [];

                    $where_ms = [
                        'estado' => true,
                        'eliminado' => false,
                        'mall_id' => $mall_id
                    ];

                    $marketing_structure = QueryBuilder('view_marketing', $where_ms);
                    // pre_die($marketing_structure);
                    if (!empty($marketing_structure)) {
                        foreach ($rangoEtario as $rango) {
                            // pre($rango);
                            foreach ($marketing_structure as $key) {
                                // pre($key);
                                if ($rango->id == $key->entrada_marketing_id) {
                                    $rango->titulo_entrada = $key->titulo_entrada;
                                    // pre_die($rango);
                                } 
                            }
                        }
                    }
                    // pre_die($rangoEtario);
                }
                if ($acceso == 'r0' || $acceso == 'r1' || $acceso == 'r2' || $acceso == 'r3') {
                    $region = GetDataApi($reg, $mall_id);
                    // pre($acceso);
                    // pre($region);
                    // pre_die($region->entradas_camara_ayer_r1);
                    $aforo_actual = !empty($region->{'aforo_hoy_' . $acceso}) ? $region->{'aforo_hoy_' . $acceso} : [];
                    $aforoAyer = !empty($region->{'aforo_ayer_' . $acceso}) ? $region->{'aforo_ayer_' . $acceso} : [];
                    $personasSegmentoAyer = !empty($region->{'personas_segmento_ayer_' . $acceso}) ? $region->{'personas_segmento_ayer_' . $acceso} : [];
                    $personasSegmentoHoy = !empty($region->{'personas_segmento_hoy_' . $acceso}) ? $region->{'personas_segmento_hoy_' . $acceso} : [];
                    $timeActualizacion = !empty($region->time_actualizacion) ? $region->time_actualizacion : [];
                    $entradasCamaraAyer = !empty($region->{'entradas_camara_ayer_' . $acceso}) ? $region->{'entradas_camara_ayer_' . $acceso} : [];
                    $datosAnuales = !empty($region->{'datos_anuales_' . $acceso}) ? $region->{'datos_anuales_' . $acceso} : [];
                    $datosAnualesAnt = !empty($region->{'datos_anuales_ant_' . $acceso}) ? $region->{'datos_anuales_ant_' . $acceso} : [];
                    $datosMensuales = !empty($region->{'datos_mensuales_' . $acceso}) ? $region->{'datos_mensuales_' . $acceso} : [];
                    $datosMensualesAnt = !empty($region->{'datos_mensuales_ant_' . $acceso}) ? $region->{'datos_mensuales_ant_' . $acceso} : [];

                    $comparativoMesActual = !empty($region->{'comparativo_mes_actual_' . $acceso}) ? $region->{'comparativo_mes_actual_' . $acceso} : [];
                    $comparativoMesAnterior = !empty($region->{'comparativo_mes_anterior_' . $acceso}) ? $region->{'comparativo_mes_anterior_' . $acceso} : [];
                }
                if ($acceso == 'vehicle') {
                    $reg = "get-aforo/$acceso/$mall_id";
                    $region_vehicle = GetDataApi($reg);
                    $region_vehicle = $region_vehicle->data;
                    // pre($reg);
                    // $time_actualizacion = !empty($region->time_actualizacion) ? $region->time_actualizacion : [];
                    $aforo_hoy_grafico = !empty($region_vehicle->aforo_segmentado) ? $region_vehicle->aforo_segmentado : [];
                    $aforo_actual = !empty($region_vehicle->aforo_actual) ? $region_vehicle->aforo_actual : [];
                    // pre_die($aforo_actual);
                    // pre($region_vehicle);
                    // pre_die($aforo_hoy_grafico);

                    // $aforo_ayer = !empty($region->aforo_ayer) ? $region->aforo_ayer : [];
                    // $aforo_ayer_grafico = !empty($region->aforo_ayer_grafico) ? $region->aforo_ayer_grafico : [];
                    // $camara_sector_anterior = !empty($region->camara_sector_anterior) ? $region->camara_sector_anterior : [];
                    // $datos_anuales = !empty($region->datos_anuales) ? $region->datos_anuales : [];
                    // $datos_mensuales = !empty($region->datos_mensuales) ? $region->datos_mensuales : [];
                }



                $datosAnioAnt = [];
                $meses = obtenerMesesDelAnio();
                // pre($acceso);
                foreach ($meses as $mes) {
                    $encontrado = false; // Bandera para verificar si se encontró el mes
                    if (!empty($datosAnualesAnt)) {
                        # code...
                        foreach ($datosAnualesAnt as $dato) {
                            if (!empty($dato)) {

                                if (StrUpper($mes) == StrUpper($dato->mes)) {
                                    // pre($dato->mes);
                                    $datosAnioAnt[] = $dato;
                                    $encontrado = true;
                                    break; // Terminar el bucle una vez que se haya encontrado el mes
                                }
                            }
                        }
                    }
                    if (!$encontrado) {
                        $datosAnioAnt[] = []; // Si no se encontró el mes, agregar un array vacío
                    }
                }
                $datosAnualesAnt = $datosAnioAnt;
                $date = Carbon::now()->locale('es');

                $mesActual = $date->translatedFormat('F');



                $data_region = [
                    'region' => $acceso,
                    'entradasCamaraAyer' => !empty($entradasCamaraAyer) ? $entradasCamaraAyer : [],
                    'aforo_ayer' => !empty($aforoAyer) ? $aforoAyer[0]->totalenternum : '',
                    'personasSegmentoAyer' => $personasSegmentoAyer,
                    'personasSegmentoHoy' => $personasSegmentoHoy,
                    'timeActualizacion' => $timeActualizacion,
                    'datosAnuales' => $datosAnuales,
                    'datosAnualesAnt' => $datosAnualesAnt,
                    'datosMensuales' => $datosMensuales,
                    'datosMensualesAnt' => $datosMensualesAnt,
                    'comparativoMesActual' => $comparativoMesActual,
                    'comparativoMesAnterior' => $comparativoMesAnterior,
                    'time_actualizacion' => $time_actualizacion,
                    'aforo_hoy_grafico' => $aforo_hoy_grafico,
                    'aforo_ayer' => $aforo_ayer,
                    'aforo_ayer_grafico' => $aforo_ayer_grafico,
                    'camara_sector_anterior' => $camara_sector_anterior,
                    'datos_anuales' => $datos_anuales,
                    'datos_mensuales' => $datos_mensuales,
                    'mesActual' => $mesActual,
                    'rangoEtario' => $rangoEtario,
                    'aforo_actual' => $aforo_actual,
                    // 'aforo_ayer' => $aforoAyer,

                ];


                $accesos_habilitados['data_acceso_' . $acceso] = $data_region;
                switch ($acceso) {
                    case 'vehicle':
                        $accesos_habilitados[$acceso] = 'VEHICULOS';
                        break;
                    case 'tendencia':
                        $accesos_habilitados[$acceso] = 'TENDENCIA';
                        break;
                    case 'marketing':
                        // pre_die($data_region);
                        $accesos_habilitados[$acceso] = 'MARKETING';
                        break;
                    default:
                        $accesos_habilitados[$acceso] = $mall->{'acceso_' . $acceso . '_nombre'};
                }
            }
        }
        // pre_die($accesos_habilitados);

        // pre_die("acceso");
        // $view = view('gerentes.content_view', $data_region);

        $data = [
            'resumen' => true,
            'datos_malls' => !empty($datos_malls) ? $datos_malls : [],
            'nombre_mall' => $mall->nombre,
            'no_top' => true,
            // 'view2' => $view,
            'idmall' => $mall_id,
            'accesos_habilitados' => $accesos_habilitados,
            'data_region' => $data_region,
            'js_content' => [
                0 => 'layouts/js/GeneralJS',
                1 => 'gerentes/js/ResumenJS',
            ],
        ];
        return view('gerentes.ver_mall_view', $data);
    }


    protected function GenerarUserTemporal($mall_id, $user_id, $distribucion_id)
    {
        $rand = rand(111111, 999999);
        $new_user = [
            'name' => "Usuario Temporal #$rand",
            'email' => "user_temporal$rand@dmtech.cl",
            'password' => bcrypt(1234),
            'distribucion_id' => $distribucion_id,
            'role_id' => 4,
            'estado' => true,
            'deleted' => false,
            'temporal_user' => true,
            'id_mall' => $mall_id,
            'user_id_reference' => $user_id,
            'created_at' => GetTimeStamps()
        ];

        $valida = InsertRow('users', $new_user);

        return $valida > 0 ? $valida : 0;
    }
}
