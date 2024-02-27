<?php

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

function GetSegmentoNumero($segmento_key)
{
    $segmento_return = null;
    switch ($segmento_key) {
        case 'sum_08':
            $segmento_return = '08';
            break;
        case 'sum_09':
            $segmento_return = '09';
            break;
        case 'sum_10':
            $segmento_return = '10';
            break;
        case 'sum_11':
            $segmento_return = '11';
            break;
        case 'sum_12':
            $segmento_return = '12';
            break;
        case 'sum_13':
            $segmento_return = '13';
            break;
        case 'sum_14':
            $segmento_return = '14';
            break;
        case 'sum_15':
            $segmento_return = '15';
            break;
        case 'sum_16':
            $segmento_return = '16';
            break;
        case 'sum_17':
            $segmento_return = '17';
            break;
        case 'sum_18':
            $segmento_return = '18';
            break;
        case 'sum_19':
            $segmento_return = '19';
            break;
        case 'sum_20':
            $segmento_return = '20';
            break;
        case 'sum_21':
            $segmento_return = '21';
            break;
        case 'sum_22':
            $segmento_return = '22';
            break;
        case 'sum_23':
            $segmento_return = '23';
            break;
        default:
            $segmento_return = '00';
            break;
    }
    return $segmento_return;
}

function GetYesterdayText()
{
    $dateAnt = Carbon::yesterday()->locale('es');
    $fechaMarketingAnt = $dateAnt->translatedFormat('l j F Y');
    return StrUpper($fechaMarketingAnt);
}
function StrUpper($texto)
{
    $mapeo = [
        'á' => 'A',
        'é' => 'E',
        'í' => 'I',
        'ó' => 'O',
        'ú' => 'U',
        'Á' => 'A',
        'É' => 'E',
        'Í' => 'I',
        'Ó' => 'O',
        'Ú' => 'U',
    ];

    // Convierte las vocales con tildes en mayúsculas y elimina las tildes
    $texto = strtr($texto, $mapeo);

    // Convierte el resto del texto a mayúsculas
    $texto = strtoupper($texto);

    return $texto;
}


function pre($data)
{
    echo '<pre>';
    print_r($data);
    echo '</pre>';
}
function pre_die($data)
{
    echo '<pre>';
    print_r($data);
    echo '</pre>';
    die();
}
function GetTimeStamps()
{
    return date('Y-m-d H:i:s');
}

function GetDateToday()
{
    $fechaHoy = date('Y-m-d');
    return $fechaHoy;
}
function GetDateTodayCL()
{
    $fechaHoy = date('d-m-Y');
    return $fechaHoy;
}

function QueryBuilder($table, $where = [], $select = null)
{
    if (empty($table) || empty($where)) {
        return 'Parámetros no válidos';
    }
    $data = DB::table($table)->where($where)->get();
    if ($data->isNotEmpty()) {
        return json_decode($data);
    } else {
        return FALSE;
    }
}
function GetRowByWhere($table, $where = [], $select = null)
{
    if (empty($table) || empty($where)) {
        return 'Parámetros no válidos';
    }
    $data = DB::table($table)->where($where)->first();
    if (!empty($data)) {
        return $data;
    } else {
        return FALSE;
    }
}
function getMallsRegiones($idmall)
{
    $mall = DB::table('malls as m')
        ->select('m.*', 'r1.url_region as url_region_r1', 'r0.url_region as url_region_r0', 'r2.url_region as url_region_r2', 'r3.url_region as url_region_r3')
        ->leftJoin('view_region_r0 as r0', 'r0.mall_id', '=', 'm.id')
        ->leftJoin('view_region_r1 as r1', 'r1.mall_id', '=', 'm.id')
        ->leftJoin('view_region_r2 as r2', 'r2.mall_id', '=', 'm.id')
        ->leftJoin('view_region_r3 as r3', 'r3.mall_id', '=', 'm.id')
        ->where('m.id', $idmall)
        ->first();
    return $mall ?? false;
}


function InsertRow($table, $data)
{
    if (empty($table) || empty($data)) {
        return 'Parámetros no válidos';
    }

    $inserted = DB::table($table)->insert($data);

    return $inserted;
}
function UpdateRow($table, $data, $id)
{
    if (empty($table) || empty($data) || !is_numeric($id)) {
        return '';
    }

    $inserted = DB::table($table)->where('id', $id)->update($data);

    return $inserted;
}

function formatear_miles($numero)
{
    if (!empty($numero)) {
        $pesos = '' . number_format($numero, 0, ',', '.');
    } else {
        $pesos = 0;
    }
    return $pesos;
}
function formatear_miles_coma($numero)
{
    if (!empty($numero)) {
        $pesos = '' . number_format($numero, 2, ',', '.');
    } else {
        $pesos = 0;
    }
    return $pesos;
}
function ordenar_fechaHumano($date)
{
    $explode = explode(" ", $date);
    $fecha = implode('-', array_reverse(explode('-', $explode[0])));
    return $fecha;
}

function validateText($text)
{
    if ((strlen($text) < 2) || !is_string($text)) {
        return true;
    } else {
        return false;
    }
}

function configureDatabaseConnection($data = null)
{
    if (empty($data)) {
        $id_mall = auth()->user()->id_mall;
        $databaseInfo = GetRowByWhere('databases', ['mall_id' => $id_mall]);
    } else {
        $databaseInfo = $data;
    }
    // Configura la conexión a la segunda base de datos MySQL
    config(['database.connections.mysql_1' => [
        'driver' => 'mysql',
        'host' => $databaseInfo->db_host,
        'port' => $databaseInfo->db_port,
        'database' => $databaseInfo->db_name,
        'username' => $databaseInfo->db_user,
        'password' => $databaseInfo->db_password,
        'charset' => 'utf8mb4',
        'collation' => 'utf8mb4_unicode_ci',
        'prefix' => '',
    ]]);
    // Establece la conexión a la segunda base de datos
    $conne = DB::connection('mysql_1')->reconnect();
    return $conne;
}

