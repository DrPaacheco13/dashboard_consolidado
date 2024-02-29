<?php

namespace App\Http\Controllers;

set_time_limit(0);

use App\Exports\DiaExcel;
use App\Exports\SegmentoExcel;
use App\Models\PDFModel;
use Carbon\Carbon;
use Illuminate\Http\Request;

class buscarFechaController extends Controller
{
    public function __construct(Request $request)
    {
        $this->middleware('RedirectRoutes');
    }
    public function index(Request $request)
    {
        $post = $request->all();
        $idmall = auth()->user()->id_mall;
        $fecha_inicial = NULL;
        $fecha_final = NULL;
        $opcion = NULL;
        $region = NULL;
        $Consulta = new PDFModel();

        // pre_die(auth()->user());
        // pre_die($idmall);
        $graficoPorDia = [];
        $graficoPorCamara = [];

        $datos = [];
        $datos_segmentados = [];

        $session_data = $request->session()->get('data_fecha');
        $crear_session = true;
        $mall = GetRowByWhere('malls', ['id' => $idmall]);
        // pre_die($mall);

        if (!empty($post)) {
            $fecha_inicial = trim($post['fecha_inicial']);
            $fecha_final = trim($post['fecha_final']);
            $opcion = $post['opcion'];
            $region = !empty($post['region']) ? $post['region'] : '';



            if ($region == 1) {
                $data_r1 = GetDataApi("pdf-r1", $idmall, "$fecha_inicial/$fecha_final");
                $graficoPorDia = !empty($data_r1->pdf_grafico_x_dia_r1) ? $data_r1->pdf_grafico_x_dia_r1 : [];
                $datos = !empty($data_r1->pdf_datos_r1) ? $data_r1->pdf_datos_r1[0] : [];
                $datos_segmentados = !empty($data_r1->pdf_segmentos_entrada_r1) ? $data_r1->pdf_segmentos_entrada_r1[0] : [];
                $graficoPorCamara = !empty($data_r1->pdf_grafico_x_camara_r1) ? $data_r1->pdf_grafico_x_camara_r1 : [];
            }
            if ($region == 2) {
                $data_r2 = GetDataApi("pdf-r2", $idmall, "$fecha_inicial/$fecha_final");
                $graficoPorDia = !empty($data_r2->pdf_grafico_x_dia_r2) ? $data_r2->pdf_grafico_x_dia_r2 : [];
                $datos = !empty($data_r2->pdf_datos_r2) ? $data_r2->pdf_datos_r2[0] : [];
                $datos_segmentados = !empty($data_r2->pdf_segmentos_entrada_r2) ? $data_r2->pdf_segmentos_entrada_r2[0] : [];
                $graficoPorCamara = !empty($data_r2->pdf_grafico_x_camara_r2) ? $data_r2->pdf_grafico_x_camara_r2 : [];
            }
            if ($region == 3) {
                $data_r3 = GetDataApi("pdf-r3", $idmall, "$fecha_inicial/$fecha_final");
                $graficoPorDia = !empty($data_r3->pdf_grafico_x_dia_r3) ? $data_r3->pdf_grafico_x_dia_r3 : [];
                $datos = !empty($data_r3->pdf_datos_r3) ? $data_r3->pdf_datos_r3[0] : [];
                $datos_segmentados = !empty($data_r3->pdf_segmentos_entrada_r3) ? $data_r3->pdf_segmentos_entrada_r3[0] : [];
                $graficoPorCamara = !empty($data_r3->pdf_grafico_x_camara_r3) ? $data_r3->pdf_grafico_x_camara_r3 : [];
            }
            // pre_die($graficoPorCamara); 
            // if (!empty($datos_segmentados)) {
            //     $datos_segmentados = $datos_segmentados[0];
            // }
            // if (!empty($datos)) {
            //     $datos = $datos[0];
            // }
            // pre($region);
            // pre_die($datos_segmentados);
            $data_fecha = [
                'fecha_inicial' => $fecha_inicial,
                'fecha_final' => $fecha_final,
                'tipo_filtro' => $opcion,
                'region' => $region,
                'datos_segmentados' => $datos_segmentados,
            ];
            if ($crear_session) {
                $request->session()->put('data_fecha', $data_fecha);
            }
        }
        //pre_die($graficoPorCamara);
        $js_content = [
            0 => 'layouts.js.GeneralJS',
            1 => 'layouts.buscar.js.BuscarJS',
        ];

        $seccion_flujo = 'FLUJO DE DATOS';
        $nombre_mall = !empty($mall->nombre) ? StrUpper($mall->nombre) : '';
        $acceso_mall = 'BUSQUEDA POR FECHAS';

        $valida_reload = true;
        $nav_buscar_fechas = true;
        // pre_die($datos_segmentados);
        return view('layouts.buscar.buscar', compact(
            'nav_buscar_fechas',
            'seccion_flujo',
            'nombre_mall',
            'acceso_mall',
            'valida_reload',
            'valida_reload',
            'js_content',
            'graficoPorCamara',
            'idmall',
            'mall',
            'opcion',
            'region',
            'graficoPorDia',
            'datos',
            'fecha_inicial',
            'fecha_final',
            'datos_segmentados',
        ));
    }

