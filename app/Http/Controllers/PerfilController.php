<?php

namespace App\Http\Controllers;

use App\Models\ConsultasModel;
use App\Models\MallsModel;
use App\Models\UsersModel;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PerfilController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index(Request $request)
    {
        $id_user = auth()->user()->id;
        $idmall = auth()->user()->mall_id;
        $UserModel = new UsersModel();
        $user = $UserModel->getUser($id_user);
        $post = $request->all();
        if (!empty($post)) {
            $data_user = [
                'id_mall' => $post['id_mall'],
                'updated_at' => GetTimeStamps()
            ];
            $rsp = UpdateRow('users', $data_user, $id_user);
            if($rsp > 0){
                session()->flash('success', ['success' => 'Se ha modificado con éxito la información del usuario', 'success_title' => 'Mi Perfil']);
                return redirect('home');
            }else{
                session()->flash('error', ['error' => 'Perfil no modificado, corroborar información e intentar nuevamente.', 'success_title' => 'Mi Perfil']);
                return redirect('mi-perfil');
            }
        }

        $js_content = [
            '0' => 'users.js.PerfilJS'
        ];
        $malls = QueryBuilder('malls', ['estado' => true, 'deleted' => false]);

        $nav_mantenedor_users = true;
        $nav_listado_users = true;
        $no_top = true;
        return view('users.mi_perfil_view', compact(
            'user',
            'no_top',
            'nav_mantenedor_users',
            'malls',
            'nav_listado_users',
            'js_content',
            'idmall',
        ));
    }
}
