<?php

namespace App\Models;

use Exception;
use Illuminate\Database\Eloquent\Model;

class PDFModel extends Model
{
    protected $connection = 'mysql_1';
    protected $table = '';

    public function __construct()
    {
        configureDatabaseConnection();
    }

    function setTable($tableName)
    {
        $this->table = $tableName;
        return $this;
    }


    public function GetGraficoPorDiaR1($fecha_inicial, $fecha_final)
    {
        $this->setTable('datos_estadisticos_dia_r1');
        $num = '';
        $idmall = auth()->user()->id_mall;
        if ($idmall != 5 && $idmall != 6) {
            $num = 'totalenternum';
        } else {
            $num = 'totalenter';
        }

        $data = $this->selectRaw('max(' . $num . ') Entradas, date_format(date, "%m-%d") date')
            ->whereBetween('date', [$fecha_inicial, $fecha_final])
            ->groupBy('date')
            ->get();
        return json_decode($data);
    }

    public function GetDatosR1($fecha_inicial, $fecha_final)
    {
        $this->setTable('datos_estadisticos_dia_r1');
        $numtotalenter = '';
        $numtotalexit = '';
        $idmall = auth()->user()->id_mall;
        if ($idmall != 5 && $idmall != 6) {
            $numtotalenter = 'totalenternum';
            $numtotalexit = 'totalexitnum';
        } else {
            $numtotalenter = 'totalenter';
            $numtotalexit = 'totalexit';
        }

        $query = $this->selectRaw('sum(' . $numtotalenter . ') tEntrada, sum(' . $numtotalexit . ') tSalida');
        if (!empty($fecha_inicial) && !empty($fecha_final)) {
            $query->whereBetween('date', [$fecha_inicial, $fecha_final]);
        } elseif (!empty($fecha_inicial)) {
            $query->where('date', '=', $fecha_inicial);
        } elseif (!empty($fecha_final)) {
            $query->where('date', '=', $fecha_final);
        }
        $data = $query->get();
        return json_decode($data);
    }

    public function GetSegmentoEntradaR1($fecha_inicial, $fecha_final)
    {
        $this->setTable('datos_seg_historicos_r1');
        $data = [];

        try {
            $query = $this->selectRaw('sum(`08`) as sum_08, sum(`09`) as sum_09, sum(`10`) as sum_10, sum(`11`) as sum_11, sum(`12`) as sum_12, sum(`13`) as sum_13, sum(`14`) as sum_14, sum(`15`) as sum_15, sum(`16`) as sum_16, sum(`17`) as sum_17, sum(`18`) as sum_18, sum(`19`) as sum_19, sum(`20`) as sum_20, sum(`21`) as sum_21, sum(`22`) as sum_22, sum(`23`) as sum_23, Tipo')
                ->where('Tipo', '=', 'Total Entradas');
            if (!empty($fecha_inicial) && !empty($fecha_final)) {
                $query->whereBetween('date', [$fecha_inicial, $fecha_final]);
            } elseif (!empty($fecha_inicial)) {
                $query->where('date', '=', $fecha_inicial);
            } elseif (!empty($fecha_final)) {
                $query->where('date', '=', $fecha_final);
            }

            $data = $query->groupBy('Tipo')->get();
        } catch (Exception $ex) {
            pre_die($ex->getMessage());
        }

        return json_decode($data);
    }
   