    public function LimpiarFiltrosSearch(Request $request)
    {
        $session_data = $request->session()->get('data_fecha');
        if (!empty($session_data)) {
            $request->session()->put('data_fecha', []);
        }
        return redirect(route('searchDate'));
    }

    public function pdf(Request $request)
    {
        $fecha_inicial = NULL;
        $fecha_final = NULL;
        $region = NULL;
        $opcion = NULL;

        $graficoPorCamara = [];
        $graficoPorDia = [];
        $datos = [];


        $idmall = auth()->user()->id_mall;

        $datos_segmentados = [];
        // $Consulta = new PDFModel();

        $endDate = Carbon::now()->translatedFormat('d-m-Y');


        $data_fecha = $request->session()->get('data_fecha');
        $fecha_inicial = !empty($data_fecha['fecha_inicial']) ? $data_fecha['fecha_inicial'] : '';
        $fecha_final = !empty($data_fecha['fecha_final']) ? $data_fecha['fecha_final'] : '';
        $seleccion = !empty($data_fecha['region']) ? $data_fecha['region'] : '';

        $newDate = date("d-m-Y", strtotime($fecha_inicial));
        $newDate2 = date("d-m-Y", strtotime($fecha_final));
        $mall = GetRowByWhere('malls', ['id' => $idmall, 'estado' => true]);
        $data_r2 = [];
        // pre_die($seleccion);
        if ($seleccion == 1) {
            $data_r1 = GetDataApi("pdf-r1", $idmall, "$fecha_inicial/$fecha_final");
            $graficoPorDia = !empty($data_r1->pdf_grafico_x_dia_r1) ? $data_r1->pdf_grafico_x_dia_r1 : [];
            $datos = !empty($data_r1->pdf_datos_r1) ? $data_r1->pdf_datos_r1[0] : [];
            $datos_segmentados = !empty($data_r1->pdf_segmentos_entrada_r1) ? $data_r1->pdf_segmentos_entrada_r1[0] : [];
            $graficoPorCamara = !empty($data_r1->pdf_grafico_x_camara_r1) ? $data_r1->pdf_grafico_x_camara_r1 : [];
        }
        if ($seleccion == 2) {
            $data_r2 = GetDataApi("pdf-r2", $idmall, "$fecha_inicial/$fecha_final");
            $graficoPorDia = !empty($data_r2->pdf_grafico_x_dia_r2) ? $data_r2->pdf_grafico_x_dia_r2 : [];
            $datos = !empty($data_r2->pdf_datos_r2) ? $data_r2->pdf_datos_r2[0] : [];
            $datos_segmentados = !empty($data_r2->pdf_segmentos_entrada_r2) ? $data_r2->pdf_segmentos_entrada_r2[0] : [];
            $graficoPorCamara = !empty($data_r2->pdf_grafico_x_camara_r2) ? $data_r2->pdf_grafico_x_camara_r2 : [];
        }
        if ($seleccion == 3) {
            $data_r3 = GetDataApi("pdf-r3", $idmall, "$fecha_inicial/$fecha_final");
            $graficoPorDia = !empty($data_r3->pdf_grafico_x_dia_r3) ? $data_r3->pdf_grafico_x_dia_r3 : [];
            $datos = !empty($data_r3->pdf_datos_r3) ? $data_r3->pdf_datos_r3[0] : [];
            $datos_segmentados = !empty($data_r3->pdf_segmentos_entrada_r3) ? $data_r3->pdf_segmentos_entrada_r3[0] : [];
            $graficoPorCamara = !empty($data_r3->pdf_grafico_x_camara_r3) ? $data_r3->pdf_grafico_x_camara_r3 : [];
        }

        unset($datos_segmentados->Tipo);

        $nombreMall = !empty($mall) ? $mall->nombre : 'Sin Información';
        $logo_mall = !empty($mall) ? $mall->logo : 'Sin Información';
        $pdf = \PDF::loadView('layouts.buscar.pdf', compact('seleccion', 'newDate', 'newDate2', 'graficoPorDia', 'graficoPorCamara', 'endDate', 'nombreMall', 'idmall', 'logo_mall'), [
            'idmall' => $idmall,
            'datos' => $datos,
            'fecha' => $fecha_inicial,
            'fecha2' => $fecha_final,
            'opcion' => $opcion,
            'datos_segmentados' => !empty($datos_segmentados) ? $datos_segmentados : []
        ]);

        // pre_die($seleccion);
        // pre_die($pdf);
        ini_set('memory_limit', '-1');


        return $pdf->stream("$nombreMall " . $endDate . '.pdf');
    }

