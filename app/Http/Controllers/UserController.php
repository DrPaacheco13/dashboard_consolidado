<?php

namespace App\Http\Controllers;

use App\Models\ConsultasModel;
use App\Models\MallsModel;
use App\Models\UsersModel;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Http\Request;

class UserController extends Controller
{


    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $idmall = auth()->user()->id_mall;
        $UsersModel = new UsersModel();
        $where_user = [
            'u.estado' => true,
            'u.deleted' => false,
            'u.temporal_user' => false,
        ];
        $users = $UsersModel->getUsers($where_user);
        $js_content = [
            '0' => 'users.js.UsersJS'
        ];
        $nav_mantenedor_users = true;
        $nav_listado_users = true;
        $no_top = true;
        $nombre_mall = 'Listado de Usuarios';
        return view('users.users_listado_view', compact(
            'nombre_mall',
            'users',
            'no_top',
            'nav_mantenedor_users',
            'nav_listado_users',
            'js_content',
            'idmall',
        ));
    }

    public function NuevoUsuario(Request $request)
    {
        $post = $request->all();
        $idmall = auth()->user()->id_mall;

        if (!empty($post)) {
            // Validar los campos
            $validate = $this->ValidateFields($post);

            if ($validate) {
                // Mostrar errores de validación
                session()->flash('error', ['error' => 'Se han encontrado los siguientes errores: ' . implode(',', $validate), 'error_title' => 'Error al Validar Formulario']);
                return redirect('users/nuevo')->withInput($post);
            }
            $mall = GetRowByWhere('malls', ['id' => $post['id_mall']]);
            $distribucion_id = null;
            if (!empty($mall)) {
                $distribucion_id = $mall->distribucion_id;
            }
            // Crear nuevo user
            $new_user = [
                'name' => !empty($post['name']) ? $post['name'] : NULL,
                'email' => !empty($post['email']) ? $post['email'] : NULL,
                'role_id' => !empty($post['role_id']) ? $post['role_id'] : NULL,
                'id_mall' => !empty($post['id_mall']) ? $post['id_mall'] : NULL,
                'distribucion_id' => !empty($post['distribucion_id']) ? $post['distribucion_id'] : $distribucion_id,
                'estado' => true,
                'password' => bcrypt(1234),
                'valida_password' => true,
                'created_at' => GetTimeStamps()
            ];

            $UsersModel = new UsersModel();

            $user = $UsersModel->insertUser($new_user);
            // Insertar nuevo mall

            if ($user > 0) {
                // Éxito al registrar el nuevo Mall
                session()->flash('success', ['success' => 'Se ha registrado con éxito el nuevo usuario', 'success_title' => 'Gestión de Usuarios']);
                return redirect('users/listado');
            } else {
                // Error al registrar el Mall
                session()->flash('error', ['error' => 'Usuario no registrado, inténtelo nuevamente por favor', 'error_title' => 'Gestión de Usuarios']);
                return redirect('users/nuevo')->withInput($post);
            }
        }

        $roles = QueryBuilder('roles', ['estado' => true]);
        $malls = QueryBuilder('malls', ['estado' => true, 'deleted' => false]);

        $js_content = [
            0 => 'layouts.js.GeneralJS',
            1 => 'users.js.UsersNewJS'
        ];
        $nav_mantenedor_users = true;
        $nav_nuevo_user = true;
        $no_top = true;
        return view('users.users_nuevo_view', compact(
            'nav_mantenedor_users',
            'nav_nuevo_user',
            'js_content',
            'idmall',
            'no_top',
            'roles',
            'malls',
        ));
    }

    public function EditarUsuario(Request $request, $id)
    {
        $idmall = $id;
        if (!is_numeric($id)) {
            session()->flash('error', ['error' => 'El Usuario seleccionado no existe o fue eliminado.', 'error_title' => 'Gestión de Usuarios']);
            return redirect('users/listado');
        }
        $UsersModel = new UsersModel();
        $user = $UsersModel->getUser($id);
        if (empty($user)) {
            session()->flash('error', ['error' => 'El Usuario seleccionado no existe o fue eliminado.', 'error_title' => 'Gestión de Usuarios']);
            return redirect('users/listado');
        }
        $post = $request->all();
        if (!empty($post)) {
            $validate = $this->ValidateFields($post);

            if ($validate) {
                // Mostrar errores de validación
                session()->flash('error', ['error' => 'Se han encontrado los siguientes errores: ' . implode(',', $validate), 'error_title' => 'Error al Validar Formulario']);
                return redirect('users/editar/' . $id)->withInput($post);
            }

            // Crear nuevo mall
            $data_user = [
                'name' => !empty($post['name']) ? $post['name'] : NULL,
                'estado' => !empty($post['estado']) ? ($post['estado'] == 1 ? true : false) : false,
                'email' => !empty($post['email']) ? $post['email'] : NULL,
                'role_id' => !empty($post['role_id']) ? $post['role_id'] : NULL,
                'id_mall' => !empty($post['id_mall']) ? $post['id_mall'] : NULL,
                'distribucion_id' => !empty($post['distribucion_id']) ? $post['distribucion_id'] : NULL,
                'updated_at' => GetTimeStamps()
            ];

            $user = $UsersModel->updateUser($data_user, $id);
            // Insertar nuevo mall
            if ($user > 0) {
                // Éxito al registrar el nuevo Mall
                session()->flash('success', ['success' => 'Se ha registrado con éxito el nuevo Mall', 'success_title' => 'Gestión de Usuarios']);
                return redirect('users/listado');
            } else {
                // Error al registrar el Mall
                session()->flash('error', ['error' => 'Mall no registrado, inténtelo nuevamente por favor', 'error_title' => 'Gestión de Usuarios']);
                return redirect('users/editar/' . $id)->withInput($post);
            }
        }


        $roles = QueryBuilder('roles', ['estado' => true]);
        $malls = QueryBuilder('malls', ['estado' => true, 'deleted' => false]);


        $js_content = [
            '0' => 'users.js.UsersEditJS'
        ];
        $nav_mantenedor_users = true;
        $nav_listado_user = true;
        $no_top = true;
        return view('users.users_editar_view', compact(
            'nav_mantenedor_users',
            'nav_listado_user',
            'js_content',
            'idmall',
            'no_top',
            'user',
            'roles',
            'malls',
        ));
    }

    public function EliminarUsuario(Request $request)
    {
        $post = $request->all();
        // pre_die($post);
        if (!empty($post['usuario_id'])) {
            $usuario_id = $post['usuario_id'];
            if(!empty($usuario_id)){
                $usuario = GetRowByWhere('users', ['deleted' => false, 'id' => $usuario_id]);
                if(!empty($usuario)){
                    $valida = UpdateRow('users', ['deleted' => false, 'estado' => false, 'deleted_at' => GetTimeStamps()], $usuario->id);
                    if($valida){
                        $rsp = [
                            'tipo' => 'success',
                            'msg' => 'Usuario eliminado con éxito.'
                        ];
                    }else{
                        $rsp = [
                            'tipo' => 'error',
                            'msg' => 'Usuario no eliminado, recarga la página e intenta nuevamente por favor.'
                        ];
                    }
                }else{
                    $rsp = [
                        'tipo' => 'error',
                        'msg' => 'Usuario no existe o fue eliminado.'
                    ];
                }
            }else{
                $rsp = [
                    'tipo' => 'error',
                    'msg' => 'Datos no recibidos por el servidor.'
                ];
            }
        } else {
            $rsp = [
                'tipo' => 'error',
                'msg' => 'Datos no recibidos por el servidor.'
            ];
        }

        return json_encode($rsp);
    }

    private function ValidateFields($data)
    {
        $error = [];
        $error_flag = false;

        if (!empty($data['name'])) {
            if (validateText(trim($data['name']))) {
                $error_flag = true;
                $error['name'] = 'Nombre';
            }
        } else {
            $error_flag = true;
            $error['name'] = 'Nombre';
        }



        if ($error_flag) {
            return $error;
        } else {
            return false;
        }
    }
}
