<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class ExteriorModel extends Model
{
    protected $connection = 'mysql_1'; // Establece la conexión directamente como un string
    protected $table = 'dashboard_process';


    public function __construct()
    {
        configureDatabaseConnection();
    }

    public function mesAnterior()
    {
        $date = Carbon::now()->locale('es');
        $mesAnteriorNumero = $date->subMonth(1)->translatedFormat('m');
        return $mesAnteriorNumero;
    }

    // Define relaciones u otras propiedades aquí
    function setTable($tableName)
    {
        $this->table = $tableName;
        return $this;
    }

    public function dHoy()
    {
        $this->setTable('total_personas_dia');
        $data = $this->selectRaw('totalenternum Entradas, totalexitnum Salidas, aforo as Aforo, ocupacion Porcentaje, 45000 - aforo as Restante')
            ->where('id', '=', '2')
            ->first();
        return ($data);
    }

    public function dAyer()
    {
        $this->setTable('personas_dia_ant_r2');
        return $this->select('totalenternum')
            ->get();
    }

    public function dAyerGrafico()
    {
        $this->setTable('personas_segmento_dia_ant_r2');
        $data = $this->selectRaw('totalenternum as Entradas, aforo, segmento')
            ->get();
        return json_decode($data);
    }

    public function dHoyGrafico()
    {
        $this->setTable('personas_segmento_dia_r2');
        return $this->selectRaw('totalenternum Entrada, aforo as Aforo, segmento')
            ->get();
    }

    public function uActualizacion()
    {
        $this->setTable('dashboard_process');
        return $this->selectRaw('time_format(timeupdate, "%H:%i") as tiempo')
            ->where('id', 1)
            ->first();
    }

    public function datosAnuales()
    {
        $this->setTable('total_personas_mes_r2');
        return $this->selectRaw('id, totalentradas tEntradas, 
            concat(mes," - ",year) as mes')
            ->where('totalentradas', '!=', 0)
            ->get();
    }

    public function comparativoMesActualExterior()
    {
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
            ->whereRaw('MONTH(date) = MONTH(CURDATE()) AND YEAR(date) = YEAR(CURDATE())')
            ->get();
        //pre_die(json_decode($data));

        return json_decode($data);
    }

    public function comparativoMesAnteriorExterior()
    {
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
            ->whereRaw('MONTH(date) = MONTH(DATE_SUB(CURDATE(), INTERVAL 1 MONTH)) AND YEAR(date) = YEAR(CURDATE())')
            ->get();
        return json_decode($data);
    }




    public function semanaPasada()
    {
        $this->setTable('semana_r1_historic');
        return $this->selectRaw('dia as dia, max as maximo, promedio as promedio, totalenternum')
            ->get();
    }

    public function aforoActual()
    {
        $this->setTable('total_personas_dia');
        return $this->selectRaw('totalenternum Entrada, totalexitnum Salida, aforo as Aforo, ocupacion Porcentaje')
            ->where('id', '=', '1')
            ->get();
    }



    public function camaraSectorAnterior()
    {
        $this->setTable('entradas_camara_dia_ant_r2');

        return $this->selectRaw('cameraindexcode camara, totalenternum tEntrada, nombre, date')
            ->orderBy('totalenternum', 'DESC')
            ->where('id', '!=', 13)
            ->get();
    }


    public function datosMensuales()
    {
        $this->setTable('datos_estadisticos_dia_r2');
        return $this->selectRaw('totalenternum tEntrada,
        date_format(date, "%d-%m") date')
            ->whereRaw('date_format(date, "%m-%y") like date_format(curdate(), "%m-%y") and totalenternum != 0')
            ->orderBy('date', 'asc')
            ->get();
    }

    public function dHoyGraficoCamaras()
    {
        $this->setTable('entradas_camara_dia_r2');
        $data = $this->selectRaw('concat(ucase(left(nombre,1)),lower(substring(nombre,2))) as Nombre, totalenternum')
            ->orderBy('totalenternum', 'desc')
            ->where('id', '!=', 13)
            ->get();
        return json_decode($data);
    }



    public function comparativoDiaLunes()
    {
        $mesActualNumero = $this->mesActual();

        $this->setTable('datos_estadisticos_dia_r1');

        return $this->selectRaw('totalenternum as entrada, 
                case
                    when dayname(date) = "Monday" then "Lunes"
                end as dia, date_format(date, "%d/%m/%Y") as date')
            ->whereRaw('dayname(date) = "Monday" and date_format(date, "%m") = ' . $mesActualNumero . '')
            ->get();
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

        $this->setTable('datos_estadisticos_dia_r1');

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
