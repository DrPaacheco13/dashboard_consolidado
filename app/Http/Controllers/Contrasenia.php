<?php

namespace App\Http\Controllers;

use App\Models\UsersModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class Contrasenia extends Controller
{
    public function showChangePasswordForm()
    {
        $idmall = auth()->user()->id_mall;
        $no_top = true;
        $js_content = [
            '0' => 'layouts.js.GeneralJS',
            '1' => 'layouts.js.PasswordJS',
        ];
        return view('layouts.password', compact(
            'idmall',
            'no_top',
            'js_content'
        ));
    }

    public function changePassword(Request $request)
    {

        if (!(Hash::check($request->get('actual_password'), Auth::user()->password))) {
            // The passwords matches
            session()->flash('error', ['error' => 'La contraseña actual es incorreta, por favor escribe la contraseña correcta.', 'error_title' => 'Gestión de Contraseña']);
            return redirect('changePassword');
        }

        if (strcmp($request->get('password'), $request->get('actual_password')) == 0) {
            //Current password and new password are same

            session()->flash('error', ['error' => 'La nueva contraseña no puede ser igual a la contraseña actual, reintentalo nuevamente.', 'error_title' => 'Gestión de Contraseña']);
            return redirect('changePassword');
        }
        if (strcmp($request->get('password'), $request->get('password_confirm')) != 0) {
            session()->flash('error', ['error' => 'Las contraseñas no coinciden. reintentalo nuevamente', 'error_title' => 'Gestión de Contraseña']);
            return redirect('changePassword');
        }
        $UserModel = new UsersModel();
        $id_usuario = auth()->user()->id;
        $user = $UserModel->updateUser(['password' => bcrypt($request->get('password')), 'updated_at' => GetTimeStamps()], $id_usuario);
        if ($user > 0) {
            session()->flash('success', ['success' => 'La contraseña se ha modificado con éxito.', 'success_title' => 'Gestión de Contraseña']);
            return redirect('changePassword');
        } else {
            session()->flash('error', ['error' => 'Contraseña No modificada, reintenta nuevamente', 'error_title' => 'Gestión de Contraseña']);
            return redirect('changePassword');
        }
    }
}
