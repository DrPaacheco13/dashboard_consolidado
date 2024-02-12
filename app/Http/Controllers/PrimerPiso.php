<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class PrimerPiso extends Controller
{
    public function index4()
    {
        $idmall = auth()->user()->id_mall;
        $roleid = auth()->user()->role_id;
        $nombreMall = [];

        switch ($idmall) {
            case 1:
                $nombreMall = "San Fernando";
                $uActualizacion = DB::connection('mysql_2')->select('SELECT time_format(timeupdate, "%H:%i") tiempo
                                                            FROM   dashboard_process
                                                            WHERE  id = 1');

                $dHoy = DB::connection('mysql_2')->table('total_personas_dia')
                    ->select(DB::raw('totalenternum Entradas, totalexitnum Salidas'))
                    ->where('id', '=', '1')
                    ->get();
                break;
            case 2:
                $nombreMall = "Coquimbo";
                $uActualizacion = DB::connection('mysql_3')->select('SELECT time_format(timeupdate, "%H:%i") tiempo
                                                            FROM   dashboard_process
                                                            WHERE  id = 1');

                $dHoy = DB::connection('mysql_3')->table('total_personas_dia')
                    ->select(DB::raw('totalenternum Entradas, totalexitnum Salidas'))
                    ->where('id', '=', '1')
                    ->get();
                break;
            case 3:
                $nombreMall = "Trapenses";
                $uActualizacion = DB::connection('mysql_4')->select('SELECT time_format(timeupdate, "%H:%i") tiempo
                                                            FROM   dashboard_process
                                                            WHERE  id = 1');

                $dHoy = DB::connection('mysql_4')->table('total_personas_dia')
                    ->select(DB::raw('totalenternum Entradas, totalexitnum Salidas'))
                    ->where('id', '=', '1')
                    ->get();
                break;
            case 4:
                $nombreMall = "Panoramico";
                $uActualizacion = DB::connection('mysql_5')->select('SELECT time_format(timeupdate, "%H:%i") tiempo
                                                            FROM   dashboard_process
                                                            WHERE  id = 1');

                $dHoy = DB::connection('mysql_5')->table('total_personas_dia')
                    ->select(DB::raw('totalenternum Entradas, totalexitnum Salidas'))
                    ->where('id', '=', '1')
                    ->get();
                break;
        }

        return view('layouts.accesos', compact('dHoy', 'uActualizacion', 'nombreMall', 'roleid'));
    }
}
