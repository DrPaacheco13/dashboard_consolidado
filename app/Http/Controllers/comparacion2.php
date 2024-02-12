<?php 

$nombreMall = "Coquimbo";
                $uActualizacion = DB::connection('mysql_3')->select('SELECT time_format(timeupdate, "%H:%i") timeupdate
                                                            FROM   dashboard_process
                                                            WHERE  id = 1');

                $fechaSemanaPasada1 = DB::connection('mysql_3')->table('semana_r1_historic')
                    ->select(DB::raw('date_format(date, "%d-%m-%Y") Fecha1'))
                    ->where('id', '=', '1')
                    ->get();

                $fechaSemanaPasada2 = DB::connection('mysql_3')->table('semana_r1_historic')
                    ->select(DB::raw('date_format(date, "%d-%m-%Y") Fecha2'))
                    ->where('id', '=', '7')
                    ->get();

                $graficoAnual = DB::connection('mysql_3')->table('total_personas_mes_r1')
                    ->select(DB::raw('totalentradas tEntradas, mes'))
                    ->get();

                $aforoActual = DB::connection('mysql_3')->table('total_personas_dia')
                    ->select(DB::raw('totalenternum Entrada, totalexitnum Salida, aforo as Aforo, ocupacion Porcentaje'))
                    ->where('id', '=', '1')
                    ->get();

                $dHoyGrafico = DB::connection('mysql_3')->table('personas_segmento_dia_r1')
                    ->select(DB::raw('totalenternum Entrada, segmento'))
                    ->get();

                $dHoy = DB::connection('mysql_3')->table('total_personas_dia')
                    ->select(DB::raw('totalenternum Entradas, totalexitnum Salidas, aforo as Aforo, ocupacion Porcentaje, 11900 - aforo as Restante'))
                    ->where('id', '=', '1')
                    ->get();

                $dAyer = DB::connection('mysql_3')->table('personas_dia_ant_r1')
                    ->select(DB::raw('totalenternum as Entradas, totalexitnum as Salidas, aforomax as AforoMaximo, aforomin as AforoMinimo, ocupacion'))
                    ->get();

                $dAyerGrafico = DB::connection('mysql_3')->table('personas_segmento_dia_ant_r1')
                    ->select(DB::raw('totalenternum as Entradas, segmento'))
                    ->get();

                $semanaPasada = DB::connection('mysql_3')->table('semana_r1_historic')
                    ->select(DB::raw('dia as dia, max as maximo, promedio as promedio'))
                    ->get();

                $id_mall = DB::connection('mysql')->table('users')
                    ->select(DB::raw('id_mall, id'))
                    ->get();

                $datosAnuales = DB::connection('mysql_3')->select(DB::raw('
                    SELECT id, totalentradas tEntradas, concat(mes," - ",year) as mes
                    FROM (SELECT * FROM total_personas_mes_r1 ORDER BY id DESC LIMIT 12)Var1 
                    ORDER BY id ASC;'));

                $datosMensuales = DB::connection('mysql_3')->select(DB::raw('SELECT totalenternum tEntrada,
                    date_format(date, "%d-%m") date 
                    FROM datos_estadisticos_dia_r1
                    WHERE date_format(date, "%m") like date_format(curdate(), "%m%")
                    ORDER BY date ASC'));

                $anioTotal = DB::connection('mysql_3')->table('total_personas_mes_r1')
                    ->select(DB::raw('totalentradas tEntradas'))
                    ->get();

                $camaraPrueba = DB::connection('mysql_3')->table('entradas_camara_dia_ant_r1')
                    ->select(DB::raw('cameraindexcode camara, totalenternum tEntrada, nombre, date'))
                    ->get();

                $camaraSectorAnterior = DB::connection('mysql_3')->table('entradas_camara_dia_ant_r1')
                    ->selectRaw('cameraindexcode camara, totalenternum tEntrada, nombre, date')
                    ->orderBy('totalenternum', 'DESC')
                    ->get();

                $comparativoDiaMartes = DB::connection('mysql_3')->select(DB::raw('SELECT totalenternum as entrada, 
                    case
                        when dayname(date) = "Monday" then "Lunes"
                        when dayname(date) = "Tuesday" then "Martes"
                        when dayname(date) = "Wednesday" then "Miercoles"
                        when dayname(date) = "Thursday" then "Jueves"
                        when dayname(date) = "Friday" then "Viernes"
                        when dayname(date) = "Saturday" then "Sábado"
                        when dayname(date) = "Sunday" then "Domingo"
                    end as dia, date_format(date, "%d/%m/%Y") as date
                    FROM datos_estadisticos_dia_r1
                    where dayname(date) = "Tuesday" and date_format(date, "%m-%y") = ' . $mesActualNumero . ''));
                $comparativoDiaMiercoles = DB::connection('mysql_3')->select(DB::raw('SELECT totalenternum as entrada, 
                    case
                        when dayname(date) = "Monday" then "Lunes"
                        when dayname(date) = "Tuesday" then "Martes"
                        when dayname(date) = "Wednesday" then "Miercoles"
                        when dayname(date) = "Thursday" then "Jueves"
                        when dayname(date) = "Friday" then "Viernes"
                        when dayname(date) = "Saturday" then "Sábado"
                        when dayname(date) = "Sunday" then "Domingo"
                    end as dia, date_format(date, "%d/%m/%Y") as date
                    FROM datos_estadisticos_dia_r1
                    where dayname(date) = "Wednesday" and date_format(date, "%m-%y") = ' . $mesActualNumero . ''));
                $comparativoDiaJueves = DB::connection('mysql_3')->select(DB::raw('SELECT totalenternum as entrada, 
                    case
                        when dayname(date) = "Monday" then "Lunes"
                        when dayname(date) = "Tuesday" then "Martes"
                        when dayname(date) = "Wednesday" then "Miercoles"
                        when dayname(date) = "Thursday" then "Jueves"
                        when dayname(date) = "Friday" then "Viernes"
                        when dayname(date) = "Saturday" then "Sábado"
                        when dayname(date) = "Sunday" then "Domingo"
                    end as dia, date_format(date, "%d/%m/%Y") as date
                    FROM datos_estadisticos_dia_r1
                    where dayname(date) = "Thursday" and date_format(date, "%m-%y") = ' . $mesActualNumero . ''));
                $comparativoDiaViernes = DB::connection('mysql_3')->select(DB::raw('SELECT totalenternum as entrada, 
                    case
                        when dayname(date) = "Monday" then "Lunes"
                        when dayname(date) = "Tuesday" then "Martes"
                        when dayname(date) = "Wednesday" then "Miercoles"
                        when dayname(date) = "Thursday" then "Jueves"
                        when dayname(date) = "Friday" then "Viernes"
                        when dayname(date) = "Saturday" then "Sábado"
                        when dayname(date) = "Sunday" then "Domingo"
                    end as dia, date_format(date, "%d/%m/%Y") as date
                    FROM datos_estadisticos_dia_r1
                    where dayname(date) = "Friday" and date_format(date, "%m-%y") = ' . $mesActualNumero . ''));
                $comparativoDiaSabado = DB::connection('mysql_3')->select(DB::raw('SELECT totalenternum as entrada, 
                    case
                        when dayname(date) = "Monday" then "Lunes"
                        when dayname(date) = "Tuesday" then "Martes"
                        when dayname(date) = "Wednesday" then "Miercoles"
                        when dayname(date) = "Thursday" then "Jueves"
                        when dayname(date) = "Friday" then "Viernes"
                        when dayname(date) = "Saturday" then "Sábado"
                        when dayname(date) = "Sunday" then "Domingo"
                    end as dia, date_format(date, "%d/%m/%Y") as date
                    FROM datos_estadisticos_dia_r1
                    where dayname(date) = "Saturday" and date_format(date, "%m-%y") = ' . $mesActualNumero . ''));
                $comparativoDiaDomingo = DB::connection('mysql_3')->select(DB::raw('SELECT totalenternum as entrada, 
                    case
                        when dayname(date) = "Monday" then "Lunes"
                        when dayname(date) = "Tuesday" then "Martes"
                        when dayname(date) = "Wednesday" then "Miercoles"
                        when dayname(date) = "Thursday" then "Jueves"
                        when dayname(date) = "Friday" then "Viernes"
                        when dayname(date) = "Saturday" then "Sábado"
                        when dayname(date) = "Sunday" then "Domingo"
                    end as dia, date_format(date, "%d/%m/%Y") as date
                    FROM datos_estadisticos_dia_r1
                    where dayname(date) = "Sunday" and date_format(date, "%m-%y") = ' . $mesActualNumero . ''));

                $comparativoDiaLunes = DB::connection('mysql_3')->select(DB::raw('SELECT totalenternum as entrada, 
                    case
                        when dayname(date) = "Monday" then "Lunes"
                        when dayname(date) = "Tuesday" then "Martes"
                        when dayname(date) = "Wednesday" then "Miercoles"
                        when dayname(date) = "Thursday" then "Jueves"
                        when dayname(date) = "Friday" then "Viernes"
                        when dayname(date) = "Saturday" then "Sábado"
                        when dayname(date) = "Sunday" then "Domingo"
                    end as dia, date_format(date, "%d/%m/%Y") as date
                    FROM datos_estadisticos_dia_r1
                    where dayname(date) = "Monday" and date_format(date, "%m-%y") = ' . $mesActualNumero . ''));

                $comparativoDiaLunesANT = DB::connection('mysql_3')->select(DB::raw('SELECT totalenternum as entrada, 
                    case
                        when dayname(date) = "Monday" then "Lunes"
                        when dayname(date) = "Tuesday" then "Martes"
                        when dayname(date) = "Wednesday" then "Miercoles"
                        when dayname(date) = "Thursday" then "Jueves"
                        when dayname(date) = "Friday" then "Viernes"
                        when dayname(date) = "Saturday" then "Sábado"
                        when dayname(date) = "Sunday" then "Domingo"
                    end as dia, date_format(date, "%d/%m/%Y") as date
                    FROM datos_estadisticos_dia_r1
                    where dayname(date) = "Monday" and date_format(date, "%m-%y") = ' . $mesActualNumeroANT . ''));
                $comparativoDiaMartesANT = DB::connection('mysql_3')->select(DB::raw('SELECT totalenternum as entrada, 
                    case
                        when dayname(date) = "Monday" then "Lunes"
                        when dayname(date) = "Tuesday" then "Martes"
                        when dayname(date) = "Wednesday" then "Miercoles"
                        when dayname(date) = "Thursday" then "Jueves"
                        when dayname(date) = "Friday" then "Viernes"
                        when dayname(date) = "Saturday" then "Sábado"
                        when dayname(date) = "Sunday" then "Domingo"
                    end as dia, date_format(date, "%d/%m/%Y") as date
                    FROM datos_estadisticos_dia_r1
                    where dayname(date) = "Tuesday" and date_format(date, "%m-%y") = ' . $mesActualNumeroANT . ''));
                $comparativoDiaMiercolesANT = DB::connection('mysql_3')->select(DB::raw('SELECT totalenternum as entrada, 
                    case
                        when dayname(date) = "Monday" then "Lunes"
                        when dayname(date) = "Tuesday" then "Martes"
                        when dayname(date) = "Wednesday" then "Miercoles"
                        when dayname(date) = "Thursday" then "Jueves"
                        when dayname(date) = "Friday" then "Viernes"
                        when dayname(date) = "Saturday" then "Sábado"
                        when dayname(date) = "Sunday" then "Domingo"
                    end as dia, date_format(date, "%d/%m/%Y") as date
                    FROM datos_estadisticos_dia_r1
                    where dayname(date) = "Wednesday" and date_format(date, "%m-%y") = ' . $mesActualNumeroANT . ''));
                $comparativoDiaJuevesANT = DB::connection('mysql_3')->select(DB::raw('SELECT totalenternum as entrada, 
                    case
                        when dayname(date) = "Monday" then "Lunes"
                        when dayname(date) = "Tuesday" then "Martes"
                        when dayname(date) = "Wednesday" then "Miercoles"
                        when dayname(date) = "Thursday" then "Jueves"
                        when dayname(date) = "Friday" then "Viernes"
                        when dayname(date) = "Saturday" then "Sábado"
                        when dayname(date) = "Sunday" then "Domingo"
                    end as dia, date_format(date, "%d/%m/%Y") as date
                    FROM datos_estadisticos_dia_r1
                    where dayname(date) = "Thursday" and date_format(date, "%m-%y") = ' . $mesActualNumeroANT . ''));
                $comparativoDiaViernesANT = DB::connection('mysql_3')->select(DB::raw('SELECT totalenternum as entrada, 
                    case
                        when dayname(date) = "Monday" then "Lunes"
                        when dayname(date) = "Tuesday" then "Martes"
                        when dayname(date) = "Wednesday" then "Miercoles"
                        when dayname(date) = "Thursday" then "Jueves"
                        when dayname(date) = "Friday" then "Viernes"
                        when dayname(date) = "Saturday" then "Sábado"
                        when dayname(date) = "Sunday" then "Domingo"
                    end as dia, date_format(date, "%d/%m/%Y") as date
                    FROM datos_estadisticos_dia_r1
                    where dayname(date) = "Friday" and date_format(date, "%m-%y") = ' . $mesActualNumeroANT . ''));
                $comparativoDiaSabadoANT = DB::connection('mysql_3')->select(DB::raw('SELECT totalenternum as entrada, 
                    case
                        when dayname(date) = "Monday" then "Lunes"
                        when dayname(date) = "Tuesday" then "Martes"
                        when dayname(date) = "Wednesday" then "Miercoles"
                        when dayname(date) = "Thursday" then "Jueves"
                        when dayname(date) = "Friday" then "Viernes"
                        when dayname(date) = "Saturday" then "Sábado"
                        when dayname(date) = "Sunday" then "Domingo"
                    end as dia, date_format(date, "%d/%m/%Y") as date
                    FROM datos_estadisticos_dia_r1
                    where dayname(date) = "Saturday" and date_format(date, "%m-%y") = ' . $mesActualNumeroANT . ''));
                $comparativoDiaDomingoANT = DB::connection('mysql_3')->select(DB::raw('SELECT totalenternum as entrada, 
                    case
                        when dayname(date) = "Monday" then "Lunes"
                        when dayname(date) = "Tuesday" then "Martes"
                        when dayname(date) = "Wednesday" then "Miercoles"
                        when dayname(date) = "Thursday" then "Jueves"
                        when dayname(date) = "Friday" then "Viernes"
                        when dayname(date) = "Saturday" then "Sábado"
                        when dayname(date) = "Sunday" then "Domingo"
                    end as dia, date_format(date, "%d/%m/%Y") as date
                    FROM datos_estadisticos_dia_r1
                    where dayname(date) = "Sunday" and date_format(date, "%m-%y") = ' . $mesActualNumeroANT . ''));