    public function export(Request $request)
    {
        $data_fecha = $request->session()->get('data_fecha');
        $fecha = !empty($data_fecha['fecha_inicial']) ? $data_fecha['fecha_inicial'] : '';
        $fecha2 = !empty($data_fecha['fecha_final']) ? $data_fecha['fecha_final'] : '';
        $seleccion = !empty($data_fecha['region']) ? $data_fecha['region'] : '';
        $opcion = !empty($data_fecha['tipo_filtro']) ? $data_fecha['tipo_filtro'] : '';
        $idmall = auth()->user()->id_mall;
        // pre_die(auth()->user()->mall);
        $mall = GetRowByWhere('malls', ['id' => $idmall, 'estado' => true]);
        $nombre_acceso = '';
        if ($seleccion == 1) {
            $nombre_acceso = !empty($mall->acceso_r1_nombre) ? $mall->acceso_r1_nombre : 'Acceso';
        } elseif ($seleccion == 2) {
            $nombre_acceso = !empty($mall->acceso_r2_nombre) ? $mall->acceso_r2_nombre : 'Acceso';
        } elseif ($seleccion == 3) {
            $nombre_acceso = !empty($mall->acceso_r3_nombre) ? $mall->acceso_r3_nombre : 'Acceso';
        } else {
            $seleccion = 1;
            $nombre_acceso = 'Acceso_General';
        }
        switch ($opcion) {
            case 1:
                return (new DiaExcel($fecha, $fecha2, $seleccion))->download('Dias_' . $nombre_acceso . '.xlsx');
                break;
            case 2:
                return (new SegmentoExcel($fecha, $fecha2, $seleccion, $idmall))->download('Segmentos_' . $nombre_acceso . '.xlsx');
                break;
        }
        //return (new SegmentoExportR2FDSANFERNANDO($fecha, $fecha2, $seleccion))->download('Dias_Patio_Comida.xlsx');
        //return (new SegmentoExportR2SANFERNANDO($fecha, $fecha2, $seleccion))->download('Segmentos_Patio_Comida.xlsx');
    }
}