    public function GetGraficoPorCamaraR1($fecha_inicial, $fecha_final)
    {
        $idmall = auth()->user()->id_mall;
        $this->setTable('detalle_camara_r1 as dcr1');
        $query = $this->join($idmall != 4 ? 'nombre_camaras as nc' : 'entradas_camara_dia_ant_r1 as nc', 'dcr1.cameraindexcode', '=', $idmall != 4 ? 'nc.camaraindexcode' : 'nc.cameraindexcode')
            ->selectRaw('nc.nombre as nombre, sum(enternum) as Entradas');
        if (!empty($fecha_inicial) && !empty($fecha_final)) {
            $query->whereBetween('dcr1.date', [$fecha_inicial, $fecha_final]);
        } elseif (!empty($fecha_inicial)) {
            $query->where('dcr1.date', '=', $fecha_inicial);
        } elseif (!empty($fecha_final)) {
            $query->where('dcr1.date', '=', $fecha_final);
        }

        $data = $query->groupBy('nc.nombre')->orderBy('Entradas', 'desc')->get();
        return json_decode($data);
    }
 public function GetSegmentoEntradaGroupR1($fecha_inicial, $fecha_final)
    {
        $this->setTable('datos_seg_historicos_r1');
        $data = [];

        try {
            $query = $this->selectRaw('sum(`08`) as sum_08, sum(`09`) as sum_09, sum(`10`) as sum_10, sum(`11`) as sum_11, sum(`12`) as sum_12, sum(`13`) as sum_13, sum(`14`) as sum_14, sum(`15`) as sum_15, sum(`16`) as sum_16, sum(`17`) as sum_17, sum(`18`) as sum_18, sum(`19`) as sum_19, sum(`20`) as sum_20, sum(`21`) as sum_21, sum(`22`) as sum_22, sum(`23`) as sum_23, Tipo, date')
                ->where('Tipo', '=', 'Total Entradas');
            if (!empty($fecha_inicial) && !empty($fecha_final)) {
                $query->whereBetween('date', [$fecha_inicial, $fecha_final]);
            } elseif (!empty($fecha_inicial)) {
                $query->where('date', '=', $fecha_inicial);
            } elseif (!empty($fecha_final)) {
                $query->where('date', '=', $fecha_final);
            }

            $data = $query->groupBy('Tipo', 'date')->get();
        } catch (Exception $ex) {
            pre_die($ex->getMessage());
        }

        return json_decode($data);
    }

    public function GetGraficoPorDiaR2($fecha_inicial, $fecha_final)
    {
        $this->setTable('datos_estadisticos_dia_r2');
        $num = '';
        $idmall = auth()->user()->id_mall;
        if ($idmall != 5 && $idmall != 6) {
            $num = 'totalenternum';
        } else {
            $num = 'totalenter';
        }

        $data = $this->selectRaw('max(' . $num . ') Entradas, date_format(date, "%m-%d") date')
            ->whereBetween('date', [$fecha_inicial, $fecha_final])
            ->groupBy('date')
            ->get();
        return json_decode($data);
    }

    public function GetDatosR2($fecha_inicial, $fecha_final)
    {
        $this->setTable('datos_estadisticos_dia_r2');

        $numtotalenter = '';
        $numtotalexit = '';
        $idmall = auth()->user()->id_mall;
        if ($idmall != 5 && $idmall != 6) {
            $numtotalenter = 'totalenternum';
            $numtotalexit = 'totalexitnum';
        } else {
            $numtotalexit = 'totalexit';
            $numtotalenter = 'totalenter';
        }

        $query = $this->selectRaw('sum(' . $numtotalenter . ') tEntrada, sum(' . $numtotalexit . ') tSalida');
        if (!empty($fecha_inicial) && !empty($fecha_final)) {
            $query->whereBetween('date', [$fecha_inicial, $fecha_final]);
        } elseif (!empty($fecha_inicial)) {
            $query->where('date', '=', $fecha_inicial);
        } elseif (!empty($fecha_final)) {
            $query->where('date', '=', $fecha_final);
        }
        $data = $query->get();
        return json_decode($data);
    }

