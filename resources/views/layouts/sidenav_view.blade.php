@php
    $idmall = auth()->user()->id_mall;
    $role_id = auth()->user()->role_id;
    $mall = GetMallsRegiones($idmall);
@endphp
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="../../home" class="brand-link">
        <span class="brand-text font-weight-light">
            <img src="{{ asset('img/logoDMTECHw.png') }}" alt="AdminLTE Logo" class="w-100" style="opacity: .8">
        </span>
    </a>
    <br>

    <!-- Sidebar -->
    <div class="sidebar">

        <!-- SidebarSearch Form -->
        <div class="form-inline">
            <div class="input-group" data-widget="sidebar-search">
                <input class="form-control form-control-sidebar" type="search" placeholder="Search"
                    aria-label="Search">
                <div class="input-group-append">
                    <button class="btn btn-sidebar">
                        <i class="fas fa-search fa-fw"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class with font-awesome or any other icon font library -->
                @if (!empty($role_id) && $role_id == 3)
                    <li class="nav-item">
                        <a href="{{ route('gerentes/administracion') }}"
                            class="nav-link {{ !empty($nav_acceso_r0) ? 'active' : '' }}">
                            <i class="fas fa-universal-access"></i>
                            <p>
                                Administración
                            </p>
                        </a>
                    </li>
                @else
                    @if ($mall->acceso_r0 == 1)
                        <li class="nav-item">
                            <a href="{{ route('acceso.r0', ['url' => $mall->url_region_r0]) }}"
                                class="nav-link {{ !empty($nav_acceso_r0) ? 'active' : '' }}">
                                <i class="fas fa-universal-access"></i>
                                <p>
                                    {{ $mall->acceso_r0_nombre }}
                                </p>
                            </a>
                        </li>
                    @endif
                    @if ($mall->acceso_r1 == 1)
                        <li class="nav-item">
                            <a href="{{ route('acceso.r1', ['url' => $mall->url_region_r1]) }}"
                                class="nav-link {{ !empty($nav_acceso_r1) ? 'active' : '' }}">
                                <i class="fas fa-universal-access"></i>
                                <p>
                                    {{ $mall->acceso_r1_nombre }}
                                </p>
                            </a>
                        </li>
                    @endif
                    @if ($mall->acceso_r2 == 1)
                        <li class="nav-item">
                            <a href="{{ route('acceso.r2', ['url' => $mall->url_region_r2]) }}"
                                class="nav-link {{ !empty($nav_acceso_r2) ? 'active' : '' }}">
                                <i class="fas fa-universal-access"></i>
                                <p>
                                    {{ $mall->acceso_r2_nombre }}
                                </p>
                            </a>
                        </li>
                    @endif
                    @if ($mall->acceso_r3 == 1)
                        <li class="nav-item">
                            <a href="{{ route('acceso.r3', ['url' => $mall->url_region_r3]) }}"
                                class="nav-link {{ !empty($nav_acceso_r3) ? 'active' : '' }}">
                                <i class="fas fa-universal-access"></i>
                                <p>
                                    {{ $mall->acceso_r3_nombre }}
                                </p>
                            </a>
                        </li>
                    @endif
                    @if ($mall->acceso_vehicle == 1)
                        <li class="nav-item">
                            <a href="{{ route('vehicle') }}"
                                class="nav-link {{ !empty($nav_acceso_vehicle) ? 'active' : '' }}">
                                <i class="fas fa-car-alt"></i>
                                <p>
                                    VEHICULOS
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('search') }}"
                                class="nav-link {{ !empty($nav_acceso_search_vehicle) ? 'active' : '' }}">
                                <i class="fas fa-car-alt"></i>
                                <p>
                                    BUSCAR PATENTES
                                </p>
                            </a>
                        </li>
                    @endif
                    @if ($mall->acceso_tendencia == 1)
                        <li class="nav-item">
                            <a href="{{ route('vehiculos_personas') }}"
                                class="nav-link {{ !empty($nav_acceso_tendencia) ? 'active' : '' }}">
                                <i class="fas fa-universal-access"></i>
                                <p>
                                    TENDENCIA CLIENTES
                                </p>
                            </a>
                        </li>
                    @endif
                    @if ($mall->acceso_r0 == true || $mall->acceso_r1 == true || $mall->acceso_r2 == true || $mall->acceso_r3 == true)
                        <li class="nav-item @if (!empty($nav_buscar_fechas)) active @endif">
                            <a href="{{ route('searchDate') }}" class="nav-link">
                                <i class="fas fa-calendar-alt"></i>
                                <p>
                                    BUSCAR POR FECHAS
                                </p>
                            </a>
                        </li>
                    @endif

                    <li class="nav-item @if (!empty($nav_marketing)) menu-open @endif">
                        <a href="#"
                            class="nav-link d-flex justifu-content-center items-align-center @if (!empty($nav_marketing)) active @endif">
                            <i class="fas fa-poll pr-2 pt-1"></i>
                            <p>
                                MARKETING
                                <i class="fas fa-angle-left right" style="font-size: 20px; margin-top: 3px"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('marketing') }}"
                                    class="nav-link @if (!empty($nav_marketing_dia)) active @endif">
                                    <i class="nav-icon fas fa-poll"></i>
                                    <p>Marketing del Día</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('marketing_yesterday') }}"
                                    class="nav-link @if (!empty($nav_marketing_anterior)) active @endif">
                                    <i class="nav-icon fas fa-poll"></i>
                                    <p>Marketing Día Anterior</p>
                                </a>
                            </li>
                            @if ($mall->id == 4)
                                <li class="nav-item">
                                    <a href="{{ route('marketing_historico') }}"
                                        class="nav-link @if (!empty($nav_historico)) active @endif">
                                        <i class="nav-icon fas fa-poll"></i>
                                        <p>Marketing Historico</p>
                                    </a>
                                </li>
                            @endif
                        </ul>
                    </li>
                    @if ($role_id == 1)
                        <li class="nav-item @if (!empty($nav_mantenedor_users)) menu-open @endif">
                            <a href="#"
                                class="nav-link d-flex justifu-content-center items-align-center @if (!empty($nav_mantenedor_users)) active @endif">
                                <i class="far fa-building pr-2 pt-1"></i>
                                <p>
                                    MANTENEDOR USUARIOS
                                    <i class="fas fa-angle-left right" style="font-size: 20px; margin-top: 3px"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ route('users/nuevo') }}"
                                        class="nav-link @if (!empty($nav_nuevo_user)) active @endif">
                                        <i class="nav-icon fas fa-plus-circle"></i>
                                        <p>Nuevo Usuario</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('users/listado') }}"
                                        class="nav-link @if (!empty($nav_listado_users)) active @endif">
                                        <i class="nav-icon fas fa-list "></i>
                                        <p>Listado Usuarios</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item @if (!empty($nav_mantenedor_malls)) menu-open @endif">
                            <a href="#"
                                class="nav-link d-flex justifu-content-center items-align-center @if (!empty($nav_mantenedor_malls)) active @endif">
                                <i class="far fa-building pr-2 pt-1"></i>
                                <p>
                                    MANTENEDOR MALL
                                    <i class="fas fa-angle-left right" style="font-size: 20px; margin-top: 3px"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ route('malls/nuevo') }}"
                                        class="nav-link @if (!empty($nav_nuevo_mall)) active @endif">
                                        <i class="nav-icon fas fa-plus-circle"></i>
                                        <p>Nuevo Mall</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('malls/listado') }}"
                                        class="nav-link @if (!empty($nav_listado_malls)) active @endif">
                                        <i class="nav-icon fas fa-list "></i>
                                        <p>Listado Malls</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                    @endif
                @endif
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
