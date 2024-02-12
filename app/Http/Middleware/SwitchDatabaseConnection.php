<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;

class SwitchDatabaseConnection
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        //pre_die(auth()->user());
        $mallId = auth()->user()->id_mall;
        
        
        // Obtén la información de la base de datos
        $databaseInfo = $this->getDatabaseInfo($mallId);

        // Configura la conexión de la base de datos
        $this->configureDatabaseConnection($databaseInfo);

        //$response = $next($request);
        // Continúa con la solicitud

        /* Restaura la conexión a la base de datos predeterminada
        $this->resetDatabaseConnection();*/
        return $next($request);
    }

    protected function getDatabaseInfo($mallId)
    {
        // Lógica para obtener la información de la base de datos desde la tabla databases
        return GetRowByWhere('databases', ['mall_id' => $mallId]);
    }

    protected function configureDatabaseConnection($databaseInfo)
    {
        //pre_die($databaseInfo);
        $dbConfig = [
            'driver' => 'mysql',
            'host' => $databaseInfo->db_host,
            'port' => $databaseInfo->db_port,
            'database' => $databaseInfo->db_name,
            'username' => $databaseInfo->db_user,
            'password' => $databaseInfo->db_password,
            'charset' => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
            'prefix' => '',
        ];

        // Conectar a la base de datos utilizando las credenciales obtenidas
        DB::purge('mysql_1');
        Config::set('database.connections.mysql', $dbConfig);
    }

    protected function resetDatabaseConnection()
    {
        // Restaurar la conexión predeterminada
        DB::purge('mysql');
        Config::set('database.connections.mysql', Config::get('database.default'));
    }
}
