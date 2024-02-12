<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MarketingModel extends Model
{
    protected $connection = 'mysql_1';
    protected $table = 'personas_rf_dia';
    public function __construct()
    {
        configureDatabaseConnection();
    }

    public function getAllRangoEtarioAnterior()
    {
        $this->setTable('personas_rf_dia_ant');
        $data = $this->select('hombres', 'mujeres', '1 as nino', '2 as adolecente', '3 as joven', '4 as adulto', '5 as anciano')
            ->get();
        return json_decode($data);
    }


    public function rangoEtario()
    {
        $this->setTable('personas_rf_dia');
        $data = $this->select('hombres', 'mujeres', '1 as nino', '2 as Adolescentes', '3 as joven', '4 as adulto', '5 as anciano', 'time')
            ->where('id', '=', '1')
            ->get();
        return json_decode($data[0]);
    }
    public function rangoEtarioAll()
    {
        $this->setTable('personas_rf_dia');
        $data = $this->select('id', 'hombres', 'mujeres', '1 as nino', '2 as Adolescentes', '3 as joven', '4 as adulto', '5 as anciano', 'time')
            ->get();
        return json_decode($data);
    }
    public function rangoEtarioAnterior()
    {
        $this->setTable('personas_rf_dia_ant');
        $data = $this->select('id', 'hombres', 'mujeres', '1 as nino', '2 as Adolescentes', '3 as joven', '4 as adulto', '5 as anciano')
            ->get();
        return json_decode($data);
    }

    public function GetRangoEtario($region, $fecha_inicial = '', $fecha_final = '')
    {
        $this->setTable('personas_rf_historic');
        $ipaddress = $region == 1 ?  '192.168.1.212' : '192.168.1.242';
        $data = $this->selectRaw('avg(hombres) as hombres, avg(mujeres) as mujeres, avg(`1`) as nino, avg(`2`) as adolecente, avg(`3`) as joven, avg(`4`) as adulto, avg(`5`) as anciano')
            ->whereBetween('date', [$fecha_inicial, $fecha_final])
            ->where('ipaddress', '=', $ipaddress)
            ->get();
        return json_decode($data);
    }
}
