<?php

namespace App\Http\Controllers;

use App\Models\ConsultasModel;
use App\Models\GerentesModel;
use App\Models\MallsModel;
use App\Models\TendenciasModel;
use App\Models\UsersModel;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GerenteController extends Controller
{


    public function __construct()
    {
        // $this->middleware('auth');
    }

    public function index()
    {
        $idmall = auth()->user()->id_mall;
        $distribucion_id = auth()->user()->distribucion_id;
        $role_id = auth()->user()->role_id;

        // pre_die($distribucion_id);
        $datos_malls = GetDataApi('administracion-gerente', $distribucion_id);
        $datos_malls = $datos_malls->malls;
        // pre_die($datos_malls);

        $data = [
            'nav_gerente_administracion' => true,
            'datos_malls' => !empty($datos_malls) ? $datos_malls : [],
            'no_top' => true,
            'idmall' => $idmall,
            'role_id' => $role_id,
            'js_content' => [
                0 => 'layouts/js/GeneralJS',
                1 => 'gerentes/js/AdministracionJS',
            ],
        ];
        // pre_die($datos)
        return view('gerentes.administracion_view', $data);
    }

    public function RedirectMall($mall_id)
    {
        if (!is_numeric($mall_id)) {
            return redirect('gerentes/administracion');
        }
        $role_id = auth()->user()->role_id;
        if ($role_id < 3) {
            return redirect('logoutSession');
        }
        $distribucion_id = auth()->user()->distribucion_id;
        $user_id = auth()->user()->id;
        $where_user = [
            // 'id_mall' => $mall_id,
            'user_id_reference' => $user_id,
            'estado' => true,
            'deleted' => false,
            'temporal_user' => true,
        ];
        $user_temporal = GetRowByWhere('users', $where_user);

        if (empty($user_temporal)) {
            $this->GenerarUserTemporal($mall_id, $user_id, $distribucion_id);
            $user_temporal = GetRowByWhere('users', $where_user);
        }else{
            if($user_temporal->id_mall !== $mall_id){
                UpdateRow('users', ['id_mall' => $mall_id, 'updated_at' => GetTimeStamps()], $user_temporal->id);
            }
        }
        auth()->logout();
        auth()->loginUsingId($user_temporal->id);
        return redirect('/');
    }

    public function GerenteRetorna($distribucion_id, $user_id_reference)
    {
        $user_where = [
            'id' => $user_id_reference,
            'distribucion_id' => $distribucion_id,
            'estado' => true,
            'deleted' => false,
            'role_id' => 3,
        ];
        $user = GetRowByWhere('users', $user_where);
        if(empty($user)){
            auth()->logout();
            return redirect('login');
        }
        auth()->logout();
        auth()->loginUsingId($user->id);
        return redirect('/');
    }

    protected function GenerarUserTemporal($mall_id, $user_id, $distribucion_id)
    {
        $rand = rand(111111, 999999);
        $new_user = [
            'name' => "Usuario Temporal #$rand",
            'email' => "user_temporal$rand@dmtech.cl",
            'password' => bcrypt(1234),
            'distribucion_id' => $distribucion_id,
            'role_id' => 4,
            'estado' => true,
            'deleted' => false,
            'temporal_user' => true,
            'id_mall' => $mall_id,
            'user_id_reference' => $user_id,
            'created_at' => GetTimeStamps()
        ];

        $valida = InsertRow('users', $new_user);

        return $valida > 0 ? $valida : 0;
    }
}