    public function GetSegmentoEntradaR2($fecha_inicial, $fecha_final)
    {
        $this->setTable('datos_seg_historicos_r2');
        $data = [];

        try {
            $query = $this->selectRaw('sum(`08`) as sum_08, sum(`09`) as sum_09, sum(`10`) as sum_10, sum(`11`) as sum_11, sum(`12`) as sum_12, sum(`13`) as sum_13, sum(`14`) as sum_14, sum(`15`) as sum_15, sum(`16`) as sum_16, sum(`17`) as sum_17, sum(`18`) as sum_18, sum(`19`) as sum_19, sum(`20`) as sum_20, sum(`21`) as sum_21, sum(`22`) as sum_22, sum(`23`) as sum_23, Tipo')
                ->where('Tipo', '=', 'Total Entradas');
            if (!empty($fecha_inicial) && !empty($fecha_final)) {
                $query->whereBetween('date', [$fecha_inicial, $fecha_final]);
            } elseif (!empty($fecha_inicial)) {
                $query->where('date', '=', $fecha_inicial);
            } elseif (!empty($fecha_final)) {
                $query->where('date', '=', $fecha_final);
            }

            $data = $query->groupBy('Tipo')->get();
        } catch (Exception $ex) {
            pre_die($ex->getMessage());
        }

        return json_decode($data);
    }
    public function GetSegmentoEntradaGroupR2($fecha_inicial, $fecha_final)
    {
        $this->setTable('datos_seg_historicos_r2');
        $data = [];

        try {
            $query = $this->selectRaw('sum(`08`) as sum_08, sum(`09`) as sum_09, sum(`10`) as sum_10, sum(`11`) as sum_11, sum(`12`) as sum_12, sum(`13`) as sum_13, sum(`14`) as sum_14, sum(`15`) as sum_15, sum(`16`) as sum_16, sum(`17`) as sum_17, sum(`18`) as sum_18, sum(`19`) as sum_19, sum(`20`) as sum_20, sum(`21`) as sum_21, sum(`22`) as sum_22, sum(`23`) as sum_23, Tipo, date')
                ->where('Tipo', '=', 'Total Entradas');
            if (!empty($fecha_inicial) && !empty($fecha_final)) {
                $query->whereBetween('date', [$fecha_inicial, $fecha_final]);
            } elseif (!empty($fecha_inicial)) {
                $query->where('date', '=', $fecha_inicial);
            } elseif (!empty($fecha_final)) {
                $query->where('date', '=', $fecha_final);
            }

            $data = $query->groupBy('Tipo', 'date')->get();
        } catch (Exception $ex) {
            pre_die($ex->getMessage());
        }

        return json_decode($data);
    }


    public function GetGraficoPorCamaraR2($fecha_inicial, $fecha_final)
    {
        $idmall = auth()->user()->id_mall;
        $this->setTable('detalle_camara_r2 as dcr1');
        $query = $this->join($idmall != 4 ? 'nombre_camaras as nc' : 'entradas_camara_dia_ant_r2 as nc', 'dcr1.cameraindexcode', '=', $idmall != 4 ? 'nc.camaraindexcode' : 'nc.cameraindexcode')
            ->selectRaw('nc.nombre as nombre, sum(enternum) as Entradas');
        if (!empty($fecha_inicial) && !empty($fecha_final)) {
            $query->whereBetween('dcr1.date', [$fecha_inicial, $fecha_final]);
        } elseif (!empty($fecha_inicial)) {
            $query->where('dcr1.date', '=', $fecha_inicial);
        } elseif (!empty($fecha_final)) {
            $query->where('dcr1.date', '=', $fecha_final);
        }

        $data = $query->groupBy('nc.nombre')->orderBy('Entradas', 'desc')->get();
        return json_decode($data);
    }

    public function graficoPorDiaFechasR1($fecha, $fecha2)
    {
        $this->setTable('datos_estadisticos_dia_r1');
        $num = '';
        $idmall = auth()->user()->id_mall;
        if ($idmall != 5 && $idmall != 6) {
            $num = 'totalenternum';
        } else {
            $num = 'totalenter';
        }

        return $this->selectRaw('max(' . $num . ') Entradas, date_format(date, "%m-%d") date')
            ->whereBetween('date', [$fecha, $fecha2])
            ->groupBy('date')
            ->get();
    }

    public function DatosSegmentadosExcelxDiaR1($fecha_inicial, $fecha_final)
    {

        $this->setTable('datos_estadisticos_dia_r1');
        $num = '';
        $idmall = auth()->user()->id_mall;
        if ($idmall != 5 && $idmall != 6) {
            $num = 'totalenternum';
        } else {
            $num = 'totalenter';
        }

        $data = $this->select($num, 'date')
            ->whereBetween('date', [$fecha_inicial, $fecha_final])
            ->get();
        return json_decode($data);
    }
    public function DatosSegmentadosExcelxDiaR2($fecha_inicial, $fecha_final)
    {

        $this->setTable('datos_estadisticos_dia_r2');
        $num = '';
        $idmall = auth()->user()->id_mall;
        if ($idmall != 5 && $idmall != 6) {
            $num = 'totalenternum';
        } else {
            $num = 'totalenter';
        }

        $data = $this->select($num, 'date')
            ->whereBetween('date', [$fecha_inicial, $fecha_final])
            ->get();
        return json_decode($data);
    }
    public function GetGraficoPorDiaR3($fecha_inicial, $fecha_final)
    {
        $this->setTable('datos_estadisticos_dia_r3');
        $num = '';
        $idmall = auth()->user()->id_mall;
        if ($idmall != 5 && $idmall != 6) {
            $num = 'totalenternum';
        } else {
            $num = 'totalenter';
        }

        $data = $this->selectRaw('max(' . $num . ') Entradas, date_format(date, "%m-%d") date')
            ->whereBetween('date', [$fecha_inicial, $fecha_final])
            ->groupBy('date')
            ->get();
        return json_decode($data);
    }