function getUrl($str)
{
    $str = strLower(trim($str));

    $str = limpiarStr($str);
    $str = preg_replace('([^A-Za-z0-9])', '-', $str);
    return $str;
}
function strLower($str)
{
    $str = strtolower(trim($str));
    $str = str_replace('Á', 'á', $str);
    $str = str_replace('É', 'é', $str);
    $str = str_replace('Í', 'í', $str);
    $str = str_replace('Ó', 'ó', $str);
    $str = str_replace('Ú', 'ú', $str);
    $str = str_replace('Ñ', 'ñ', $str);
    return $str;
}
function limpiarStr($str)
{
    $str = trim($str);
    $str = str_replace('á', 'a', $str);
    $str = str_replace('é', 'e', $str);
    $str = str_replace('í', 'i', $str);
    $str = str_replace('ó', 'o', $str);
    $str = str_replace('ú', 'u', $str);
    $str = str_replace('ñ', 'n', $str);
    return $str;
}
function mesAnterior()
{
    $date = Carbon::now()->locale('es');
    $mesAnteriorNumero = $date->subMonth(1)->translatedFormat('m');
    return $mesAnteriorNumero;
}
function mesActual()
{
    $date = Carbon::now()->locale('es');
    $mesActualNumero = $date->translatedFormat('m');
    return $mesActualNumero;
}
function mesAnteriorTexto()
{
    $date = Carbon::now()->locale('es');
    $mesAnteriorNumero = $date->subMonth(1)->translatedFormat('m');
    return traerTextoMes($mesAnteriorNumero);
}
function mesActualTexto()
{
    $date = Carbon::now()->locale('es');
    $mesActualNumero = $date->translatedFormat('m');
    return traerTextoMes($mesActualNumero);
}
function traerTextoMes($mes)
{
    $return = '';
    $meses = array(
        1 => "Enero", 2 => "Febrero", 3 => "Marzo", 4 => "Abril", 5 => "Mayo", 6 => "Junio",
        7 => "Julio", 8 => "Agosto", 9 => "Septiembre", 10 => "Octubre", 11 => "Noviembre", 12 => "Diciembre"
    );
    foreach ($meses as $key => $value) {
        if ($key == $mes) {
            $return = $value;
        }
    }
    return $return;
}
function ordenarHoraHumano($hora24)
{
    // Convierte la hora de formato de 24 horas a un objeto DateTime
    $horaObj = DateTime::createFromFormat('H:i:s', $hora24);

    // Formatea la hora en un formato humano sin segundos
    $horaHumano = $horaObj->format('H:i');

    return $horaHumano;
}
function ordenarHoraSegundoHumano($hora24)
{
    // Convierte la hora de formato de 24 horas a un objeto DateTime
    $horaObj = DateTime::createFromFormat('H:i:s', $hora24);

    // Formatea la hora en un formato humano sin segundos
    $horaHumano = $horaObj->format('H:i:s');

    return $horaHumano;
}

function GetDataApi($endpoint = 'getAforoHoyR0', $mall_id = null, $select = null, $method = 'GET', $postData = [])
{
    $response = [];
    $curl = curl_init();
    $url = "http://127.0.0.1:5001/api/$endpoint";
    // $url = "http://34.176.180.19/api/$endpoint";

    if (!empty($mall_id)) {
        $url .= "/$mall_id";
    }
    if (!empty($select)) {
        $url .= "/$select";
    }
    // pre_die($postData);
    $opt = [
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => $method,
    ];
    if ($method == 'POST') {
        $opt[CURLOPT_HTTPHEADER] = array(
            'Content-Type: application/json'
        );
    }
    curl_setopt_array($curl, $opt);

    if ($method === 'POST') {
        curl_setopt($curl, CURLOPT_POSTFIELDS, $postData);
    }

    $response = curl_exec($curl);
    // pre_die($response):;
    curl_close($curl);

    return json_decode($response);
}


function ApiAP($file)
{
    $response = [];
    $curl = curl_init();
    // Si la API está en localhost, cambia la dirección según tu entorno.
    $url = "http://127.0.0.1:5000/analyze";

    curl_setopt_array($curl, array(
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => array('file' => new CURLFILE($file)),
        CURLOPT_HTTPHEADER => array(
            'Content-Type: multipart/form-data' // Cambiado a multipart/form-data
        ),
    ));

    $response = curl_exec($curl);

    // Manejo de errores
    if ($response === false) {
        $response = curl_error($curl);
    }

    curl_close($curl);

    // Verificar si la respuesta es un JSON válido antes de decodificarla.
    $decoded_response = json_decode($response);
    if ($decoded_response === null && json_last_error() !== JSON_ERROR_NONE) {
        $decoded_response = ['error' => 'Invalid JSON response'];
    }

    return $decoded_response;
}


function capitalizarPalabras($texto)
{
    // Convertir todas las letras a minúsculas y dividir el texto en palabras
    // $str = ;
    $palabras = explode(' ', strtolower(str_replace('Ñ', 'ñ', $texto)));

    // Capitalizar la primera letra de cada palabra
    $palabrasCapitalizadas = array_map('ucfirst', $palabras);

    // Unir las palabras capitalizadas de nuevo en un solo texto
    $textoCapitalizado = implode(' ', $palabrasCapitalizadas);

    return $textoCapitalizado;
}

function obtenerMesesDelAnio()
{
    return [
        'Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio',
        'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'
    ];
}
