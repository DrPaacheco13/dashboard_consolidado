<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TendenciasModel extends Model
{
    protected $connection = 'mysql_1';
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

    public function uActualizacion()
    {
        $this->setTable('dashboard_process');
        return $this->selectRaw('time_format(timeupdate, "%H:%i") tiempo')
            ->where('id', '=', 1)
            ->get();
    }

    public function dHoy()
    {
        $this->setTable('vehiculos_personas_dia');
        return $this->select('totalenter as Entradas')
            ->where('id', '=', '1')
            ->get();
    }

    public function dHoyGrafico()
    {
        $this->setTable('vehiculos_segmento_personas_dia');
        $data = $this->select('totalenter as Entrada', 'segmento')
            ->get();
        return json_decode($data);
    }

    public function dAyer()
    {
        $this->setTable('vehiculos_personas_dia_ant');
        return $this->select('totalenter')
            ->get();
    }

    public function dAyerGrafico()
    {
        $this->setTable('vehiculos_segmento_personas_dia_ant');
        return $this->select('totalenter as Entradas', 'segmento')
            ->get();
    }
}