    public function GetDatosR3($fecha_inicial, $fecha_final)
    {
        $this->setTable('datos_estadisticos_dia_r3');

        $numtotalenter = '';
        $numtotalexit = '';
        $idmall = auth()->user()->id_mall;
        if ($idmall != 5 && $idmall != 6) {
            $numtotalenter = 'totalenternum';
            $numtotalexit = 'totalexitnum';
        } else {
            $numtotalexit = 'totalexit';
            $numtotalenter = 'totalenter';
        }

        $query = $this->selectRaw('sum(' . $numtotalenter . ') tEntrada, sum(' . $numtotalexit . ') tSalida');
        if (!empty($fecha_inicial) && !empty($fecha_final)) {
            $query->whereBetween('date', [$fecha_inicial, $fecha_final]);
        } elseif (!empty($fecha_inicial)) {
            $query->where('date', '=', $fecha_inicial);
        } elseif (!empty($fecha_final)) {
            $query->where('date', '=', $fecha_final);
        }
        $data = $query->get();
        return json_decode($data);
    }

    public function GetSegmentoEntradaR3($fecha_inicial, $fecha_final)
    {
        $this->setTable('datos_seg_historicos_r3');
        $data = [];

        try {
            $query = $this->selectRaw('sum(`08`) as sum_08, sum(`09`) as sum_09, sum(`10`) as sum_10, sum(`11`) as sum_11, sum(`12`) as sum_12, sum(`13`) as sum_13, sum(`14`) as sum_14, sum(`15`) as sum_15, sum(`16`) as sum_16, sum(`17`) as sum_17, sum(`18`) as sum_18, sum(`19`) as sum_19, sum(`20`) as sum_20, sum(`21`) as sum_21, sum(`22`) as sum_22, sum(`23`) as sum_23, Tipo')
                ->where('Tipo', '=', 'Total Entradas');
            if (!empty($fecha_inicial) && !empty($fecha_final)) {
                $query->whereBetween('date', [$fecha_inicial, $fecha_final]);
            } elseif (!empty($fecha_inicial)) {
                $query->where('date', '=', $fecha_inicial);
            } elseif (!empty($fecha_final)) {
                $query->where('date', '=', $fecha_final);
            }

            $data = $query->groupBy('Tipo')->get();
        } catch (Exception $ex) {
            pre_die($ex->getMessage());
        }

        return json_decode($data);
    }

    public function GetGraficoPorCamaraR3($fecha_inicial, $fecha_final)
    {
        $idmall = auth()->user()->id_mall;
        $this->setTable('detalle_camara_r3 as dcr1');
        $query = $this->join($idmall != 4 ? 'nombre_camaras as nc' : 'entradas_camara_dia_ant_r2 as nc', 'dcr1.cameraindexcode', '=', $idmall != 4 ? 'nc.camaraindexcode' : 'nc.cameraindexcode')
            ->selectRaw('nc.nombre as nombre, sum(enternum) as Entradas');
        if (!empty($fecha_inicial) && !empty($fecha_final)) {
            $query->whereBetween('dcr1.date', [$fecha_inicial, $fecha_final]);
        } elseif (!empty($fecha_inicial)) {
            $query->where('dcr1.date', '=', $fecha_inicial);
        } elseif (!empty($fecha_final)) {
            $query->where('dcr1.date', '=', $fecha_final);
        }

        $data = $query->groupBy('nc.nombre')->orderBy('Entradas', 'desc')->get();
        return json_decode($data);
    }

}
