<?php

namespace App\Models;

use Carbon\Carbon;
use FTP\Connection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class RegionModel extends Model
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

    // public function timeActualizacion()
    // {
    //     $this->setTable('dashboard_process');
    //     $data = $this->selectRaw('time_format(timeupdate, "%H:%i") as tiempo')
    //         ->where('id', 1)
    //         ->get();
    //     return json_decode($data);
    // }


    private function formatDate($date)
    {
        return date_format(date_create($date), "d/m/Y");
    }

    public function timeActualizacion()
    {
        $this->setTable('dashboard_process');
        $data = $this->selectRaw('time_format(timeupdate, "%H:%i") as tiempo')
            ->where('id', 1)
            ->get();
        return json_decode($data);
    }

    private function getJsonDecodedData($data)
    {
        return json_decode($data);
    }

    public function getAforoHoyR1()
    {
        $this->setTable('total_personas_dia');
        $data = $this->selectRaw('totalenternum Entradas')
            ->where('id', 1)
            ->get();
        return $this->getJsonDecodedData($data);
    }

    public function getAforoAyerR1()
    {
        $this->setTable('personas_dia_ant_r1');
        $data = $this->select('totalenternum')->get();
        return $this->getJsonDecodedData($data);
    }

    public function getPersonasSegmentoAyerR1()
    {
        $this->setTable('personas_segmento_dia_ant_r1');
        return $this->selectRaw('totalenternum as Entradas, aforo, segmento')->get();
    }

    public function getPersonasSegmentoHoyR1()
    {
        $this->setTable('personas_segmento_dia_r1');
        $data = $this->selectRaw('totalenternum Entrada, aforo as Aforo, segmento')->get();
        return $this->getJsonDecodedData($data);
    }

    public function getEntradasCamaraAyerR1()
    {
        $this->setTable('entradas_camara_dia_ant_r1');
        $data = $this->selectRaw('cameraindexcode camara, totalenternum tEntrada, nombre, date')
            ->orderBy('totalenternum', 'DESC')
            ->get();
        return $this->getJsonDecodedData($data);
    }

    public function getDatosAnualesR1()
    {
        $this->setTable('total_personas_mes_r1');
        $fechaActual = now();
        $fechaHace12Meses = $fechaActual->subMonths(13);

        $data = $this->selectRaw('id, totalentradas as tEntradas,
            CONCAT(mes, " - ", year) as mes')
            ->where('year', '>=', $fechaHace12Meses->year)
            ->whereRaw("STR_TO_DATE(CONCAT(CASE 
                        WHEN mes = 'enero' THEN 'January'
                        WHEN mes = 'febrero' THEN 'February'
                        WHEN mes = 'marzo' THEN 'March'
                        WHEN mes = 'abril' THEN 'April'
                        WHEN mes = 'mayo' THEN 'May'
                        WHEN mes = 'junio' THEN 'June'
                        WHEN mes = 'julio' THEN 'July'
                        WHEN mes = 'agosto' THEN 'August'
                        WHEN mes = 'septiembre' THEN 'September'
                        WHEN mes = 'octubre' THEN 'October'
                        WHEN mes = 'noviembre' THEN 'November'
                        WHEN mes = 'diciembre' THEN 'December'
                        ELSE ''
                    END, ' ', year), '%M %Y') >= ?", [$fechaHace12Meses])
            ->get();

        return $data;
    }

    public function getDatosMensualesR1()
    {
        $this->setTable('datos_estadisticos_dia_r1');
        $num = '';
        $idmall = auth()->user()->id_mall;
        $num = ($idmall != 5 && $idmall != 6 && $idmall != 16) ? 'totalenternum' : 'totalenter';

        return $this->selectRaw($num . ' tEntrada, date_format(date, "%d-%m") date')
            ->whereRaw('MONTH(date) = MONTH(curdate()) AND YEAR(date) = YEAR(curdate())')
            ->orderBy('date', 'asc')
            ->get();
    }

    private function getDayNameTranslation($dayName)
    {
        switch ($dayName) {
            case 'Monday':
                return "Lunes";
            case 'Tuesday':
                return "Martes";
            case 'Wednesday':
                return "Miercoles";
            case 'Thursday':
                return "Jueves";
            case 'Friday':
                return "Viernes";
            case 'Saturday':
                return "Sabado";
            case 'Sunday':
                return "Domingo";
            default:
                return "";
        }
    }

    private function getComparativoData($mesActualNumero)
    {
        $this->setTable('datos_estadisticos_dia_r1');
        $idmall = auth()->user()->id_mall;
        $num = ($idmall != 5 && $idmall != 6 && $idmall != 16) ? 'totalenternum' : 'totalenter';

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

        return $this->getJsonDecodedData($data);
    }

    public function comparativoMesActualR1()
    {
        $mesActualNumero = mesActual();
        return $this->getComparativoData($mesActualNumero);
    }

    public function comparativoMesAnteriorR1()
    {
        $mesActualNumero = mesAnterior();
        return $this->getComparativoData($mesActualNumero);
    }








    // public function getAforoHoyR1() //LISTO
    // {
    //     $this->setTable('total_personas_dia');
    //     $data = $this->selectRaw('totalenternum Entradas')
    //         ->where('id', 1)
    //         ->get();
    //     // pre("kie");
    //     // pre_die($data);
    //     return json_decode($data);
    // }
    // public function getAforoAyerR1()
    // {
    //     $this->setTable('personas_dia_ant_r1');
    //     $data = $this->select('totalenternum')
    //         ->get();
    //     return json_decode($data);
    // }

    // public function getPersonasSegmentoAyerR1()
    // {
    //     $this->setTable('personas_segmento_dia_ant_r1');
    //     return $this->selectRaw('totalenternum as Entradas, aforo, segmento')
    //         ->get();
    // }
    // public function getPersonasSegmentoHoyR1()
    // {
    //     $this->setTable('personas_segmento_dia_r1');
    //     $data = $this->selectRaw('totalenternum Entrada, aforo as Aforo, segmento')
    //         ->get();
    //     return json_decode($data);
    // }

    // public function getEntradasCamaraAyerR1()
    // {
    //     $this->setTable('entradas_camara_dia_ant_r1');
    //     $data = $this->selectRaw('cameraindexcode camara, totalenternum tEntrada, nombre, date')
    //         ->orderBy('totalenternum', 'DESC')
    //         ->get();
    //     return json_decode($data);
    // }

    // public function getDatosAnualesR1()
    // {
    //     $this->setTable('total_personas_mes_r1');

    //     // Obtener la fecha actual
    //     $fechaActual = now();

    //     // Calcular la fecha hace 12 meses
    //     $fechaHace12Meses = $fechaActual->subMonths(13);

    //     $data = $this->selectRaw('id, totalentradas as tEntradas,
    //         CONCAT(mes, " - ", year) as mes')
    //         ->where('year', '>=', $fechaHace12Meses->year)
    //         ->whereRaw("STR_TO_DATE(CONCAT(CASE 
    //                     WHEN mes = 'enero' THEN 'January'
    //                     WHEN mes = 'febrero' THEN 'February'
    //                     WHEN mes = 'marzo' THEN 'March'
    //                     WHEN mes = 'abril' THEN 'April'
    //                     WHEN mes = 'mayo' THEN 'May'
    //                     WHEN mes = 'junio' THEN 'June'
    //                     WHEN mes = 'julio' THEN 'July'
    //                     WHEN mes = 'agosto' THEN 'August'
    //                     WHEN mes = 'septiembre' THEN 'September'
    //                     WHEN mes = 'octubre' THEN 'October'
    //                     WHEN mes = 'noviembre' THEN 'November'
    //                     WHEN mes = 'diciembre' THEN 'December'
    //                     ELSE ''
    //                 END, ' ', year), '%M %Y') >= ?", [$fechaHace12Meses])
    //         ->get();

    //     return $data;
    // }

    // public function getDatosMensualesR1()
    // {
    //     $this->setTable('datos_estadisticos_dia_r1');
    //     $num = '';
    //     $idmall = auth()->user()->id_mall;
    //     if ($idmall != 5 && $idmall != 6 && $idmall != 16) {
    //         $num = 'totalenternum';
    //     } else {
    //         $num = 'totalenter';
    //     }

    //     return $this->selectRaw($num . ' tEntrada,
    //     date_format(date, "%d-%m") date')
    //         ->whereRaw('MONTH(date) = MONTH(curdate()) AND YEAR(date) = YEAR(curdate())')
    //         ->orderBy('date', 'asc')
    //         ->get();
    // }

    // public function comparativoMesActualR1()
    // {
    //     $mesActualNumero = mesActual();
    //     $this->setTable('datos_estadisticos_dia_r1');
    //     $num = '';
    //     $idmall = auth()->user()->id_mall;
    //     //pre_die($idmall);
    //     if ($idmall != 5 && $idmall != 6 && $idmall != 16) {
    //         $num = 'totalenternum';
    //     } else {
    //         $num = 'totalenter';
    //     }
    //     $data = $this->selectRaw($num . ' as entrada, 
    //     CASE
    //         WHEN DAYNAME(date) = "Monday" THEN "Lunes"
    //         WHEN DAYNAME(date) = "Tuesday" THEN "Martes"
    //         WHEN DAYNAME(date) = "Wednesday" THEN "Miercoles"
    //         WHEN DAYNAME(date) = "Thursday" THEN "Jueves"
    //         WHEN DAYNAME(date) = "Friday" THEN "Viernes"
    //         WHEN DAYNAME(date) = "Saturday" THEN "Sabado"
    //         WHEN DAYNAME(date) = "Sunday" THEN "Domingo"
    //     END as dia, DATE_FORMAT(date, "%d/%m/%Y") as date')
    //         ->whereRaw('MONTH(date) = ? AND YEAR(date) = YEAR(CURDATE())')
    //         ->addBinding($mesActualNumero, 'select')
    //         ->get();
    //     //pre_die(json_decode($data));

    //     return json_decode($data);
    // }

    // public function comparativoMesAnteriorR1()
    // {
    //     $mesActualNumero = mesAnterior();
    //     $this->setTable('datos_estadisticos_dia_r1');
    //     $num = '';
    //     $idmall = auth()->user()->id_mall;
    //     if ($idmall != 5 && $idmall != 6 && $idmall != 16) {
    //         $num = 'totalenternum';
    //     } else {
    //         $num = 'totalenter';
    //     }
    //     $data = $this->selectRaw($num . ' as entrada, 
    //     CASE
    //         WHEN DAYNAME(date) = "Monday" THEN "Lunes"
    //         WHEN DAYNAME(date) = "Tuesday" THEN "Martes"
    //         WHEN DAYNAME(date) = "Wednesday" THEN "Miercoles"
    //         WHEN DAYNAME(date) = "Thursday" THEN "Jueves"
    //         WHEN DAYNAME(date) = "Friday" THEN "Viernes"
    //         WHEN DAYNAME(date) = "Saturday" THEN "Sabado"
    //         WHEN DAYNAME(date) = "Sunday" THEN "Domingo"
    //     END as dia, DATE_FORMAT(date, "%d/%m/%Y") as date')
    //         ->whereRaw('MONTH(date) = ? AND YEAR(date) = YEAR(CURDATE())')
    //         ->addBinding($mesActualNumero, 'select')
    //         ->get();
    //     //pre_die(json_decode($data));

    //     return json_decode($data);
    // }







    public function getAforoHoyR2() //LISTO
    {
        $this->setTable('total_personas_dia');
        $data = $this->selectRaw('totalenternum Entradas')
            ->where('id', 2)
            ->get();
        return json_decode($data);
    }
    public function getAforoHoyR3() //LISTO
    {
        $this->setTable('total_personas_dia');
        $data = $this->selectRaw('totalenternum Entradas')
            ->where('id', 3)
            ->get();
        return json_decode($data);
    }
    public function getAforoHoyR0()
    {
        $this->setTable('total_personas_dia');
        $data = $this->selectRaw('totalenternum Entradas')
            ->where('id', 4)
            ->get();
        return json_decode($data);
    }







    public function getAforoAyerR2()
    {
        $this->setTable('personas_dia_ant_r2');
        $data = $this->select('totalenternum')
            ->get();
        return json_decode($data);
    }

    public function getPersonasSegmentoAyerR2()
    {
        $this->setTable('personas_segmento_dia_ant_r2');
        return $this->selectRaw('totalenternum as Entradas, aforo, segmento')
            ->get();
    }

    public function getPersonasSegmentoHoyR2()
    {
        $this->setTable('personas_segmento_dia_r2');
        $data = $this->selectRaw('totalenternum Entrada, aforo as Aforo, segmento')
            ->get();
        return json_decode($data);
    }
    public function getAforoAyerR3()
    {
        $this->setTable('personas_dia_ant_r3');
        $data = $this->select('totalenternum')
            ->get();
        return json_decode($data);
    }

    public function getPersonasSegmentoAyerR3()
    {
        $this->setTable('personas_segmento_dia_ant_r3');
        return $this->selectRaw('totalenternum as Entradas, aforo, segmento')
            ->get();
    }

    public function getPersonasSegmentoHoyR3()
    {
        $this->setTable('personas_segmento_dia_r3');
        $data = $this->selectRaw('totalenternum Entrada, aforo as Aforo, segmento')
            ->get();
        return json_decode($data);
    }
    public function getAforoAyerR0()
    {
        $this->setTable('personas_dia_ant_r0');
        $data = $this->select('totalenternum')
            ->get();
        return json_decode($data);
    }

    public function getPersonasSegmentoAyerR0()
    {
        $this->setTable('personas_segmento_dia_ant_r0');
        return $this->selectRaw('totalenternum as Entradas, aforo, segmento')
            ->get();
    }

    public function getPersonasSegmentoHoyR0()
    {
        $this->setTable('personas_segmento_dia_r0');
        $data = $this->selectRaw('totalenternum Entrada, aforo as Aforo, segmento')
            ->get();
        return json_decode($data);
    }







    public function getEntradasCamaraAyerR2()
    {
        $this->setTable('entradas_camara_dia_ant_r2');
        $data = $this->selectRaw('cameraindexcode camara, totalenternum tEntrada, nombre, date')
            ->orderBy('totalenternum', 'DESC')
            ->get();
        return json_decode($data);
    }

    public function getDatosAnualesR2()
    {
        $this->setTable('total_personas_mes_r2');

        $fechaActual = now();
        // Calcular la fecha hace 12 meses
        $fechaHace12Meses = $fechaActual->subMonths(12);

        return $this->selectRaw('id, totalentradas tEntradas, 
        concat(mes," - ", year) as mes')
            ->where('mes', '>=', $fechaHace12Meses)
            ->get();
    }

    public function getDatosMensualesR2()
    {
        $this->setTable('datos_estadisticos_dia_r2');
        $num = '';
        $idmall = auth()->user()->id_mall;
        $mall = GetRowByWhere('malls', ['id' => $idmall]);
        if ($mall->id != 6) {
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

    public function comparativoMesActualR2()
    {
        $mesActualNumero = mesActual();
        $this->setTable('datos_estadisticos_dia_r2');
        $num = '';
        $idmall = auth()->user()->id_mall;
        $mall = GetRowByWhere('malls', ['id' => $idmall]);
        if ($mall->id != 6) {
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

    public function comparativoMesAnteriorR2()
    {
        $mesActualNumero = mesAnterior();
        $this->setTable('datos_estadisticos_dia_r2');
        $num = '';
        $idmall = auth()->user()->id_mall;
        $mall = GetRowByWhere('malls', ['id' => $idmall]);
        if ($mall->id != 6) {
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
    public function getEntradasCamaraAyerR3()
    {
        $this->setTable('entradas_camara_dia_ant_r3');
        $data = $this->selectRaw('cameraindexcode camara, totalenternum tEntrada, nombre, date')
            ->orderBy('totalenternum', 'DESC')
            ->get();
        return json_decode($data);
    }

    public function getDatosAnualesR3()
    {
        $this->setTable('total_personas_mes_r3');
        $fechaActual = now();
        // Calcular la fecha hace 12 meses
        $fechaHace12Meses = $fechaActual->subMonths(12);

        return $this->selectRaw('id, totalentradas tEntradas, 
            concat(mes," - ",year) as mes')
            ->where('mes', '>=', $fechaHace12Meses)
            ->get();
    }

    public function getDatosMensualesR3()
    {
        $this->setTable('datos_estadisticos_dia_r3');
        $num = '';
        $idmall = auth()->user()->id_mall;
        $mall = GetRowByWhere('malls', ['id' => $idmall]);
        if ($mall->id != 6) {
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

    public function comparativoMesActualR3()
    {
        $mesActualNumero = mesActual();
        $this->setTable('datos_estadisticos_dia_r3');
        $num = '';
        $idmall = auth()->user()->id_mall;
        //pre_die($idmall);
        $mall = GetRowByWhere('malls', ['id' => $idmall]);
        if ($mall->id != 6) {
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

    public function comparativoMesAnteriorR3()
    {
        $mesActualNumero = mesAnterior();
        $this->setTable('datos_estadisticos_dia_r3');
        $num = '';
        $idmall = auth()->user()->id_mall;
        $mall = GetRowByWhere('malls', ['id' => $idmall]);
        if ($mall->id != 6) {
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
    public function getEntradasCamaraAyerR0()
    {
        $this->setTable('entradas_camara_dia_ant_r0');
        $data = $this->selectRaw('cameraindexcode camara, totalenternum tEntrada, nombre, date')
            ->orderBy('totalenternum', 'DESC')
            ->get();
        return json_decode($data);
    }

    public function getDatosAnualesR0()
    {
        $this->setTable('total_personas_mes_r0');
        $fechaActual = now();
        // Calcular la fecha hace 12 meses
        $fechaHace12Meses = $fechaActual->subMonths(12);

        return $this->selectRaw('id, totalentradas tEntradas, 
            concat(mes," - ",year) as mes')
            ->where('mes', '>=', $fechaHace12Meses)
            ->get();
    }

    public function getDatosMensualesR0()
    {
        $this->setTable('datos_estadisticos_dia_r0');
        $num = '';
        $idmall = auth()->user()->id_mall;
        $mall = GetRowByWhere('malls', ['id' => $idmall]);
        if ($mall->id != 6) {
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

    public function comparativoMesActualR0()
    {
        $mesActualNumero = mesActual();
        $this->setTable('datos_estadisticos_dia_r0');
        $num = '';
        $idmall = auth()->user()->id_mall;
        //pre_die($idmall);
        $mall = GetRowByWhere('malls', ['id' => $idmall]);
        if ($mall->id != 6) {
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

    public function comparativoMesAnteriorR0()
    {
        $mesActualNumero = mesAnterior();
        $this->setTable('datos_estadisticos_dia_r0');
        $num = '';
        $idmall = auth()->user()->id_mall;
        $mall = GetRowByWhere('malls', ['id' => $idmall]);
        if ($mall->id != 6) {
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
}
