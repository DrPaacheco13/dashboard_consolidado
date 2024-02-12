<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;

class AlarmasController extends Controller
{
    public function __construct(Request $request)
    {
        $this->middleware('RedirectRoutes');
    }

    public function ingresar_persona(Request $request)
    {

        $idmall = auth()->user()->id_mall;

        $post = $request->all();

        if (!empty($post)) {
            // pre_die($post);

            $ruta_destino = NULL;
            $nombre_archivo = NULL;
            $validateImg = [];
            if (!empty($post['img_persona'])) {
                if (!$validateImg = $this->validarYGuardarImagen($post['img_persona'], $idmall, 'lista-negra')) {
                    session()->flash('error', ['error' => 'Seleccione una imagen válida para continuar por favor.', 'error_title' => 'Gestión de Alarmas']);
                    return redirect('malls/listado');
                }
                $ruta_destino = $validateImg['ruta_destino'];
                $nombre_archivo = $validateImg['nombre_archivo'];
                $post['img_persona']->move($ruta_destino, $nombre_archivo);
                $data_mall['img_persona'] = $ruta_destino . $nombre_archivo;
            }

            $new_person = [
                'nombre' => !empty($post) ? $post['nombre'] : NULL,
                'fecha_ingreso' => !empty($post) ? $post['fecha_ingreso'] : NULL,
                'img_persona' => $ruta_destino,
                'nombre_archivo' => $nombre_archivo,
                'mall_id' => $idmall,
                'created_at' => GetTimeStamps(),
            ];

            $rsp = InsertRow('personas_alarma', $new_person);

            if ($rsp > 0) {
                return redirect('/');
            } else {
                return redirect('alarmas/ingresar_persona');
            }
        }


        // $js_content = [
        //     0 => ''
        // ];
        $valida_reload = true;

        $lista_negra = QueryBuilder('personas_alarma', ['estado' => true, 'deleted' => false]);

        $seccion_flujo = 'Lista Negra';
        return view('alarmas.buscar_persona_view', compact(
            'valida_reload',
            'idmall',
            'seccion_flujo',
            'lista_negra',
        ));
    }
    private function validarYGuardarImagen($imagen, $mall_id, $carpeta)
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

        // Definir la ruta de destino específica para el mall_id
        $rutaDestino = "img/malls/$mall_id/$carpeta/";

        // Verificar si la carpeta de destino existe, si no existe, crearla
        if (!file_exists($rutaDestino)) {
            mkdir($rutaDestino, 0755, true);
        }

        // Mover la imagen al directorio de destino
        $imagen->move($rutaDestino, $nombreArchivo);

        // Retornar la ruta de destino y el nombre del archivo
        return [
            'ruta_destino' => $rutaDestino,
            'nombre_archivo' => $nombreArchivo
        ];
    }

    public function AnalyzePersona(Request $request)
    {

        $file = $request->file('file');
        $mall_id = auth()->user()->id_mall;
        $datos = $this->validarYGuardarImagen($file, $mall_id, GetDateTodayCL());
        $ruta = public_path($datos['ruta_destino'] . $datos['nombre_archivo']);
        // pre_die($ruta);
        // Guardar el archivo en una carpeta temporal
        // $ruta_temporal = $file->store('temp', 'temp');
        try {
            $rsp  = ApiAP($ruta);
            pre_die($rsp);
        } catch (Exception $ex) {
            pre_die($ex->getMessage());
        }
    }
}
