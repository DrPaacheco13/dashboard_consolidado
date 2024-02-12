@php
    $idmall = auth()->user()->id_mall;
    $role_id = auth()->user()->role_id;
    $logo_mall = null;
    $nombreMall = null;
    $mall = GetMallsRegiones($idmall);
    // pre_die($mall);
@endphp
<nav class="main-header navbar navbar-expand navbar-white navbar-light" style="background-color: #2C3E50;">
    <ul class="navbar-nav {{ auth()->user()->temporal_user ? 'pl-1' : 'pl-5' }}">
        @if (auth()->user()->temporal_user)
            <li class="nav-item">
                <a class="nav-link text-white fs-6"
                    href="{{ route('gerentes/retorna', ['distribucion_id' => auth()->user()->distribucion_id, 'user_id_reference' => auth()->user()->user_id_reference]) }}"><i
                        class="fas fa-arrow-alt-circle-left"></i> Volver
                    a Administración Gerente |</a>
            </li>
        @endif
        @if ($role_id == 3)
            <li class="nav-item">
                <a class="nav-link text-white" href="{{ route('gerentes/administracion') }}">Administración</a>
            </li>
        @else
            @if ($mall->acceso_r0 == 1)
                <li class="nav-item">
                    <a class="nav-link text-white"
                        href="{{ route('acceso.r0', ['url' => $mall->url_region_r0]) }}">{{ $mall->acceso_r0_nombre }}</a>
                </li>
            @endif
            @if ($mall->acceso_r1 == true)
                <li class="nav-item">
                    <a class="nav-link text-white"
                        href="{{ route('acceso.r1', ['url' => $mall->url_region_r1]) }}">{{ $mall->acceso_r1_nombre }}</a>
                </li>
            @endif
            @if ($mall->acceso_r2 == 1)
                <li class="nav-item">
                    <a class="nav-link text-white"
                        href="{{ route('acceso.r2', ['url' => $mall->url_region_r2]) }}">{{ $mall->acceso_r2_nombre }}</a>
                </li>
            @endif
            @if ($mall->acceso_r3 == 1)
                <li class="nav-item">
                    <a class="nav-link text-white"
                        href="{{ route('acceso.r3', ['url' => $mall->url_region_r3]) }}">{{ $mall->acceso_r3_nombre }}</a>
                </li>
            @endif
            @if ($mall->acceso_tendencia == 1)
                <li class="nav-item">
                    <a class="nav-link text-white" href="{{ route('vehiculos_personas') }}">TENDENCIA</a>
                </li>
            @endif
            @if ($mall->acceso_vehicle == 1)
                <li class="nav-item">
                    <a class="nav-link text-white" href="{{ route('vehicle') }}">VEHICULOS</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white" href="{{ route('search') }}">BUSCAR PATENTES</a>
                </li>
            @endif
            {{-- @if ($idmall == 4)
                <li class="nav-item">
                    <a class="nav-link text-white" href="{{ route('acceso_exterior') }}">Acceso
                        Exterior</a>
                </li>
            @endif --}}

            {{-- @if ($mall->acceso_vehicle == true)
                <li class="nav-item">
                    <a class="nav-link active text-white" href="{{ route('vehicle') }}">Vehiculos</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white" href="{{ route('search') }}">Buscar Patentes</a>
                </li>
            @endif --}}
            @if ($mall->acceso_r0 == true || $mall->acceso_r1 == true || $mall->acceso_r2 == true || $mall->acceso_r3 == true)
                <li class="nav-item">
                    <a href="{{ route('searchDate') }}" class="nav-link text-white">Buscar por fecha</a>
                </li>
            @endif

            <li class="nav-item dropdown">
                <a id="dropdownMarketing" href="#" data-toggle="dropdown" aria-haspopup="true"
                    aria-expanded="false" class="nav-link dropdown-toggle text-white">Marketing</a>
                <ul aria-labelledby="dropdownMarketing" class="dropdown-menu border-0 shadow">
                    <li><a href="{{ route('marketing') }}" class="dropdown-item">Marketing Actual</a></li>
                    <li><a href="{{ route('marketing_yesterday') }}" class="dropdown-item">Marketing Dia Anterior</a>
                    </li>
                    @if ($idmall == 4)
                        <li><a href="{{ route('marketing_historico') }}" class="dropdown-item">Marketing Historico</a>
                        </li>
                    @endif
                </ul>
            </li>
            @if (auth()->user()->role_id == 1)
                <li class="nav-item dropdown">
                    <a id="dropdownMantenedor" href="#" data-toggle="dropdown" aria-haspopup="true"
                        aria-expanded="false" class="nav-link dropdown-toggle text-white">Mantenedores</a>
                    <ul aria-labelledby="dropdownMantenedor" class="dropdown-menu border-0 shadow">
                        <li><a href="{{ route('malls/listado') }}" class="dropdown-item">Mantenedor Mall</a></li>
                        <li><a href="{{ route('users/listado') }}" class="dropdown-item">Mantenedor Usuario</a></li>
                    </ul>
                </li>
            @endif
        @endif

        @if (!auth()->user()->temporal_user)
            <li class="nav-item dropdown">
                <a id="dropdownCuenta" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
                    class="nav-link dropdown-toggle text-white">Mi Cuenta</a>
                <ul aria-labelledby="dropdownCuenta" class="dropdown-menu border-0 shadow">
                    @if (auth()->user()->role_id == 1)
                        <li><a href="{{ route('miperfil') }}" class="dropdown-item">Mi Perfil</a></li>
                    @endif
                    <li><a href="{{ route('cambiarContraseña') }}" class="dropdown-item">Cambiar Contraseña</a></li>
                    <li><a href="{{ route('logoutSession') }}" class="dropdown-item">Cerrar Sesión</a></li>
                </ul>
            </li>
        @endif

    </ul>
    <ul class="navbar-nav ml-auto mr-5 mb-2 d-flex align-items-center">
        <li class="nav-item">
            @if (auth()->user()->role_id == 3)
                @if (auth()->user()->distribucion_id == 1)
                    <img width="150" height="70" src="{{ asset('img/logovivo.png') }}">
                @else
                    <img width="150" height="70" src="{{ asset('img/logoeu.png') }}">
                @endif
            @else
                <img height="80" width="150" src="{{ asset($mall->logo) }}">
            @endif
        </li>
    </ul>
