<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;

class RedirectRoutes
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
        $role_id = auth()->user()->role_id;
        $id_mall = auth()->user()->id_mall;
        $mall = getMallsRegiones($id_mall);
        if ($role_id == 3) {
            return redirect()->route('gerentes/administracion');
        } elseif ($mall->acceso_r0 == false && $mall->acceso_r1 == false && $mall->acceso_r2 == false && $mall->acceso_r3 == false) {
            return redirect()->route('vehicle');
        }
        return $next($request);
    }
}
