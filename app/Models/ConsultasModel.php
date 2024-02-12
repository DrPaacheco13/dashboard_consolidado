<?php

namespace App\Models;

use Carbon\Carbon;
use FTP\Connection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ConsultasModel extends Model
{
    protected $connection = 'mysql_1'; // Establece la conexión directamente como un string
    protected $table = 'dashboard_process';

    public function __construct($data = null)
    {
        if (empty($data)) {
            configureDatabaseConnection();
        } else {
            configureDatabaseConnection($data);
        }
    }

    function setTable($tableName)
    {
        $this->table = $tableName;
        return $this;
    }

    public function GetAllData()
    {
        $this->setTable('vehiculos_detalle');
        $data = $this->select('id', 'patente')->get();
        return json_decode($data);
    }
    public function mesActual()
    {
        $date = Carbon::now()->locale('es');
        $mesActualNumero = $date->translatedFormat('m');
        return $mesActualNumero;
    }
    public function mesAnterior()
    {
        $date = Carbon::now()->locale('es');
        $mesAnteriorNumero = $date->subMonth(1)->translatedFormat('m');
        return $mesAnteriorNumero;
    }

    public function semanaPasada()
    {
        $this->setTable('semana_r1_historic');
        return $this->selectRaw('dia as dia, max as maximo, promedio as promedio')
            ->get();
    }

    public function aforoActual()
    {
        $this->setTable('total_personas_dia');
        $data = $this->selectRaw('totalenternum Entrada, totalexitnum Salida, aforo as Aforo, ocupacion Porcentaje, time as actualizacion')
            ->where('id', '=', '1')
            ->first();
        return json_decode($data);
    }
    public function aforoActualPatio()
    {
        $this->setTable('total_personas_dia');
        return $this->selectRaw('totalenternum Entrada, totalexitnum Salida, aforo as Aforo, ocupacion Porcentaje')
            ->where('id', '=', '2')
            ->get();
    }

    public function fechaSemanaPasada2()
    {
        $this->setTable('semana_r1_historic');
        return $this->selectRaw('date_format(date, "%d-%m-%Y") Fecha2')
            ->where('id', '=', '7')
            ->get();
    }

    public function fechaSemanaPasada1()
    {
        $this->setTable('semana_r1_historic');
        return $this->selectRaw('date_format(date, "%d-%m-%Y") Fecha1')
            ->where('id', '=', '1')
            ->get();
    }

    public function camaraPrueba()
    {
        $this->setTable('entradas_camara_dia_ant_r1');
        return $this->selectRaw('cameraindexcode camara, totalenternum tEntrada, nombre, date')
            ->get();
    }

    public function anioTotal()
    {
        $this->setTable('total_personas_mes_r1');
        return $this->selectRaw('totalentradas tEntradas')
            ->get();
    }

    public function graficoAnual()
    {
        $this->setTable('total_personas_mes_r1');
        return $this->selectRaw('totalentradas tEntradas, mes')
            ->get();
    }

    public function uActualizacion()
    {
        $this->setTable('dashboard_process');
        $data = $this->selectRaw('time_format(timeupdate, "%H:%i") as tiempo')
            ->where('id', 1)
            ->get();
        return json_decode($data);
    }

    public function dHoyGrafico()
    {
        $this->setTable('personas_segmento_dia_r1');
        $data = $this->selectRaw('totalenternum Entrada, aforo as Aforo, segmento')
            ->get();
        return json_decode($data);
    }
    public function dHoyGraficoPatio()
    {
        $this->setTable('personas_segmento_dia_r2');
        $data = $this->selectRaw('totalenternum Entrada, aforo as Aforo, segmento')
            ->get();
        return json_decode($data);
    }

    public function getAforoActual()
    {
        $this->setTable('total_personas_dia');
        $data = $this->selectRaw('totalenternum Entradas')
            ->where('id', 2)
            ->get();
        return json_decode($data);
    }

    public function getAforoHoy()
    {
        $this->setTable('total_personas_dia');
        $data = $this->selectRaw('totalenternum Entradas')
            ->where('id', 1)
            ->get();
        return json_decode($data);
    }
    public function getAforoHoyPatio()
    {
        $this->setTable('total_personas_dia');
        $data = $this->selectRaw('totalenternum Entradas')
            ->where('id', 2)
            ->get();
        return json_decode($data);
    }
    public function dAyer()
    {
        $this->setTable('personas_dia_ant_r1');
        $data = $this->select('totalenternum')
            ->get();
        return json_decode($data);
    }
    public function dAyerPatio()
    {
        $this->setTable('personas_dia_ant_r2');
        $data = $this->select('totalenternum')
            ->get();
        return json_decode($data);
    }

    public function dAyerGrafico()
    {
        $this->setTable('personas_segmento_dia_ant_r1');
        return $this->selectRaw('totalenternum as Entradas, aforo, segmento')
            ->get();
    }
    public function dAyerGraficoPatio()
    {
        $this->setTable('personas_segmento_dia_ant_r2');
        return $this->selectRaw('totalenternum as Entradas, aforo, segmento')
            ->get();
    }

    public function datosAnuales()
    {
        $this->setTable('total_personas_mes_r1');
        return $this->selectRaw('id, totalentradas tEntradas, 
        concat(mes," - ",year) as mes')
            ->where('mes', '!=', 'October')
            ->get();
    }
    public function datosAnualesPatio()
    {
        $this->setTable('total_personas_mes_r2');
        return $this->selectRaw('id, totalentradas tEntradas, 
        concat(mes," - ",year) as mes')
            ->where('mes', '!=', 'October')
            ->get();
    }

    public function datosMensuales()
    {
        $this->setTable('datos_estadisticos_dia_r1');
        $num = '';
        $idmall = auth()->user()->id_mall;
        if ($idmall != 5 && $idmall != 6) {
            $num = 'totalenternum';
        } else {
            $num = 'totalenter';
        }

        return $this->selectRaw($num . ' tEntrada,
        date_format(date, "%d-%m") date')
            ->whereRaw('MONTH(date) = MONTH(curdate()) AND YEAR(date) = YEAR(curdate())')
            ->orderBy('date', 'asc')
            ->get();
    }
    public function datosMensualesPatio()
    {
        $this->setTable('datos_estadisticos_dia_r2');
        return $this->selectRaw('totalenternum tEntrada,
        date_format(date, "%d-%m") date')
            ->whereRaw('MONTH(date) = MONTH(curdate()) AND YEAR(date) = YEAR(curdate())')
            ->orderBy('date', 'asc')
            ->get();
    }

    public function camaraSectorAnterior()
    {
        $this->setTable('entradas_camara_dia_ant_r1');
        $data = $this->selectRaw('cameraindexcode camara, totalenternum tEntrada, nombre, date')
            ->orderBy('totalenternum', 'DESC')
            ->get();
        return json_decode($data);
    }
    public function camaraSectorAnteriorPatio()
    {
        $this->setTable('entradas_camara_dia_ant_r2');

        return $this->selectRaw('cameraindexcode camara, totalenternum tEntrada, nombre, date')
            ->orderBy('totalenternum', 'DESC')
            ->get();
    }
    public function comparativoMesActual()
    {
        $mesActualNumero = $this->mesActual();
        $this->setTable('datos_estadisticos_dia_r1');
        $num = '';
        $idmall = auth()->user()->id_mall;
        //pre_die($idmall);
        if ($idmall != 5 && $idmall != 6) {
            $num = 'totalenternum';
        } else {
            $num = 'totalenter';
        }
        $data = $this->selectRaw($num . ' as entrada, 
        CASE
            WHEN DAYNAME(date) = "Monday" THEN "Lunes"
            WHEN DAYNAME(date) = "Tuesday" THEN "Martes"
            WHEN DAYNAME(date) = "Wednesday" THEN "Miercoles"
            WHEN DAYNAME(date) = "Thursday" THEN "Jueves"
            WHEN DAYNAME(date) = "Friday" THEN "Viernes"
            WHEN DAYNAME(date) = "Saturday" THEN "Sabado"
            WHEN DAYNAME(date) = "Sunday" THEN "Domingo"
        END as dia, DATE_FORMAT(date, "%d/%m/%Y") as date')
            ->whereRaw('MONTH(date) = ? AND YEAR(date) = YEAR(CURDATE())')
            ->addBinding($mesActualNumero, 'select')
            ->get();
        //pre_die(json_decode($data));

        return json_decode($data);
    }

    public function comparativoMesAnterior()
    {
        $mesActualNumero = $this->mesAnterior();
        $this->setTable('datos_estadisticos_dia_r1');
        $num = '';
        $idmall = auth()->user()->id_mall;
        if ($idmall != 5 && $idmall != 6) {
            $num = 'totalenternum';
        } else {
            $num = 'totalenter';
        }
        $data = $this->selectRaw($num . ' as entrada, 
        CASE
            WHEN DAYNAME(date) = "Monday" THEN "Lunes"
            WHEN DAYNAME(date) = "Tuesday" THEN "Martes"
            WHEN DAYNAME(date) = "Wednesday" THEN "Miercoles"
            WHEN DAYNAME(date) = "Thursday" THEN "Jueves"
            WHEN DAYNAME(date) = "Friday" THEN "Viernes"
            WHEN DAYNAME(date) = "Saturday" THEN "Sabado"
            WHEN DAYNAME(date) = "Sunday" THEN "Domingo"
        END as dia, DATE_FORMAT(date, "%d/%m/%Y") as date')
            ->whereRaw('MONTH(date) = ? AND YEAR(date) = YEAR(CURDATE())')
            ->addBinding($mesActualNumero, 'select')
            ->get();
        //pre_die(json_decode($data));

        return json_decode($data);
    }
    public function comparativoMesActualPatio()
    {
        $mesActualNumero = $this->mesActual();
        $this->setTable('datos_estadisticos_dia_r2');
        $data = $this->selectRaw('totalenternum as entrada, 
        CASE
            WHEN DAYNAME(date) = "Monday" THEN "Lunes"
            WHEN DAYNAME(date) = "Tuesday" THEN "Martes"
            WHEN DAYNAME(date) = "Wednesday" THEN "Miercoles"
            WHEN DAYNAME(date) = "Thursday" THEN "Jueves"
            WHEN DAYNAME(date) = "Friday" THEN "Viernes"
            WHEN DAYNAME(date) = "Saturday" THEN "Sabado"
            WHEN DAYNAME(date) = "Sunday" THEN "Domingo"
        END as dia, DATE_FORMAT(date, "%d/%m/%Y") as date')
            ->whereRaw('MONTH(date) = ? AND YEAR(date) = YEAR(CURDATE())')
            ->addBinding($mesActualNumero, 'select')
            ->get();
        //pre_die(json_decode($data));

        return json_decode($data);
    }
    public function comparativoMesAnteriorPatio()
    {
        $mesActualNumero = $this->mesAnterior();
        $this->setTable('datos_estadisticos_dia_r2');
        $data = $this->selectRaw('totalenternum as entrada, 
        CASE
            WHEN DAYNAME(date) = "Monday" THEN "Lunes"
            WHEN DAYNAME(date) = "Tuesday" THEN "Martes"
            WHEN DAYNAME(date) = "Wednesday" THEN "Miercoles"
            WHEN DAYNAME(date) = "Thursday" THEN "Jueves"
            WHEN DAYNAME(date) = "Friday" THEN "Viernes"
            WHEN DAYNAME(date) = "Saturday" THEN "Sabado"
            WHEN DAYNAME(date) = "Sunday" THEN "Domingo"
        END as dia, DATE_FORMAT(date, "%d/%m/%Y") as date')
            ->whereRaw('MONTH(date) = ? AND YEAR(date) = YEAR(CURDATE())')
            ->addBinding($mesActualNumero, 'select')
            ->get();
        //pre_die(json_decode($data));
        return json_decode($data);
    }

    public function comparativoDiaLunes()
    {
        $mesActualNumero = $this->mesActual();

        $this->setTable('datos_estadisticos_dia_r1');
        $data = $this->selectRaw('totalenternum as entrada, 
        case
            when dayname(date) = "Monday" then "Lunes"
        end as dia, date_format(date, "%d/%m/%Y") as date')
            ->whereRaw('dayname(date) = "Monday" and date_format(date, "%m") = ' . $mesActualNumero . '')
            ->get();
        return json_decode($data);
    }

    public function comparativoDiaMartes()
    {
        $mesActualNumero = $this->mesActual();

        $this->setTable('datos_estadisticos_dia_r1');

        return $this->selectRaw('totalenternum as entrada, 
                case
                    when dayname(date) = "Tuesday" then "Martes"
                end as dia, date_format(date, "%d/%m/%Y") as date')
            ->whereRaw('dayname(date) = "Tuesday" and date_format(date, "%m") = ' . $mesActualNumero . '')
            ->get();
    }
    public function comparativoDiaMiercoles()
    {
        $mesActualNumero = $this->mesActual();

        $this->setTable('datos_estadisticos_dia_r1');

        return $this->selectRaw('totalenternum as entrada, 
                case
                    when dayname(date) = "Wednesday" then "Miércoles"
                end as dia, date_format(date, "%d/%m/%Y") as date')
            ->whereRaw('dayname(date) = "Wednesday" and date_format(date, "%m") = ' . $mesActualNumero . '')
            ->get();
    }
    public function comparativoDiaJueves()
    {
        $mesActualNumero = $this->mesActual();

        $this->setTable('datos_estadisticos_dia_r2');

        return $this->selectRaw('totalenternum as entrada, 
                case
                    when dayname(date) = "Thursday" then "Jueves"
                end as dia, date_format(date, "%d/%m/%Y") as date')
            ->whereRaw('dayname(date) = "Thursday" and date_format(date, "%m") = ' . $mesActualNumero . '')
            ->get();
    }
    public function comparativoDiaViernes()
    {
        $mesActualNumero = $this->mesActual();

        $this->setTable('datos_estadisticos_dia_r1');

        return $this->selectRaw('totalenternum as entrada, 
                case
                    when dayname(date) = "Friday" then "Viernes"
                end as dia, date_format(date, "%d/%m/%Y") as date')
            ->whereRaw('dayname(date) = "Friday" and date_format(date, "%m") = ' . $mesActualNumero . '')
            ->get();
    }
    public function comparativoDiaSabado()
    {
        $mesActualNumero = $this->mesActual();

        $this->setTable('datos_estadisticos_dia_r1');

        return $this->selectRaw('totalenternum as entrada, 
                case
                    when dayname(date) = "Saturday" then "Sábado"
                end as dia, date_format(date, "%d/%m/%Y") as date')
            ->whereRaw('dayname(date) = "Saturday" and date_format(date, "%m") = ' . $mesActualNumero . '')
            ->get();
    }
    public function comparativoDiaDomingo()
    {
        $mesActualNumero = $this->mesActual();

        $this->setTable('datos_estadisticos_dia_r1');

        return $this->selectRaw('totalenternum as entrada, 
                case
                    when dayname(date) = "Sunday" then "Domingo"
                end as dia, date_format(date, "%d/%m/%Y") as date')
            ->whereRaw('dayname(date) = "Sunday" and date_format(date, "%m") = ' . $mesActualNumero . '')
            ->get();
    }

    public function comparativoDiaLunesAnt()
    {
        $mesAnteriorNumero = $this->mesAnterior();

        $this->setTable('datos_estadisticos_dia_r1');

        return $this->selectRaw('totalenternum as entrada, 
                case
                    when dayname(date) = "Monday" then "Lunes"
                end as dia, date_format(date, "%d/%m/%Y") as date')
            ->whereRaw('dayname(date) = "Monday" and date_format(date, "%m") = ' . $mesAnteriorNumero . '')
            ->get();
    }

    public function comparativoDiaMartesAnt()
    {
        $mesAnteriorNumero = $this->mesAnterior();

        $this->setTable('datos_estadisticos_dia_r1');

        return $this->selectRaw('totalenternum as entrada, 
                case
                    when dayname(date) = "Tuesday" then "Martes"
                end as dia, date_format(date, "%d/%m/%Y") as date')
            ->whereRaw('dayname(date) = "Tuesday" and date_format(date, "%m") = ' . $mesAnteriorNumero . '')
            ->get();
    }
    public function comparativoDiaMiercolesAnt()
    {
        $mesAnteriorNumero = $this->mesAnterior();

        $this->setTable('datos_estadisticos_dia_r1');

        return $this->selectRaw('totalenternum as entrada, 
                case
                    when dayname(date) = "Wednesday" then "Miércoles"
                end as dia, date_format(date, "%d/%m/%Y") as date')
            ->whereRaw('dayname(date) = "Wednesday" and date_format(date, "%m") = ' . $mesAnteriorNumero . '')
            ->get();
    }
    public function comparativoDiaJuevesAnt()
    {
        $mesAnteriorNumero = $this->mesAnterior();

        $this->setTable('datos_estadisticos_dia_r1');

        return $this->selectRaw('totalenternum as entrada, 
                case
                    when dayname(date) = "Thursday" then "Jueves"
                end as dia, date_format(date, "%d/%m/%Y") as date')
            ->whereRaw('dayname(date) = "Thursday" and date_format(date, "%m") = ' . $mesAnteriorNumero . '')
            ->get();
    }
    public function comparativoDiaViernesAnt()
    {
        $mesAnteriorNumero = $this->mesAnterior();

        $this->setTable('datos_estadisticos_dia_r1');

        return $this->selectRaw('totalenternum as entrada, 
                case
                    when dayname(date) = "Friday" then "Viernes"
                end as dia, date_format(date, "%d/%m/%Y") as date')
            ->whereRaw('dayname(date) = "Friday" and date_format(date, "%m") = ' . $mesAnteriorNumero . '')
            ->get();
    }
    public function comparativoDiaSabadoAnt()
    {
        $mesAnteriorNumero = $this->mesAnterior();

        $this->setTable('datos_estadisticos_dia_r1');

        return $this->selectRaw('totalenternum as entrada, 
                case
                    when dayname(date) = "Saturday" then "Sábado"
                end as dia, date_format(date, "%d/%m/%Y") as date')
            ->whereRaw('dayname(date) = "Saturday" and date_format(date, "%m") = ' . $mesAnteriorNumero . '')
            ->get();
    }
    public function comparativoDiaDomingoAnt()
    {
        $mesAnteriorNumero = $this->mesAnterior();

        $this->setTable('datos_estadisticos_dia_r1');

        return $this->selectRaw('totalenternum as entrada, 
                case
                    when dayname(date) = "Sunday" then "Domingo"
                end as dia, date_format(date, "%d/%m/%Y") as date')
            ->whereRaw('dayname(date) = "Sunday" and date_format(date, "%m") = ' . $mesAnteriorNumero . '')
            ->get();
    }

    public function getTipoCamara()
    {
        $this->setTable('camera_status');
        return $this->selectRaw('count(*) as cantidad_tipo, tipo')
            ->groupBy('tipo')
            ->get();
    }

    public function GetCamaraStatus()
    {
        $this->setTable('camera_status');
        return $this->select('*')->get();
    }
}