</nav>

{{-- <nav hidden class="navbar navbar-expand-lg"
            style="
        {{ Route::currentRouteNamed('inicio') ? 'background-color: #4a6595' : '' }};
        {{ Route::currentRouteNamed('patio') ? 'background-color: rgb(146, 118, 96)' : '' }};
        {{ Route::currentRouteNamed('cambiarContraseña') ? 'background-color: #7EB6E9' : '' }};
        {{ Route::currentRouteNamed('vehiculos_personas') ? 'background-color: rgb(146, 118, 96)' : '' }};
        {{ Route::currentRouteNamed('acceso_exterior') ? 'background-color: rgb(146, 118, 96)' : '' }};
        {{ Route::currentRouteNamed('marketing') ? 'background-color: #EBB211' : '' }};
        {{ Route::currentRouteNamed('marketing_historico') ? 'background-color: #ebb211' : '' }};
        {{ Route::currentRouteNamed('marketing_yesterday') ? 'background-color: #EBB211' : '' }};
        {{ Route::currentRouteNamed('search') ? 'background-color: #00a429;' : '' }};
        {{ Route::currentRouteNamed('vehicle') ? 'background-color: #009925' : '' }};
        {{ Route::currentRouteNamed('searchDate') ? 'background-color: #7d95bf' : '' }};">
            <div class="container-fluid">
                <a class="navbar-brand" href="{{ route('inicio') }}">Domotica Technology</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse justify-content-end" id="navbarSupportedContent">
                    <ul class="navbar-nav me-5">
                        <li class="nav-item" style="width: 170px; text-align: center">
                            <a class="nav-link link_nav" style="color: white;" aria-current="page"
                                href="{{ route('inicio') }}">Acceso General</a>
                        </li>
                        @if ($idmall == 1)
                            <li class="nav-item" style="width: 170px; text-align: center">
                                <a class="nav-link link_nav" style="color: white;" aria-current="page"
                                    href="{{ route('patio') }}">Patio de Comidas</a>
                            </li>
                        @endif
                        @if ($idmall == 3)
                            <li class="nav-item" style="width: 170px; text-align: center">
                                <a class="nav-link link_nav" style="color: white;" aria-current="page"
                                    href="{{ route('vehiculos_personas') }}">Tendencia Clientes</a>
                            </li>
                        @endif
                        @if ($idmall == 4)
                            <li class="nav-item" style="width: 170px; text-align: center">
                                <a class="nav-link link_nav" style="color: white;" aria-current="page"
                                    href="{{ route('acceso_exterior') }}">Acceso Exterior</a>
                            </li>
                        @endif
                        <div class="dropdown">
                            <a class="nav-link dropdown-toggle link_nav"
                                style="width: 170px; text-align: center; color: white;" role="button"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                Marketing
                            </a>
                            <div class="dropdown-content" style="border-radius: 25px;">
                                <li>
                                    <a class="dropdown-item link_nav" href="{{ route('marketing') }}">
                                        Marketing día actual
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item link_nav" href="{{ route('marketing_yesterday') }}">
                                        Marketing día anterior
                                    </a>
                                </li>
                                @if ($idmall == 4)
                                    <li>
                                        <a class="dropdown-item link_nav" href="{{ route('marketing_historico') }}">
                                            Marketing Histórico
                                        </a>
                                    </li>
                                @endif

                            </div>
                        </div>
                        @if ($idmall == 3)
                            <li class="nav-item" style="width: 170px; text-align: center">
                                <a class="nav-link link_nav" style="color: white;" aria-current="page"
                                    href="{{ route('vehicle') }}">Vehículos</a>
                            </li>
                            @if ($_SERVER['REQUEST_URI'] == '/vehicle')
                                <li class="nav-item" style="width: 170px; text-align: center">
                                    <a class="nav-link link_nav" style="color: white;" aria-current="page"
                                        href="{{ route('search') }}">Buscar Patentes</a>
                                </li>
                            @endif
                        @endif
                        <li class="nav-item" style="width: 170px; text-align: center">
                            <a href="{{ route('searchDate') }}" style="color: white;" aria-current="page"
                                class="nav-link link_nav">Buscar por fecha</a>
                        </li>

                        @if (auth()->user()->role_id == 1)
                            <div class="dropdown">
                                <a class="nav-link dropdown-toggle link_nav"
                                    style="width: 170px; text-align: center; color: white;" role="button"
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                    MANTENEDORES
                                </a>
                                <div class="dropdown-content" style="border-radius: 25px;">
                                    <li>
                                        <a class="dropdown-item link_nav" href="{{ route('malls/listado') }}">
                                            Listado de Malls
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item link_nav" href="{{ route('users/listado') }}">
                                            Listado de Usuarios
                                        </a>
                                    </li>
                                </div>
                            </div>
                        @endif

                        <div class="dropdown">
                            <a class="nav-link dropdown-toggle link_nav"
                                style="width: 170px; text-align: center; color: white;" role="button"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                {{ Auth::user()->name }}
                            </a>
                            <div class="dropdown-content" style="border-radius: 25px;">
                                <li>
                                    <a class="dropdown-item link_nav" href="{{ route('cambiarContraseña') }}">
                                        Cambiar Contraseña
                                    </a>
                                </li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li>
                                    <a class="dropdown-item link_nav" href="{{ route('login') }}"
                                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                        Cerrar Sesión
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                        class="d-none">
                                        @csrf
                                    </form>
                                </li>
                            </div>
                        </div>
                    </ul>
                </div>
            </div>
        </nav> --}}
