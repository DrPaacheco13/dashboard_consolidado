<?php

namespace App\Http\Controllers;

use App\Models\ConsultasModel;
use App\Models\MallsModel;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Database\MySqlConnection;
use Illuminate\Http\Request;
use PDO;

class MallsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $idmall = auth()->user()->id_mall;
        $malls = QueryBuilder('malls', ['deleted' => false]);
        $js_content = [
            '0' => 'layouts.js.GeneralJS',
            '1' => 'malls.js.MallsJS',
        ];
        // pre_die($malls)
        $nav_mantenedor_malls = true;
        $nav_listado_malls = true;
        $no_top = true;
        $valida_reload = true;
        $nombre_mall = 'Listado de Malls';
        return view('malls.malls_listado_view', compact(
            'nombre_mall',
            'no_top',
            'malls',
            'nav_mantenedor_malls',
            'nav_listado_malls',
            'js_content',
            'idmall',
            'valida_reload',
        ));
    }

    public function NuevoMall(Request $request)
    {
        $post = $request->all();

        $idmall = auth()->user()->id_mall;
        $valida_reload = true;
        if (!empty($post)) {
            // pre($post);

            $camaras = $post['camaras'];


            // pre_die($post);
            // Validar los campos
            $validate = $this->ValidateFields($post);

            if ($validate) {
                // Mostrar errores de validación
                session()->flash('error', ['error' => 'Se han encontrado los siguientes errores: ' . implode(',', $validate), 'error_title' => 'Error al Validar Formulario']);
                return redirect('malls/nuevo')->withInput($post);
            }

            // Crear nuevo mall
            $new_mall = [
                'nombre' => $post['nombre'] ?? null,
                'descripcion' => $post['descripcion'] ?? null,
                'distribucion_id' => $post['distribucion_id'] ?? null,
                'estado' => true,
                'acceso_r0' => $post['acceso_r0'] == 1,
                'acceso_r1' => $post['acceso_r1'] == 1,
                'acceso_r2' => $post['acceso_r2'] == 1,
                'acceso_r3' => $post['acceso_r3'] == 1,
                'acceso_tendencia' => $post['acceso_tendencia'] == 1,
                'acceso_vehicle' => $post['acceso_vehicle'] == 1,
                'acceso_r0_nombre' => $post['acceso_r0_nombre'] ?? null,
                'acceso_r1_nombre' => $post['acceso_r1_nombre'] ?? null,
                'acceso_r2_nombre' => $post['acceso_r2_nombre'] ?? null,
                'acceso_r3_nombre' => $post['acceso_r3_nombre'] ?? null,
                'created_at' => GetTimeStamps()
            ];

            //pre_die($new_mall);
            $MallsModel = new MallsModel();
            $validateImg = [];
            if (!empty($post['logo'])) {
                if (!$validateImg = $this->validarYGuardarImagen($post['logo'])) {
                    pre_die("error");
                }
            }
            $ruta_destino = $validateImg['ruta_destino'];
            $nombre_archivo = $validateImg['nombre_archivo'];

            $post['logo']->move($ruta_destino, $nombre_archivo);
            $new_mall['logo'] = $ruta_destino . $nombre_archivo;

            $mall = $MallsModel->insertMall($new_mall);
            // Insertar nuevo mall

            if ($mall > 0) {
                // Éxito al registrar el nuevo Mall
                $mall_data = $MallsModel->GetLastMallInsert();
                $new_r0 = [];
                $new_r1 = [];
                $new_r2 = [];
                $new_r3 = [];
                $new_rvehicle = [];
                if (empty($mall_data)) {
                    session()->flash('error', ['error' => 'Mall no registrado, inténtelo nuevamente por favor', 'error_title' => 'Gestión de Malls']);
                    return redirect('malls/nuevo')->withInput($post);
                }

                $new_database = [
                    'nombre' => !empty($post['nombre']) ? $post['nombre'] : NULL,
                    'mall_id' => $mall_data->id,
                    'distribucion_id' => $mall_data->distribucion_id,
                    'estado' => true,
                    'deleted' => false,
                    'db_host' => !empty($post['db_host']) ? $post['db_host'] : NULL,
                    'db_port' => !empty($post['db_port']) ? $post['db_port'] : NULL,
                    'db_user' => !empty($post['db_user']) ? $post['db_user'] : NULL,
                    'db_name' => !empty($post['db_name']) ? $post['db_name'] : NULL,
                    'db_password' => !empty($post['db_password']) ? $post['db_password'] : NULL,
                    'created_at' => GetTimeStamps(),
                ];
                $database = InsertRow('databases', $new_database);

                if ($post['acceso_vehicle']) {
                    $new_rvehicle = [
                        'mostrar_flujo_personas' => !empty($post['mostrar_flujo_personas_rvehicle']) ? ($post['mostrar_flujo_personas_rvehicle'] == 1 ? true : false) : false,
                        'mostrar_total_entradas' => !empty($post['mostrar_total_entradas_rvehicle']) ? ($post['mostrar_total_entradas_rvehicle'] == 1 ? true : false) : false,
                        'mostrar_estadia_promedio' => !empty($post['mostrar_estadia_promedio_rvehicle']) ? ($post['mostrar_estadia_promedio_rvehicle'] == 1 ? true : false) : false,
                        'mostrar_entradas_segmentadas_hoy' => !empty($post['mostrar_entradas_segmentadas_hoy_rvehicle']) ? ($post['mostrar_entradas_segmentadas_hoy_rvehicle'] == 1 ? true : false) : false,
                        'mostrar_estadisticas_dia_anterior' => !empty($post['mostrar_estadisticas_dia_anterior_rvehicle']) ? ($post['mostrar_estadisticas_dia_anterior_rvehicle'] == 1 ? true : false) : false,
                        'mostrar_estadisticas_consolidadas_mes' => !empty($post['mostrar_estadisticas_consolidadas_mes_rvehicle']) ? ($post['mostrar_estadisticas_consolidadas_mes_rvehicle'] == 1 ? true : false) : false,
                        'mostrar_estadisticas_consolidadas_anio' => !empty($post['mostrar_estadisticas_consolidadas_anio_rvehicle']) ? ($post['mostrar_estadisticas_consolidadas_anio_rvehicle'] == 1 ? true : false) : false,
                        'mostrar_estadisticas_comparativas_mes_actual' => !empty($post['mostrar_estadisticas_comparativas_mes_actual_rvehicle']) ? ($post['mostrar_estadisticas_comparativas_mes_actual_rvehicle'] == 1 ? true : false) : false,
                        'mostrar_estadisticas_comparativas_mes_anterior' => !empty($post['mostrar_estadisticas_comparativas_mes_anterior_rvehicle']) ? ($post['mostrar_estadisticas_comparativas_mes_anterior_rvehicle'] == 1 ? true : false) : false,
                        'estado' => true,
                        'mall_id' => $mall_data->id, //Si se dejaba como antes, se podía caer y dejar en blanco el mall_id
                        'created_at' => GetTimeStamps()
                    ];
                }
                if ($post['acceso_r0']) {
                    $new_r0 = [
                        'mostrar_total_entradas_hoy' => !empty($post['mostrar_total_entradas_hoy_r0']) ? ($post['mostrar_total_entradas_hoy_r0'] == 1 ? true : false) : false,
                        'mostrar_entradas_segmentadas_hoy' => !empty($post['mostrar_entradas_segmentadas_hoy_r0']) ? ($post['mostrar_entradas_segmentadas_hoy_r0'] == 1 ? true : false) : false,
                        'mostrar_estadisticas_dia_anterior' => !empty($post['mostrar_estadisticas_dia_anterior_r0']) ? ($post['mostrar_estadisticas_dia_anterior_r0'] == 1 ? true : false) : false,
                        'mostrar_estadisticas_consolidadas_mes' => !empty($post['mostrar_estadisticas_consolidadas_mes_r0']) ? ($post['mostrar_estadisticas_consolidadas_mes_r0'] == 1 ? true : false) : false,
                        'mostrar_estadisticas_consolidadas_anio' => !empty($post['mostrar_estadisticas_consolidadas_anio_r0']) ? ($post['mostrar_estadisticas_consolidadas_anio_r0'] == 1 ? true : false) : false,
                        'mostrar_estadisticas_comparativas_mes_actual' => !empty($post['mostrar_estadisticas_comparativas_mes_actual_r0']) ? ($post['mostrar_estadisticas_comparativas_mes_actual_r0'] == 1 ? true : false) : false,
                        'mostrar_estadisticas_comparativas_mes_anterior' => !empty($post['mostrar_estadisticas_comparativas_mes_anterior_r0']) ? ($post['mostrar_estadisticas_comparativas_mes_anterior_r0'] == 1 ? true : false) : false,
                        'estado' => true,
                        'url_region' => getUrl($post['acceso_r0_nombre']),
                        'mall_id' => $mall_data->id, //Si se dejaba como antes, se podía caer y dejar en blanco el mall_id
                        'created_at' => GetTimeStamps()
                    ];
                }
                if ($post['acceso_r1']) {
                    $new_r1 = [
                        'mostrar_total_entradas_hoy' => !empty($post['mostrar_total_entradas_hoy_r1']) ? ($post['mostrar_total_entradas_hoy_r1'] == 1 ? true : false) : false,
                        'mostrar_entradas_segmentadas_hoy' => !empty($post['mostrar_entradas_segmentadas_hoy_r1']) ? ($post['mostrar_entradas_segmentadas_hoy_r1'] == 1 ? true : false) : false,
                        'mostrar_estadisticas_dia_anterior' => !empty($post['mostrar_estadisticas_dia_anterior_r1']) ? ($post['mostrar_estadisticas_dia_anterior_r1'] == 1 ? true : false) : false,
                        'mostrar_estadisticas_consolidadas_mes' => !empty($post['mostrar_estadisticas_consolidadas_mes_r1']) ? ($post['mostrar_estadisticas_consolidadas_mes_r1'] == 1 ? true : false) : false,
                        'mostrar_estadisticas_consolidadas_anio' => !empty($post['mostrar_estadisticas_consolidadas_anio_r1']) ? ($post['mostrar_estadisticas_consolidadas_anio_r1'] == 1 ? true : false) : false,
                        'mostrar_estadisticas_comparativas_mes_actual' => !empty($post['mostrar_estadisticas_comparativas_mes_actual_r1']) ? ($post['mostrar_estadisticas_comparativas_mes_actual_r1'] == 1 ? true : false) : false,
                        'mostrar_estadisticas_comparativas_mes_anterior' => !empty($post['mostrar_estadisticas_comparativas_mes_anterior_r1']) ? ($post['mostrar_estadisticas_comparativas_mes_anterior_r1'] == 1 ? true : false) : false,
                        'estado' => true,
                        'url_region' => getUrl($post['acceso_r1_nombre']),
                        'mall_id' => !empty($mall_data) ? $mall_data->id : '',
                        'created_at' => GetTimeStamps()
                        //Eliminar las que ya están y actualizar el updated_at
                    ];
                }
                if ($post['acceso_r2']) {
                    $new_r2 = [
                        'mostrar_total_entradas_hoy' => !empty($post['mostrar_total_entradas_hoy_r2']) ? ($post['mostrar_total_entradas_hoy_r2'] == 1 ? true : false) : false,
                        'mostrar_entradas_segmentadas_hoy' => !empty($post['mostrar_entradas_segmentadas_hoy_r2']) ? ($post['mostrar_entradas_segmentadas_hoy_r2'] == 1 ? true : false) : false,
                        'mostrar_estadisticas_dia_anterior' => !empty($post['mostrar_estadisticas_dia_anterior_r2']) ? ($post['mostrar_estadisticas_dia_anterior_r2'] == 1 ? true : false) : false,
                        'mostrar_estadisticas_consolidadas_mes' => !empty($post['mostrar_estadisticas_consolidadas_mes_r2']) ? ($post['mostrar_estadisticas_consolidadas_mes_r2'] == 1 ? true : false) : false,
                        'mostrar_estadisticas_consolidadas_anio' => !empty($post['mostrar_estadisticas_consolidadas_anio_r2']) ? ($post['mostrar_estadisticas_consolidadas_anio_r2'] == 1 ? true : false) : false,
                        'mostrar_estadisticas_comparativas_mes_actual' => !empty($post['mostrar_estadisticas_comparativas_mes_actual_r2']) ? ($post['mostrar_estadisticas_comparativas_mes_actual_r2'] == 1 ? true : false) : false,
                        'mostrar_estadisticas_comparativas_mes_anterior' => !empty($post['mostrar_estadisticas_comparativas_mes_anterior_r2']) ? ($post['mostrar_estadisticas_comparativas_mes_anterior_r2'] == 1 ? true : false) : false,
                        'estado' => true,
                        'url_region' => getUrl($post['acceso_r2_nombre']),
                        'mall_id' => !empty($mall_data) ? $mall_data->id : '',
                        'created_at' => GetTimeStamps()
                    ];
                }
                if ($post['acceso_r3']) {
                    $new_r3 = [
                        'mostrar_total_entradas_hoy' => !empty($post['mostrar_total_entradas_hoy_r3']) ? ($post['mostrar_total_entradas_hoy_r3'] == 1 ? true : false) : false,
                        'mostrar_entradas_segmentadas_hoy' => !empty($post['mostrar_entradas_segmentadas_hoy_r3']) ? ($post['mostrar_entradas_segmentadas_hoy_r3'] == 1 ? true : false) : false,
                        'mostrar_estadisticas_dia_anterior' => !empty($post['mostrar_estadisticas_dia_anterior_r3']) ? ($post['mostrar_estadisticas_dia_anterior_r3'] == 1 ? true : false) : false,
                        'mostrar_estadisticas_consolidadas_mes' => !empty($post['mostrar_estadisticas_consolidadas_mes_r3']) ? ($post['mostrar_estadisticas_consolidadas_mes_r3'] == 1 ? true : false) : false,
                        'mostrar_estadisticas_consolidadas_anio' => !empty($post['mostrar_estadisticas_consolidadas_anio_r3']) ? ($post['mostrar_estadisticas_consolidadas_anio_r3'] == 1 ? true : false) : false,
                        'mostrar_estadisticas_comparativas_mes_actual' => !empty($post['mostrar_estadisticas_comparativas_mes_actual_r3']) ? ($post['mostrar_estadisticas_comparativas_mes_actual_r3'] == 1 ? true : false) : false,
                        'mostrar_estadisticas_comparativas_mes_anterior' => !empty($post['mostrar_estadisticas_comparativas_mes_anterior_r3']) ? ($post['mostrar_estadisticas_comparativas_mes_anterior_r3'] == 1 ? true : false) : false,
                        'estado' => true,
                        'url_region' => getUrl($post['acceso_r3_nombre']),
                        'mall_id' => !empty($mall_data) ? $mall_data->id : '',
                        'created_at' => GetTimeStamps()
                    ];
                }

                $regiones = '';
                if (!empty($new_r0)) {
                    $r0 = InsertRow('view_region_r0', $new_r0);
                    if ($r0 > 0) {
                        $regiones .= 'Región 0';
                    }
                }
                if (!empty($new_r1)) {
                    $r1 = InsertRow('view_region_r1', $new_r1);
                    if ($r1 > 0) {
                        $regiones .= ', Región 1';
                    }
                }
                if (!empty($new_r2)) {
                    $r2 = InsertRow('view_region_r2', $new_r2);
                    if ($r2 > 0) {
                        $regiones .= ', Región 2';
                    }
                }
                if (!empty($new_r3)) {
                    $r3 = InsertRow('view_region_r3', $new_r3);
                    if ($r3 > 0) {
                        $regiones .= ', Región 3';
                    }
                }
                if (!empty($new_rvehicle)) {
                    $r3 = InsertRow('view_vehicle', $new_rvehicle);
                    if ($r3 > 0) {
                        $regiones .= ', Región Vehiculos';
                    }
                }

                // Iterar sobre cada par de marketing_id y nombre_camara
                if (!empty($camaras)) {
                    foreach ($camaras as $camara) {
                        $marketing_id = $camara['marketing_id'];
                        $nombre_camara = $camara['nombre_camara'];

                        $new_camera = [
                            'mall_id' => $mall_data->id,
                            'entrada_marketing_id' => $marketing_id,
                            'titulo_entrada' => $nombre_camara,
                            'estado' => true,
                            'eliminado' => 0,
                            'created_at' => GetTimeStamps()
                        ];
                        InsertRow('view_marketing', $new_camera);
                    }
                }

                session()->flash('success', ['success' => 'Se ha registrado con éxito el nuevo Mall, se han habilitado las regiones ' . $regiones, 'success_title' => 'Gestión de Malls']);
                return redirect('malls/listado');
            } else {
                // Error al registrar el Mall
                session()->flash('error', ['error' => 'Mall no registrado, inténtelo nuevamente por favor', 'error_title' => 'Gestión de Malls']);
                return redirect('malls/nuevo')->withInput($post);
            }
        }


        $js_content = [
            0 => 'layouts.js.GeneralJS',
            1 => 'malls.js.MallsNewJS'
        ];
        $nav_mantenedor_malls = true;
        $nav_nuevo_mall = true;
        $no_top = true;
        $valida_reload = true;
        return view('malls.malls_nuevo_view', compact(
            'nav_mantenedor_malls',
            'valida_reload',
            'valida_reload',
            'nav_nuevo_mall',
            'js_content',
            'idmall',
            'no_top',
        ));
    }

    public function EditarMall(Request $request, $id)
    {

        if (!is_numeric($id)) {
            session()->flash('error', ['error' => 'El Mall seleccionado no existe o fue eliminado.', 'error_title' => 'Gestión de Malls']);
            return redirect('malls/listado');
        }
        $idmall = $id;
        $r0_option = GetRowByWhere('view_region_r0', ['mall_id' => $idmall]);
        $r1_option = GetRowByWhere('view_region_r1', ['mall_id' => $idmall]);
        $r2_option = GetRowByWhere('view_region_r2', ['mall_id' => $idmall]);
        $r3_option = GetRowByWhere('view_region_r3', ['mall_id' => $idmall]);
        $rvehicle_option = GetRowByWhere('view_vehicle', ['mall_id' => $idmall]);
        // pre_die($r0_option);
        $MallsModel = new MallsModel();
        $mall = $MallsModel->getMall($id);
        if (empty($id)) {
            session()->flash('error', ['error' => 'El Mall seleccionado no existe o fue eliminado.', 'error_title' => 'Gestión de Malls']);
            return redirect('malls/listado');
        }
        $post = $request->all();
        if (!empty($post)) {

            $validate = $this->ValidateFields($post);

            if ($validate) {
                // Mostrar errores de validación
                session()->flash('error', ['error' => 'Se han encontrado los siguientes errores: ' . implode(',', $validate), 'error_title' => 'Error al Validar Formulario']);
                return redirect('malls/nuevo')->withInput($post);
            }

            // Crear nuevo mall
            $data_mall = [
                'nombre' => !empty($post['nombre']) ? $post['nombre'] : NULL,
                'estado' => true,
                'descripcion' => !empty($post['descripcion']) ? $post['descripcion'] : null,
                'distribucion_id' => !empty($post['distribucion_id']) ? $post['distribucion_id'] : null,
                'acceso_r1' => $post['acceso_r1'] == 1 ? true : false,
                'acceso_r2' => $post['acceso_r2'] == 1 ? true : false,
                'acceso_r3' => $post['acceso_r3'] == 1 ? true : false,
                'acceso_vehicle' => $post['acceso_vehicle'] == 1 ? true : false,
                'acceso_tendencia' => $post['acceso_tendencia'] == 1 ? true : false,
                'acceso_r1_nombre' => !empty($post['acceso_r1_nombre']) ? $post['acceso_r1_nombre'] : null,
                'acceso_r2_nombre' => !empty($post['acceso_r2_nombre']) ? $post['acceso_r2_nombre'] : null,
                'acceso_r3_nombre' => !empty($post['acceso_r3_nombre']) ? $post['acceso_r3_nombre'] : NULL,
                'updated_at' => GetTimeStamps()
            ];

            $MallsModel = new MallsModel();
            $validateImg = [];
            if (!empty($post['logo'])) {
                if (!$validateImg = $this->validarYGuardarImagen($post['logo'])) {
                    pre_die("error");
                }
                $ruta_destino = $validateImg['ruta_destino'];
                $nombre_archivo = $validateImg['nombre_archivo'];
                $post['logo']->move($ruta_destino, $nombre_archivo);
                $data_mall['logo'] = $ruta_destino . $nombre_archivo;
            }

            $mall = $MallsModel->updateMall($data_mall, $id);
            if (!empty($r0_option)) {
                $data_updt_r0 = [
                    'mostrar_total_entradas_hoy' => isset($post['mostrar_total_entradas_hoy_r0']) && $post['mostrar_total_entradas_hoy_r0'] == 1 ? true : false,
                    'mostrar_entradas_segmentadas_hoy' => isset($post['mostrar_entradas_segmentadas_hoy_r0']) &&  $post['mostrar_entradas_segmentadas_hoy_r0'] == 1 ? true : false,
                    'mostrar_estadisticas_dia_anterior' => isset($post['mostrar_estadisticas_dia_anterior_r0']) &&  $post['mostrar_estadisticas_dia_anterior_r0'] == 1 ? true : false,
                    'mostrar_estadisticas_consolidadas_mes' => isset($post['mostrar_estadisticas_consolidadas_mes_r0']) &&  $post['mostrar_estadisticas_consolidadas_mes_r0'] == 1 ? true : false,
                    'mostrar_estadisticas_consolidadas_anio' => isset($post['mostrar_estadisticas_consolidadas_anio_r0']) &&  $post['mostrar_estadisticas_consolidadas_anio_r0'] == 1 ? true : false,
                    'mostrar_estadisticas_comparativas_mes_actual' => isset($post['mostrar_estadisticas_comparativas_mes_actual_r0']) &&  $post['mostrar_estadisticas_comparativas_mes_actual_r0'] == 1 ? true : false,
                    'mostrar_estadisticas_comparativas_mes_anterior' => isset($post['mostrar_estadisticas_comparativas_mes_anterior_r0']) &&  $post['mostrar_estadisticas_comparativas_mes_anterior_r0'] == 1 ? true : false,
                    'updated_at' => GetTimeStamps(),
                    'estado' => isset($post['acceso_r0']) && $post['acceso_r0'] == 1 ? true : false,
                ];
                $rsp_v_r0 = UpdateRow('view_region_r0', $data_updt_r0, $r0_option->id);
            } else {
                if (isset($post['acceso_r0'])) {
                    $data_updt_r0 = [
                        'mostrar_total_entradas_hoy' => isset($post['mostrar_total_entradas_hoy_r0']) && $post['mostrar_total_entradas_hoy_r0'] == 1 ? true : false,
                        'mostrar_entradas_segmentadas_hoy' => isset($post['mostrar_entradas_segmentadas_hoy_r0']) &&  $post['mostrar_entradas_segmentadas_hoy_r0'] == 1 ? true : false,
                        'mostrar_estadisticas_dia_anterior' => isset($post['mostrar_estadisticas_dia_anterior_r0']) &&  $post['mostrar_estadisticas_dia_anterior_r0'] == 1 ? true : false,
                        'mostrar_estadisticas_consolidadas_mes' => isset($post['mostrar_estadisticas_consolidadas_mes_r0']) &&  $post['mostrar_estadisticas_consolidadas_mes_r0'] == 1 ? true : false,
                        'mostrar_estadisticas_consolidadas_anio' => isset($post['mostrar_estadisticas_consolidadas_anio_r0']) &&  $post['mostrar_estadisticas_consolidadas_anio_r0'] == 1 ? true : false,
                        'mostrar_estadisticas_comparativas_mes_actual' => isset($post['mostrar_estadisticas_comparativas_mes_actual_r0']) &&  $post['mostrar_estadisticas_comparativas_mes_actual_r0'] == 1 ? true : false,
                        'mostrar_estadisticas_comparativas_mes_anterior' => isset($post['mostrar_estadisticas_comparativas_mes_anterior_r0']) &&  $post['mostrar_estadisticas_comparativas_mes_anterior_r0'] == 1 ? true : false,
                        'created_at' => GetTimeStamps(),
                        'estado' => isset($post['acceso_r0']) && $post['acceso_r0'] == 1 ? true : false,
                        'mall_id' => $idmall,
                        'url_region' => isset($post['acceso_r0_nombre']) ? getUrl($post['acceso_r0_nombre']) : NULL,
                    ];
                    $rsp_v_r0 = InsertRow('view_region_r0', $data_updt_r0);
                }
            }
            if (!empty($r1_option)) {
                $data_updt_r1 = [
                    'mostrar_total_entradas_hoy' => isset($post['mostrar_total_entradas_hoy_r1']) && $post['mostrar_total_entradas_hoy_r1'] == 1 ? true : false,
                    'mostrar_entradas_segmentadas_hoy' => isset($post['mostrar_entradas_segmentadas_hoy_r1']) &&  $post['mostrar_entradas_segmentadas_hoy_r1'] == 1 ? true : false,
                    'mostrar_estadisticas_dia_anterior' => isset($post['mostrar_estadisticas_dia_anterior_r1']) &&  $post['mostrar_estadisticas_dia_anterior_r1'] == 1 ? true : false,
                    'mostrar_estadisticas_consolidadas_mes' => isset($post['mostrar_estadisticas_consolidadas_mes_r1']) &&  $post['mostrar_estadisticas_consolidadas_mes_r1'] == 1 ? true : false,
                    'mostrar_estadisticas_consolidadas_anio' => isset($post['mostrar_estadisticas_consolidadas_anio_r1']) &&  $post['mostrar_estadisticas_consolidadas_anio_r1'] == 1 ? true : false,
                    'mostrar_estadisticas_comparativas_mes_actual' => isset($post['mostrar_estadisticas_comparativas_mes_actual_r1']) &&  $post['mostrar_estadisticas_comparativas_mes_actual_r1'] == 1 ? true : false,
                    'mostrar_estadisticas_comparativas_mes_anterior' => isset($post['mostrar_estadisticas_comparativas_mes_anterior_r1']) &&  $post['mostrar_estadisticas_comparativas_mes_anterior_r1'] == 1 ? true : false,
                    'updated_at' => GetTimeStamps(),
                    'estado' => isset($post['acceso_r1']) && $post['acceso_r1'] == 1 ? true : false,

                ];
                $rsp_v_r1 = UpdateRow('view_region_r1', $data_updt_r1, $r1_option->id);
            } else {
                if (isset($post['acceso_r1'])) {
                    $data_updt_r1 = [
                        'mostrar_total_entradas_hoy' => isset($post['mostrar_total_entradas_hoy_r1']) && $post['mostrar_total_entradas_hoy_r1'] == 1 ? true : false,
                        'mostrar_entradas_segmentadas_hoy' => isset($post['mostrar_entradas_segmentadas_hoy_r1']) &&  $post['mostrar_entradas_segmentadas_hoy_r1'] == 1 ? true : false,
                        'mostrar_estadisticas_dia_anterior' => isset($post['mostrar_estadisticas_dia_anterior_r1']) &&  $post['mostrar_estadisticas_dia_anterior_r1'] == 1 ? true : false,
                        'mostrar_estadisticas_consolidadas_mes' => isset($post['mostrar_estadisticas_consolidadas_mes_r1']) &&  $post['mostrar_estadisticas_consolidadas_mes_r1'] == 1 ? true : false,
                        'mostrar_estadisticas_consolidadas_anio' => isset($post['mostrar_estadisticas_consolidadas_anio_r1']) &&  $post['mostrar_estadisticas_consolidadas_anio_r1'] == 1 ? true : false,
                        'mostrar_estadisticas_comparativas_mes_actual' => isset($post['mostrar_estadisticas_comparativas_mes_actual_r1']) &&  $post['mostrar_estadisticas_comparativas_mes_actual_r1'] == 1 ? true : false,
                        'mostrar_estadisticas_comparativas_mes_anterior' => isset($post['mostrar_estadisticas_comparativas_mes_anterior_r1']) &&  $post['mostrar_estadisticas_comparativas_mes_anterior_r1'] == 1 ? true : false,
                        'created_at' => GetTimeStamps(),
                        'estado' => isset($post['acceso_r1']) && $post['acceso_r1'] == 1 ? true : false,
                        'mall_id' => $idmall,
                        'url_region' => isset($post['acceso_r1_nombre']) ? getUrl($post['acceso_r1_nombre']) : NULL,
                    ];
                    $rsp_v_r1 = InsertRow('view_region_r1', $data_updt_r1);
                }
            }
            if (!empty($r2_option)) {
                $data_updt_r2 = [
                    'mostrar_total_entradas_hoy' => isset($post['mostrar_total_entradas_hoy_r2']) && $post['mostrar_total_entradas_hoy_r2'] == 1 ? true : false,
                    'mostrar_entradas_segmentadas_hoy' => isset($post['mostrar_entradas_segmentadas_hoy_r2']) &&  $post['mostrar_entradas_segmentadas_hoy_r2'] == 1 ? true : false,
                    'mostrar_estadisticas_dia_anterior' => isset($post['mostrar_estadisticas_dia_anterior_r2']) &&  $post['mostrar_estadisticas_dia_anterior_r2'] == 1 ? true : false,
                    'mostrar_estadisticas_consolidadas_mes' => isset($post['mostrar_estadisticas_consolidadas_mes_r2']) &&  $post['mostrar_estadisticas_consolidadas_mes_r2'] == 1 ? true : false,
                    'mostrar_estadisticas_consolidadas_anio' => isset($post['mostrar_estadisticas_consolidadas_anio_r2']) &&  $post['mostrar_estadisticas_consolidadas_anio_r2'] == 1 ? true : false,
                    'mostrar_estadisticas_comparativas_mes_actual' => isset($post['mostrar_estadisticas_comparativas_mes_actual_r2']) &&  $post['mostrar_estadisticas_comparativas_mes_actual_r2'] == 1 ? true : false,
                    'mostrar_estadisticas_comparativas_mes_anterior' => isset($post['mostrar_estadisticas_comparativas_mes_anterior_r2']) &&  $post['mostrar_estadisticas_comparativas_mes_anterior_r2'] == 1 ? true : false,
                    'updated_at' => GetTimeStamps(),
                    'estado' => isset($post['acceso_r2']) && $post['acceso_r2'] == 1 ? true : false,

                ];
                $rsp_v_r2 = UpdateRow('view_region_r2', $data_updt_r2, $r2_option->id);
            } else {
                if (isset($post['acceso_r2'])) {
                    $data_updt_r2 = [
                        'mostrar_total_entradas_hoy' => isset($post['mostrar_total_entradas_hoy_r2']) && $post['mostrar_total_entradas_hoy_r2'] == 1 ? true : false,
                        'mostrar_entradas_segmentadas_hoy' => isset($post['mostrar_entradas_segmentadas_hoy_r2']) &&  $post['mostrar_entradas_segmentadas_hoy_r2'] == 1 ? true : false,
                        'mostrar_estadisticas_dia_anterior' => isset($post['mostrar_estadisticas_dia_anterior_r2']) &&  $post['mostrar_estadisticas_dia_anterior_r2'] == 1 ? true : false,
                        'mostrar_estadisticas_consolidadas_mes' => isset($post['mostrar_estadisticas_consolidadas_mes_r2']) &&  $post['mostrar_estadisticas_consolidadas_mes_r2'] == 1 ? true : false,
                        'mostrar_estadisticas_consolidadas_anio' => isset($post['mostrar_estadisticas_consolidadas_anio_r2']) &&  $post['mostrar_estadisticas_consolidadas_anio_r2'] == 1 ? true : false,
                        'mostrar_estadisticas_comparativas_mes_actual' => isset($post['mostrar_estadisticas_comparativas_mes_actual_r2']) &&  $post['mostrar_estadisticas_comparativas_mes_actual_r2'] == 1 ? true : false,
                        'mostrar_estadisticas_comparativas_mes_anterior' => isset($post['mostrar_estadisticas_comparativas_mes_anterior_r2']) &&  $post['mostrar_estadisticas_comparativas_mes_anterior_r2'] == 1 ? true : false,
                        'created_at' => GetTimeStamps(),
                        'estado' => isset($post['acceso_r2']) && $post['acceso_r2'] == 1 ? true : false,
                        'mall_id' => $idmall,
                        'url_region' => isset($post['acceso_r2_nombre']) ? getUrl($post['acceso_r2_nombre']) : NULL,
                    ];
                    $rsp_v_r2 = InsertRow('view_region_r2', $data_updt_r2);
                }
            }
            if (!empty($r3_option)) {
                $data_updt_r3 = [
                    'mostrar_total_entradas_hoy' => isset($post['mostrar_total_entradas_hoy_r3']) && $post['mostrar_total_entradas_hoy_r3'] == 1 ? true : false,
                    'mostrar_entradas_segmentadas_hoy' => isset($post['mostrar_entradas_segmentadas_hoy_r3']) &&  $post['mostrar_entradas_segmentadas_hoy_r3'] == 1 ? true : false,
                    'mostrar_estadisticas_dia_anterior' => isset($post['mostrar_estadisticas_dia_anterior_r3']) &&  $post['mostrar_estadisticas_dia_anterior_r3'] == 1 ? true : false,
                    'mostrar_estadisticas_consolidadas_mes' => isset($post['mostrar_estadisticas_consolidadas_mes_r3']) &&  $post['mostrar_estadisticas_consolidadas_mes_r3'] == 1 ? true : false,
                    'mostrar_estadisticas_consolidadas_anio' => isset($post['mostrar_estadisticas_consolidadas_anio_r3']) &&  $post['mostrar_estadisticas_consolidadas_anio_r3'] == 1 ? true : false,
                    'mostrar_estadisticas_comparativas_mes_actual' => isset($post['mostrar_estadisticas_comparativas_mes_actual_r3']) &&  $post['mostrar_estadisticas_comparativas_mes_actual_r3'] == 1 ? true : false,
                    'mostrar_estadisticas_comparativas_mes_anterior' => isset($post['mostrar_estadisticas_comparativas_mes_anterior_r3']) &&  $post['mostrar_estadisticas_comparativas_mes_anterior_r3'] == 1 ? true : false,
                    'updated_at' => GetTimeStamps(),
                    'estado' => isset($post['acceso_r3']) && $post['acceso_r3'] == 1 ? true : false,
                ];
                $rsp_v_r3 = UpdateRow('view_region_r3', $data_updt_r3, $r3_option->id);
            } else {
                if (isset($post['acceso_r3'])) {

                    $data_updt_r3 = [
                        'mostrar_total_entradas_hoy' => isset($post['mostrar_total_entradas_hoy_r3']) && $post['mostrar_total_entradas_hoy_r3'] == 1 ? true : false,
                        'mostrar_entradas_segmentadas_hoy' => isset($post['mostrar_entradas_segmentadas_hoy_r3']) &&  $post['mostrar_entradas_segmentadas_hoy_r3'] == 1 ? true : false,
                        'mostrar_estadisticas_dia_anterior' => isset($post['mostrar_estadisticas_dia_anterior_r3']) &&  $post['mostrar_estadisticas_dia_anterior_r3'] == 1 ? true : false,
                        'mostrar_estadisticas_consolidadas_mes' => isset($post['mostrar_estadisticas_consolidadas_mes_r3']) &&  $post['mostrar_estadisticas_consolidadas_mes_r3'] == 1 ? true : false,
                        'mostrar_estadisticas_consolidadas_anio' => isset($post['mostrar_estadisticas_consolidadas_anio_r3']) &&  $post['mostrar_estadisticas_consolidadas_anio_r3'] == 1 ? true : false,
                        'mostrar_estadisticas_comparativas_mes_actual' => isset($post['mostrar_estadisticas_comparativas_mes_actual_r3']) &&  $post['mostrar_estadisticas_comparativas_mes_actual_r3'] == 1 ? true : false,
                        'mostrar_estadisticas_comparativas_mes_anterior' => isset($post['mostrar_estadisticas_comparativas_mes_anterior_r3']) &&  $post['mostrar_estadisticas_comparativas_mes_anterior_r3'] == 1 ? true : false,
                        'estado' => isset($post['acceso_r3']) && $post['acceso_r3'] == 1 ? true : false,
                        'mall_id' => $idmall,
                        'created_at' => GetTimeStamps(),
                        'url_region' => isset($post['acceso_r3_nombre']) ? getUrl($post['acceso_r3_nombre']) : NULL,
                    ];

                    $rsp_v_r3 = InsertRow('view_region_r3', $data_updt_r3);
                }
            }
            $data_rvehicle = [
                // 'mostrar_flujo_personas' => isset($post['mostrar_flujo_personas_rvehicle']) && $post['mostrar_flujo_personas_rvehicle'] == 1 ? true : false,
                // 'mostrar_total_entradas' => isset($post['mostrar_total_entradas_rvehicle']) && $post['mostrar_total_entradas_rvehicle'] == 1 ? true : false,
                // 'mostrar_estadia_promedio' => isset($post['mostrar_estadia_promedio_rvehicle']) && $post['mostrar_estadia_promedio_rvehicle'] == 1 ? true : false,
                // // 'mostrar_entradas_segmentadas_hoy' => isset($post['mostrar_entradas_segmentadas_hoy_rvehicle']) && $post['mostrar_entradas_segmentadas_hoy_rvehicle'] == 1 ? true : false,
                // 'mostrar_estadisticas_dia_anterior' => isset($post['mostrar_estadisticas_dia_anterior_rvehicle']) && $post['mostrar_estadisticas_dia_anterior_rvehicle'] == 1 ? true : false,
                // 'mostrar_estadisticas_consolidadas_mes' => isset($post['mostrar_estadisticas_consolidadas_mes_rvehicle']) && $post['mostrar_estadisticas_consolidadas_mes_rvehicle'] == 1 ? true : false,
                // 'mostrar_estadisticas_consolidadas_anio' => isset($post['mostrar_estadisticas_consolidadas_anio_rvehicle']) && $post['mostrar_estadisticas_consolidadas_anio_rvehicle'] == 1 ? true : false,
                // 'mostrar_estadisticas_comparativas_mes_actual' => isset($post['mostrar_estadisticas_comparativas_mes_actual_rvehicle']) && $post['mostrar_estadisticas_comparativas_mes_actual_rvehicle'] == 1 ? true : false,
                // 'mostrar_estadisticas_comparativas_mes_anterior' => isset($post['mostrar_estadisticas_comparativas_mes_anterior_rvehicle']) && $post['mostrar_estadisticas_comparativas_mes_anterior_rvehicle'] == 1 ? true : false,
            ];
            if (!empty($rvehicle_option)) {
                if ($post['acceso_vehicle']) {
                    $data_rvehicle['updated_at'] = GetTimeStamps();
                }
                $rsp_v_vehicle = UpdateRow('view_vehicle', $data_rvehicle, $rvehicle_option->id);
            } else {
                $data_rvehicle['mall_id'] = $idmall;
                $data_rvehicle['estado'] = true;
                $data_rvehicle['created_at'] = GetTimeStamps();
                $rsp_v_vehicle = InsertRow('view_vehicle', $data_rvehicle);
            }
            // pre_die($post);
            $camaras = isset($post['camaras']) ? $post['camaras'] : [];
            if (!empty($camaras)) {
                foreach ($camaras as $camara) {
                    // pre_die($camara);
                    $marketing_id = $camara['marketing_id'];
                    $nombre_camara = $camara['nombre_camara'];
                    $id_camara = $camara['id_camara'];
                    if (!empty($marketing_id) && !empty($nombre_camara)) {
                        $cam = GetRowByWhere('view_marketing', ['estado' => true, 'eliminado' => false, 'id' => $id_camara]);

                        $new_camera = [
                            'entrada_marketing_id' => $marketing_id,
                            'titulo_entrada' => $nombre_camara,
                            'estado' => true,
                            'eliminado' => false,
                        ];
                        if (!empty($cam)) {
                            $new_camera['updated_at'] = GetTimeStamps();
                            UpdateRow('view_marketing', $new_camera, $id_camara);
                        } else {
                            $new_camera['mall_id'] = $idmall;
                            $new_camera['created_at'] = GetTimeStamps();
                            InsertRow('view_marketing', $new_camera);
                        }
                    }
                }
            }
            // pre_die($mall);

            // Insertar nuevo mall
            if ($mall > 0) {
                // Éxito al registrar el nuevo Mall
                session()->flash('success', ['success' => 'Se ha registrado con éxito el nuevo Mall', 'success_title' => 'Gestión de Malls']);
                return redirect('malls/listado');
            } else {
                // Error al registrar el Mall
                session()->flash('error', ['error' => 'Mall no registrado, inténtelo nuevamente por favor', 'error_title' => 'Gestión de Malls']);
                return redirect('malls/editar/' . $idmall)->withInput($post);
            }
        }

        // $data = $conexion->query('select * from nombre_camaras;')->fetchAll();
        // $nombres_camaras

        $camaras = QueryBuilder('view_marketing', ['estado' => true, 'mall_id' => $idmall, 'eliminado' => false]);
        // pre_die($camaras);

        $js_content = [
            0 => 'layouts.js.GeneralJS',
            1 => 'malls.js.MallsEditJS'
        ];
        $valida_reload = true;
        $nav_mantenedor_malls = true;
        $nav_listado_malls = true;
        return view('malls.malls_editar_view', compact(
            'nav_mantenedor_malls',
            'nav_listado_malls',
            'valida_reload',
            'js_content',
            'camaras',
            'r0_option',
            'r1_option',
            'r2_option',
            'r3_option',
            'rvehicle_option',
            'idmall',
            'mall',
        ));
    }

    public function EliminarMall(Request $request)
    {
        $post = $request->all();
        if (!empty($post)) {
            $post = $post['data'];
            $mall = GetRowByWhere('malls', ['id' => $post['mall_id'], 'deleted' => false]);
            if (!empty($mall)) {
                $rsp = UpdateRow('malls', ['deleted' => true, 'estado' => false, 'updated_at' => GetTimeStamps(), 'deleted_at' => GetTimeStamps()], $post['mall_id']);
                if ($rsp > 0) {
                    $rsp  = [
                        'tipo' => 'success',
                        'title' => 'Gestión de Malls',
                        'msg' => 'Mall eliminado con éxito.',
                    ];
                    http_response_code(200);
                } else {
                    $rsp  = [
                        'tipo' => 'warning',
                        'title' => 'Gestión de Malls',
                        'msg' => 'Mall no modificado, recarga la página e intenta nuevamente.',
                    ];
                    http_response_code(404);
                }
            } else {
                $rsp = [
                    'tipo' => 'error',
                    'title' => 'Gestión de Malls',
                    'msg' => 'Mall no existe o fue eliminado.',
                ];
                http_response_code(404); // Código de estado HTTP: 200 OK
            }
        } else {
            $rsp = [
                'tipo' => 'error',
                'title' => 'Gestión de Malls',
                'msg' => 'Datos no recibidos por el servidor',
            ];
            http_response_code(400); // Código de estado HTTP: 200 OK

        }

        header('Content-Type: application/json');
        echo json_encode($rsp);
        exit;
    }

    private function ValidateFields($data)
    {
        $error = [];
        $error_flag = false;


        if (!empty($data['nombre'])) {
            if (validateText(trim($data['nombre']))) {
                $error_flag = true;
                $error['nombre'] = 'Nombre';
            }
        } else {
            $error_flag = true;
            $error['nombre'] = 'Nombre';
        }

        if (!empty($data['acceso_r1_nombre'])) {
            if (validateText(trim($data['acceso_r1_nombre']))) {
                $error_flag = true;
                $error['acceso_r1_nombre'] = 'Acceso R1 Nombre';
            }
        }

        if (!empty($data['acceso_r2_nombre'])) {
            if (validateText(trim($data['acceso_r2_nombre']))) {
                $error_flag = true;
                $error['acceso_r2_nombre'] = 'Acceso R2 Nombre';
            }
        }

        if (!empty($data['acceso_r3_nombre'])) {
            if (validateText(trim($data['acceso_r3_nombre']))) {
                $error_flag = true;
                $error['acceso_r3_nombre'] = 'Acceso R3 Nombre';
            }
        }
        if (!empty($data['distribucion_id'])) {
            if ($data['distribucion_id'] <= 0) {
                $error_flag = true;
                $error['distribucion_id'] = 'Distribución Mall';
            }
        } else {
            $error_flag = true;
            $error['distribucion_id'] = 'Distribución Mall';
        }

        if ($error_flag) {
            return $error;
        } else {
            return false;
        }
    }

    private function validarYGuardarImagen($imagen)
    {
        // Verificar si se ha cargado una imagen
        if (!$imagen || $imagen->getError() != 0) {
            return false;
        }

        // Verificar el formato de la imagen
        $formatosPermitidos = ['image/jpeg', 'image/png', 'image/gif'];
        if (!in_array($imagen->getMimeType(), $formatosPermitidos)) {
            return false;
        }

        // Generar un nombre único para la imagen con la extensión original
        $nombreArchivo = uniqid('logo_') . '.' . $imagen->getClientOriginalExtension();

        // Mover la imagen al directorio de destino

        $rutaDestino = "img/malls/logos/";
        /*if (!file_exists(asset($rutaDestino))) {
            mkdir($rutaDestino, 0755, true);
        }*/
        //$imagen->move($rutaDestino, $nombreArchivo);
        $rsp = [
            'ruta_destino' => $rutaDestino,
            'nombre_archivo' => $nombreArchivo
        ];
        return $rsp;
    }

    public function validarBaseDatos(Request $request, $omite = false)
    {
        try {
            $post = $request->all();
            $requiredFields = ['host', 'port', 'user', 'name', 'password'];
            // pre_die($post);
            if (!$omite && isset($post['data'])) {
                $post = $post['data'];
            }

            foreach ($requiredFields as $field) {
                if (!isset($post[$field]) || empty($post[$field])) {
                    return response()->json(['error' => 'Falta el campo ' . $field], 400);
                }
            }

            $data = [
                'driver' => 'mysql',
                'host' => trim($post['host']),
                'port' => trim($post['port']),
                'database' => trim($post['name']),
                'username' => trim($post['user']),
                'password' => trim($post['password']),
            ];

            $nombre_camaras = GetDataApi('obtener-nombre-camaras', '', '', 'POST', ($data));
            // pre_die("nombre_camaras");
            if (!empty($nombre_camaras)) {
                $nombre_camaras = $nombre_camaras->camaras;
                return response()->json(['tipo' => 'success', 'msg' => 'Conexión a Base de Datos establecida con éxito.', 'data' => $nombre_camaras ?: []]);
            } else {
                return response()->json(['tipo' => 'error', 'msg' => 'Error al conectar a la base de datos: ' . $nombre_camaras], 500);
            }
        } catch (\PDOException $e) {
            return response()->json(['tipo' => 'error', 'msg' => 'Error al conectar a la base de datos: ' . $e->getMessage()], 500);
        } catch (\Throwable $e) {
            return response()->json(['tipo' => 'error', 'msg' => 'Error inesperado: ' . $e->getMessage()], 500);
        }
    }
}
