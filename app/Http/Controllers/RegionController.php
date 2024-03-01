<?php

namespace App\Http\Controllers;

use App\Models\ConsultasModel;
use App\Models\RegionModel;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RegionController extends Controller
{
    public function __construct(Request $request)
    {
        $this->middleware('RedirectRoutes');
    }
    public function AccesoRegionR1($id)
    {
        //pre_die(auth()->user());
        $RegionModel = new RegionModel();

        $date = Carbon::now()->locale('es');
        $fechaHoy = $date->translatedFormat('l j F Y');
        $endDate = Carbon::now()->subDay()->translatedFormat('l j F Y');
        $mesActualGrafico = Carbon::now()->locale('ES')->translatedFormat('F');
        $mesActualNumero = $date->translatedFormat('m');
        $mesActualNumeroANT = $date->subMonth(1)->translatedFormat('m');
        $idmall = auth()->user()->id_mall;

        $region1 = GetDataApi('region1', $idmall);
        // pre_die($region1);
        $aforoHoy = !empty($region1->aforo_hoy_r1) ? $region1->aforo_hoy_r1 : [];
        $aforoAyer = !empty($region1->aforo_ayer_r1) ? $region1->aforo_ayer_r1 : [];
        $personasSegmentoAyer = !empty($region1->personas_segmento_ayer_r1) ? $region1->personas_segmento_ayer_r1 : [];
        $personasSegmentoHoy = !empty($region1->personas_segmento_hoy_r1) ? $region1->personas_segmento_hoy_r1 : [];
        $timeActualizacion = !empty($region1->time_actualizacion) ? $region1->time_actualizacion : [];
        $entradasCamaraAyer = !empty($region1->entradas_camara_ayer_r1) ? $region1->entradas_camara_ayer_r1 : [];
        $datosAnuales = !empty($region1->datos_anuales_r1) ? $region1->datos_anuales_r1 : [];
        $datosAnualesAnt = !empty($region1->datos_anuales_ant_r1) ? $region1->datos_anuales_ant_r1 : [];
        $datosMensuales = !empty($region1->datos_mensuales_r1) ? $region1->datos_mensuales_r1 : [];
        $datosMensualesAnt = !empty($region1->datos_mensuales_ant_r1) ? $region1->datos_mensuales_ant_r1 : [];

        $comparativoMesActual = !empty($region1->comparativo_mes_actual_r1) ? $region1->comparativo_mes_actual_r1 : [];
        $comparativoMesAnterior = !empty($region1->comparativo_mes_anterior_r1) ? $region1->comparativo_mes_anterior_r1 : [];
        $js_content = [
            '0' => 'layouts/js/GeneralJS',
            '1' => 'layouts/regiones/js/RegionR1JS',
        ];

        $mall = GetRowByWhere('malls', ['id' => $idmall]);
        $logo_mall = !empty($mall->imagen) ? $mall->imagen : '';
        $nombre_mall = !empty($mall->nombre) ? StrUpper($mall->nombre) : '';
        $acceso_mall = !empty($mall->acceso_r1_nombre) ? $mall->acceso_r1_nombre : '';
        $nav_acceso_r1 = true;

        $datosAnioAnt = [];
        $meses = obtenerMesesDelAnio();
        // pre_die($region1);
        if (!empty($datosAnualesAnt)) {
            # code...
            foreach ($meses as $mes) {
                $encontrado = false; // Bandera para verificar si se encontró el mes
                foreach ($datosAnualesAnt as $dato) {
                    if (StrUpper($mes) == StrUpper($dato->mes)) {
                        $datosAnioAnt[] = $dato;
                        $encontrado = true;
                        break; // Terminar el bucle una vez que se haya encontrado el mes
                    }
                }
                if (!$encontrado) {
                    $datosAnioAnt[] = []; // Si no se encontró el mes, agregar un array vacío
                }
            }
        }
        $datosAnualesAnt = $datosAnioAnt;
        // pre_die($datosAnioAnt);


        // pre_die($datosMensualesAnt);

        return view('layouts.regiones.region_r1_view', compact(
            'nav_acceso_r1',
            'js_content',
            'logo_mall',
            'nombre_mall',
            'acceso_mall',
            'aforoHoy', //'dHoy',
            'aforoAyer', //'dAyer',
            'personasSegmentoAyer', //'dAyerGrafico',
            'personasSegmentoHoy', //'dHoyGrafico',
            'fechaHoy',
            'idmall',
            'timeActualizacion', //'uActualizacion',
            'endDate',
            'entradasCamaraAyer', //'camaraSectorAnterior',
            'datosAnuales',
            'datosAnualesAnt',
            'datosMensuales',
            'datosMensualesAnt',
            'comparativoMesActual',
            'comparativoMesAnterior',
        ));
    }
    public function AccesoRegionR2($id)
    {
        $RegionModel = new RegionModel();

        $date = Carbon::now()->locale('es');
        $fechaHoy = $date->translatedFormat('l j F Y');
        $endDate = Carbon::now()->subDay()->translatedFormat('l j F Y');
        $mesActualGrafico = Carbon::now()->locale('ES')->translatedFormat('F');
        $mesActualNumero = $date->translatedFormat('m');
        $mesActualNumeroANT = $date->subMonth(1)->translatedFormat('m');
        $idmall = auth()->user()->id_mall;

        $region2 = GetDataApi('region2', $idmall);

        $aforoHoy = !empty($region2->aforo_hoy_r2) ? $region2->aforo_hoy_r2 : [];
        $aforoAyer = !empty($region2->aforo_ayer_r2) ? $region2->aforo_ayer_r2 : [];
        $personasSegmentoAyer = !empty($region2->personas_segmento_ayer_r2) ? $region2->personas_segmento_ayer_r2 : [];
        $personasSegmentoHoy = !empty($region2->personas_segmento_hoy_r2) ? $region2->personas_segmento_hoy_r2 : [];
        $timeActualizacion = !empty($region2->time_actualizacion) ? $region2->time_actualizacion : [];
        if ($idmall == 4) {
            $entradasCamaraHoy = !empty($region2->entradas_camara_hoy_r2) ? $region2->entradas_camara_hoy_r2 : [];
        }
        $entradasCamaraAyer = !empty($region2->entradas_camara_ayer_r2) ? $region2->entradas_camara_ayer_r2 : [];
        $datosAnuales = !empty($region2->datos_anuales_r2) ? $region2->datos_anuales_r2 : [];
        $datosAnualesAnt = !empty($region2->datos_anuales_ant_r2) ? $region2->datos_anuales_ant_r2 : [];
        $datosMensuales = !empty($region2->datos_mensuales_r2) ? $region2->datos_mensuales_r2 : [];
        $datosMensualesAnt = !empty($region2->datos_mensuales_ant_r2) ? $region2->datos_mensuales_ant_r2 : [];
        $comparativoMesActual = !empty($region2->comparativo_mes_actual_r2) ? $region2->comparativo_mes_actual_r2 : [];
        $comparativoMesAnterior = !empty($region2->comparativo_mes_anterior_r2) ? $region2->comparativo_mes_anterior_r2 : [];
        // pre_die($entradasCamaraHoy);

        $mall = GetRowByWhere('malls', ['id' => $idmall]);
        $logo_mall = !empty($mall->imagen) ? $mall->imagen : '';
        $nombre_mall = !empty($mall->nombre) ? $mall->nombre : '';
        $acceso_mall = !empty($mall->acceso_r2_nombre) ? $mall->acceso_r2_nombre : '';
        $nav_acceso_r2 = true;
        // pre_die($entradasCamaraHoy);

        $datosAnioAnt = [];
        $meses = obtenerMesesDelAnio();

        foreach ($meses as $mes) {
            $encontrado = false; // Bandera para verificar si se encontró el mes
            foreach ($datosAnualesAnt as $dato) {
                if (StrUpper($mes) == StrUpper($dato->mes)) {
                    $datosAnioAnt[] = $dato;
                    $encontrado = true;
                    break; // Terminar el bucle una vez que se haya encontrado el mes
                }
            }
            if (!$encontrado) {
                $datosAnioAnt[] = []; // Si no se encontró el mes, agregar un array vacío
            }
        }
        $datosAnualesAnt = $datosAnioAnt;
        // pre_die($datosMensualesAnt);
        $data = [
            'nav_acceso_r2' => $nav_acceso_r2,
            'logo_mall' => $logo_mall,
            'nombre_mall' => $nombre_mall,
            'acceso_mall' => $acceso_mall,
            'fechaHoy' => $fechaHoy,
            'idmall' => $idmall,
            'endDate' => $endDate,
            'aforoHoy' => !empty($aforoHoy) ? $aforoHoy : [],
            'aforoAyer' => !empty($aforoAyer) ? $aforoAyer : [],
            'personasSegmentoAyer' => !empty($personasSegmentoAyer) ? $personasSegmentoAyer : [],
            'personasSegmentoHoy' => !empty($personasSegmentoHoy) ? $personasSegmentoHoy : [],
            'timeActualizacion' => !empty($timeActualizacion) ? $timeActualizacion : [],
            'entradasCamaraHoy' => !empty($entradasCamaraHoy) ? $entradasCamaraHoy : [],
            'entradasCamaraAyer' => !empty($entradasCamaraAyer) ? $entradasCamaraAyer : [],
            'datosAnuales' => !empty($datosAnuales) ? $datosAnuales : [],
            'datosAnualesAnt' => !empty($datosAnualesAnt) ? $datosAnualesAnt : [],
            'datosMensuales' => !empty($datosMensuales) ? $datosMensuales : [],
            'datosMensualesAnt' => !empty($datosMensualesAnt) ? $datosMensualesAnt : [],
            'comparativoMesActual' => !empty($comparativoMesActual) ? $comparativoMesActual : [],
            'comparativoMesAnterior' => !empty($comparativoMesAnterior) ? $comparativoMesAnterior : [],
            'js_content' => [
                '0' => 'layouts/js/GeneralJS',
                '1' => 'layouts/regiones/js/RegionR2JS'
            ]
        ];
        return view('layouts.regiones.region_r2_view', $data);
    }
    public function AccesoRegionR3($id)
    {
        $RegionModel = new RegionModel();

        $date = Carbon::now()->locale('es');
        $fechaHoy = $date->translatedFormat('l j F Y');
        $endDate = Carbon::now()->subDay()->translatedFormat('l j F Y');
        $mesActualGrafico = Carbon::now()->locale('ES')->translatedFormat('F');
        $mesActualNumero = $date->translatedFormat('m');
        $mesActualNumeroANT = $date->subMonth(1)->translatedFormat('m');
        $idmall = auth()->user()->id_mall;

        $region3 = GetDataApi('region3', $idmall);
        $aforoHoy = !empty($region3->aforo_hoy_r3) ? $region3->aforo_hoy_r3 : [];
        $aforoAyer = !empty($region3->aforo_ayer_r3) ? $region3->aforo_ayer_r3 : [];
        $personasSegmentoAyer = !empty($region3->personas_segmento_ayer_r3) ? $region3->personas_segmento_ayer_r3 : [];
        $personasSegmentoHoy = !empty($region3->personas_segmento_hoy_r3) ? $region3->personas_segmento_hoy_r3 : [];
        $timeActualizacion = !empty($region3->time_actualizacion) ? $region3->time_actualizacion : [];
        $entradasCamaraAyer = !empty($region3->entradas_camara_ayer_r3) ? $region3->entradas_camara_ayer_r3 : [];
        $datosAnuales = !empty($region3->datos_anuales_r3) ? $region3->datos_anuales_r3 : [];
        $datosAnualesAnt = !empty($region3->datos_anuales_ant_r3) ? $region3->datos_anuales_ant_r3 : [];
        $datosMensuales = !empty($region3->datos_mensuales_r3) ? $region3->datos_mensuales_r3 : [];
        $datosMensualesAnt = isset($region3->datos_mensuales_ant_r3) ? $region3->datos_mensuales_ant_r3 : [];
        $comparativoMesActual = !empty($region3->comparativo_mes_actual_r3) ? $region3->comparativo_mes_actual_r3 : [];
        $comparativoMesAnterior = !empty($region3->comparativo_mes_anterior_r3) ? $region3->comparativo_mes_anterior_r3 : [];
        // pre($comparativoMesAnterior);
        // $datosMensualesAnt = (array)$datosMensualesAnt;

        // pre_die($datosAnualesAnt);
        $js_content = [
            '0' => 'layouts/js/GeneralJS',
            '1' => 'layouts/regiones/js/RegionR3JS',
        ];
        $mall = GetRowByWhere('malls', ['id' => $idmall]);
        $logo_mall = !empty($mall->imagen) ? $mall->imagen : '';
        $nombre_mall = !empty($mall->nombre) ? $mall->nombre : '';
        $acceso_mall = !empty($mall->acceso_r3_nombre) ? $mall->acceso_r3_nombre : '';

        $nav_acceso_r3 = true;

        $datosAnioAnt = [];
        $meses = obtenerMesesDelAnio();

        foreach ($meses as $mes) {
            $encontrado = false; // Bandera para verificar si se encontró el mes
            foreach ($datosAnualesAnt as $dato) {
                if (StrUpper($mes) == StrUpper($dato->mes)) {
                    $datosAnioAnt[] = $dato;
                    $encontrado = true;
                    break; // Terminar el bucle una vez que se haya encontrado el mes
                }
            }
            if (!$encontrado) {
                $datosAnioAnt[] = []; // Si no se encontró el mes, agregar un array vacío
            }
        }
        $datosAnualesAnt = $datosAnioAnt;

        return view('layouts.regiones.region_r3_view', compact(
            'nav_acceso_r3',
            'js_content',
            'logo_mall',
            'nombre_mall',
            'acceso_mall',
            'aforoHoy', //'dHoy',
            'aforoAyer', //'dAyer',
            'personasSegmentoAyer', //'dAyerGrafico',
            'personasSegmentoHoy', //'dHoyGrafico',
            'fechaHoy',
            'idmall',
            'timeActualizacion', //'uActualizacion',
            'endDate',
            'entradasCamaraAyer', //'camaraSectorAnterior',
            'datosAnuales',
            'datosAnualesAnt',
            'datosMensuales',
            'datosMensualesAnt',
            'comparativoMesActual',
            'comparativoMesAnterior',
        ));
    }
    public function AccesoRegionR0($id)
    {
        $user = auth()->user();
        $mall = getMallsRegiones($user->id_mall);
        if ($mall->acceso_r0 == false) {
            return redirect()->route('acceso.r1', ['url' => $mall->url_region_r1]);
        }

        $RegionModel = new RegionModel();

        $date = Carbon::now()->locale('es');
        $fechaHoy = $date->translatedFormat('l j F Y');
        $endDate = Carbon::now()->subDay()->translatedFormat('l j F Y');
        $mesActualGrafico = Carbon::now()->locale('ES')->translatedFormat('F');
        $mesActualNumero = $date->translatedFormat('m');
        $mesActualNumeroANT = $date->subMonth(1)->translatedFormat('m');
        $idmall = auth()->user()->id_mall;


        $region0 = GetDataApi('region0', $idmall);

        $aforoHoy = !empty($region0->aforo_hoy_r0) ? $region0->aforo_hoy_r0 : [];
        $aforoAyer = !empty($region0->aforo_ayer_r0) ? $region0->aforo_ayer_r0 : [];
        $personasSegmentoAyer = !empty($region0->personas_segmento_ayer_r0) ? $region0->personas_segmento_ayer_r0 : [];
        $personasSegmentoHoy = !empty($region0->personas_segmento_hoy_r0) ? $region0->personas_segmento_hoy_r0 : [];
        $timeActualizacion = !empty($region0->time_actualizacion) ? $region0->time_actualizacion : [];
        $entradasCamaraAyer = !empty($region0->entradas_camara_ayer_r0) ? $region0->entradas_camara_ayer_r0 : [];
        $datosAnuales = !empty($region0->datos_anuales_r0) ? $region0->datos_anuales_r0 : [];
        $datosAnualesAnt = !empty($region0->datos_anuales_ant_r0) ? $region0->datos_anuales_ant_r0 : [];
        $datosMensuales = !empty($region0->datos_mensuales_r0) ? $region0->datos_mensuales_r0 : [];
        $datosMensualesAnt = !empty($region0->datos_mensuales_ant_r0) ? $region0->datos_mensuales_ant_r0 : [];
        $comparativoMesActual = !empty($region0->comparativo_mes_actual_r0) ? $region0->comparativo_mes_actual_r0 : [];
        $comparativoMesAnterior = !empty($region0->comparativo_mes_anterior_r0) ? $region0->comparativo_mes_anterior_r0 : [];


        $js_content = [
            '0' => 'layouts/js/GeneralJS',
            '1' => 'layouts/regiones/js/RegionR0JS',
        ];
        $logo_mall = !empty($mall->imagen) ? $mall->imagen : '';
        $nombre_mall = !empty($mall->nombre) ? $mall->nombre : '';
        $acceso_mall = !empty($mall->acceso_r0_nombre) ? $mall->acceso_r0_nombre : '';
        $nav_acceso_r0 = true;

        $datosAnioAnt = [];
        $meses = obtenerMesesDelAnio();

        foreach ($meses as $mes) {
            $encontrado = false; // Bandera para verificar si se encontró el mes
            foreach ($datosAnualesAnt as $dato) {
                if (StrUpper($mes) == StrUpper($dato->mes)) {
                    $datosAnioAnt[] = $dato;
                    $encontrado = true;
                    break; // Terminar el bucle una vez que se haya encontrado el mes
                }
            }
            if (!$encontrado) {
                $datosAnioAnt[] = []; // Si no se encontró el mes, agregar un array vacío
            }
        }
        $datosAnualesAnt = $datosAnioAnt;

        return view('layouts.regiones.region_r0_view', compact(
            'nav_acceso_r0',
            'js_content',
            'logo_mall',
            'nombre_mall',
            'acceso_mall',
            'aforoHoy', //'dHoy',
            'aforoAyer', //'dAyer',
            'personasSegmentoAyer', //'dAyerGrafico',
            'personasSegmentoHoy', //'dHoyGrafico',
            'fechaHoy',
            'idmall',
            'timeActualizacion', //'uActualizacion',
            'endDate',
            'entradasCamaraAyer', //'camaraSectorAnterior',
            'datosAnuales',
            'datosAnualesAnt',
            'datosMensuales',
            'datosMensualesAnt',
            'comparativoMesActual',
            'comparativoMesAnterior',
        ));
    }
}
