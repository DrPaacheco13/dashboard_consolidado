<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    protected function authenticated($request, $user)
    {
        // Redirigir según el rol del usuario
        $mall = GetRowByWhere('malls', ['id' => $user->id_mall]);
        $session = session();
        $session->put('user_data', $user);
        // pre_die("das");
        if ($user->role_id == 3) {
            return redirect()->route('gerentes/administracion');
        } elseif ($mall->acceso_r0 == true) {
            $view_r0 = GetRowByWhere('view_region_r0', ['mall_id' => $mall->id]);
            return redirect()->route('acceso.r0', ['url' => $view_r0->url_region]);
        } elseif ($mall->acceso_r1 == true) {
            $view_r1 = GetRowByWhere('view_region_r1', ['mall_id' => $mall->id]);
            return redirect()->route('acceso.r1', ['url' => $view_r1->url_region]);
        } {
            return redirect()->route('vehicle');
        }
    }
}
