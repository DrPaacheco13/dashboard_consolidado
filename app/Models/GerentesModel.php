<?php

namespace App\Models;

use Carbon\Carbon;
use FTP\Connection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class GerentesModel extends Model
{
    protected $connection = 'mysql_1'; // Establece la conexión directamente como un string
    protected $table = 'dashboard_process';

    public function __construct($data = null)
    {
        $db = !empty($_SESSION['db_active']) ? $_SESSION['db_active'] : [];
        // pre_die($db);
        if (empty($db)) {
            configureDatabaseConnection();
        } else {
            configureDatabaseConnection($db);
        }
    }

    function setTable($tableName)
    {
        $this->table = $tableName;
        return $this;
    }
    public function GetDataTendencia()
    {
        $this->setTable('vehiculos_segmento_personas_dia');
        $data = $this->select('totalenter as Entrada', 'segmento')
            ->get();
        return json_decode($data);
    }
    public function GetDataR1()
    {
        $this->setTable('personas_segmento_dia_r1');
        $data = $this->selectRaw('totalenternum Entrada, aforo as Aforo, segmento')
            ->get();
        return json_decode($data);
    }
    public function GetDataR2()
    {
        $this->setTable('personas_segmento_dia_r2');
        $data = $this->selectRaw('totalenternum Entrada, aforo as Aforo, segmento')
            ->get();
        return json_decode($data);
    }
    public function GetDataR3()
    {
        $this->setTable('personas_segmento_dia_r3');
        $data = $this->selectRaw('totalenternum Entrada, aforo as Aforo, segmento')
            ->get();
        return json_decode($data);
    }

    public function aforoActualR1()
    {
        $this->setTable('total_personas_dia');
        $data = $this->selectRaw('totalenternum Entrada, totalexitnum Salida, aforo as Aforo, ocupacion Porcentaje, time as actualizacion')
            ->where('id', '=', '1')
            ->first();
        return json_decode($data);
    }

    public function aforoActualR2()
    {
        $this->setTable('total_personas_dia');
        $data = $this->selectRaw('totalenternum Entrada, totalexitnum Salida, aforo as Aforo, ocupacion Porcentaje, time as actualizacion')
            ->where('id', '=', '2')
            ->first();
        return json_decode($data);
    }
    public function aforoActualR3()
    {
        $this->setTable('total_personas_dia');
        $data = $this->selectRaw('totalenternum Entrada, totalexitnum Salida, aforo as Aforo, ocupacion Porcentaje, time as actualizacion')
            ->where('id', '=', '3')
            ->first();
        return json_decode($data);
    }
    public function aforoActualR0()
    {
        $this->setTable('total_personas_dia');
        $data = $this->selectRaw('totalenternum Entrada, totalexitnum Salida, aforo as Aforo, ocupacion Porcentaje, time as actualizacion')
            ->where('id', '=', '4')
            ->first();
        return json_decode($data);
    }
    public function aforoActualVehicle()
    {
        $this->setTable('vehiculos_total_dia');
        $data = $this->selectRaw('totalexit, totalenter, estadia')
            ->first();
        return json_decode($data);
    }

    public function aforoActualTendencia()
    {
        $this->setTable('vehiculos_personas_dia');
        $data = $this->selectRaw('totalenter Entrada, totalexit Salida, time as actualizacion')
            ->where('id', '=', '1')
            ->first();
        return json_decode($data);
    }
}
