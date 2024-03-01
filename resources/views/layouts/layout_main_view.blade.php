<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- MDB -->

    {{-- <link rel="stylesheet" href="{{ asset('css/styles.css') }}"> --}}
    <link rel="shortcut icon" href="{{ asset('img/favicon.png') }}">

    <title>{{ !empty($nombre_mall) ? $nombre_mall . (!empty($acceso_mall) ? ' - ' . $acceso_mall : '') : 'MALL' }}
    </title>

    {{-- Highcharts --}}
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://code.highcharts.com/modules/export-data.js"></script>
    <script src="https://code.highcharts.com/modules/accessibility.js"></script>
    <script src="https://code.highcharts.com/modules/annotations.js"></script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.2/css/all.min.css"
        integrity="sha512-1sCRPdkRXhBV2PBLUdRb4tMg1w2YPf37qatUFeS7zlBy7jJI8Lf4VHwWfZZfpXtYSLy85pkm9GaYVYMfw5BC1A=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    {{-- <link href='https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css' rel='stylesheet'> --}}

    <link href='https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css' rel='stylesheet'>
    <!-- Theme CSS -->

    {{-- <link href="{{ asset('css/adminlte.min.css') }}" rel='stylesheet'> --}}
    {{-- <link href="{{ asset('dist/css/adminlte.min.css') }}" rel='stylesheet'> --}}
    {{-- <link href="{{ asset('css/adminlte.min.css') }}" rel='stylesheet'> --}} <!--ESTE DESCOMMENTAR-->
    {{-- <link href="{{ asset('css/tab-style.css') }}" rel='stylesheet'> --}}

    @vite([
        'resources/sass/app.scss',
        'resources/js/app.js',
        // 'resources/plugins/fontawesome-free/css/all.min.css',
        'resources/dist/css/adminlte.min.css',
        // 'resources/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css',
        // 'resources/plugins/datatables-responsive/css/responsive.bootstrap4.min.css',
        // 'resources/plugins/datatables-buttons/css/buttons.bootstrap4.min.css'
    ])
    <!-- CSS only -->

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.js"
        integrity="sha512-+k1pnlgt4F1H8L7t3z95o3/KO+o78INEcXTbnoJQ/F2VqDVhWoaiVml/OEHv9HsVgxUaVW+IbiZPUJQfF/YxZw=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"
        integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <style>
        .img-logo {
            max-width: 100%;
            max-height: 100%;
        }

        .logo-content {
            height: 100px;
            margin-left: 10px;
            margin-top: 10px
        }

        .texto-ini {
            max-width: 100%;
            max-height: 100%;
        }

        .texto-box {
            height: 100%;
        }

        .link_nav:hover {
            border-radius: 25px;
            {{ Route::currentRouteNamed('searchDate') ? 'background-color: #acbcd7;' : '' }} {{ Route::currentRouteNamed('marketing') ? 'background-color: #f4d064;' : '' }} {{ Route::currentRouteNamed('marketing_yesterday') ? 'background-color: #f4d064;' : '' }} {{ Route::currentRouteNamed('inicio') ? 'background-color: #7d95bf;' : '' }} {{ Route::currentRouteNamed('vehicle') ? 'background-color: #00a429;' : '' }} {{ Route::currentRouteNamed('search') ? 'background-color: #00df38;' : '' }} {{ Route::currentRouteNamed('patio') ? 'background-color: #b39c8a;' : '' }} {{ Route::currentRouteNamed('cambiarContraseña') ? 'background-color: #bedaf3;' : '' }}
        }

        .selected_fila {
            background-color: #4a6595 !important;
            color: #fff !important;
        }

        [class*=sidebar-dark-] {
            background-color: #4a6595 !important;
        }
        .nav-sidebar .nav-link p {
            color: white;
        }
        .nav-sidebar .nav-link.active p {
            color: black;
        }
    </style>
</head>
{{-- <body class="hold-transition sidebar-mini layout-fixed"> --}}

<body class="hold-transition sidebar-mini" style="background-color: #4a6595 ;">
    <div id="app" class="wrapper">

        @auth
            @include('layouts.topnav_view')
            @include('layouts.sidenav_view')
            <div class="content-wrapper">
                @include('layouts.topnav')

                @yield('content')
            </div>
            @include('layouts.footer')
        @endauth
        @yield('content_mant')

        @if (empty($valida_reload))
            <script>
                setInterval("location.reload()", 60000);
            </script>
        @endif

        <script>
            if (window.history.replaceState) {
                window.history.replaceState(null, null, window.location.href);
            }
        </script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
        {{-- <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/4.4.0/mdb.min.js"></script> --}}
        <!-- JavaScript Bundle with Popper -->
        {{-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous">
        </script> --}}
        {{-- 
        @vite([
            // 'resources/dist/js/adminlte.min.js',
            // 'resources/plugins/bootstrap/js/bootstrap.bundle.min.js',
            // 'resources/plugins/datatables/jquery.dataTables.min.js',
            // 'resources/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js',
            // 'resources/plugins/datatables-responsive/js/dataTables.responsive.min.js',
            // 'resources/plugins/datatables-responsive/js/responsive.bootstrap4.min.js',
            // 'resources/plugins/datatables-buttons/js/dataTables.buttons.min.js',
        ]); --}}
        <script src='{{ asset('js/adminlte.min.js') }}'></script>
        <script src='{{ asset('js/bootstrap.bundle.min.js') }}'></script>
        <script src='{{ asset('js/jquery.dataTables.min.js') }}'></script>
        <script src='{{ asset('js/dataTables.bootstrap4.min.js') }}'></script>
        <script src='{{ asset('js/dataTables.buttons.min.js') }}'></script>
        <script>
            function mostrarMensajeCarga() {
                Swal.fire({
                    title: 'Cargando...',
                    allowOutsideClick: false,
                    onBeforeOpen: () => {
                        Swal.showLoading();
                    },
                });
            }
            toastr.options = {
                "closeButton": true,
                "progressBar": true,
            }
        </script>

        @if (session('success'))
            <script>
                toastr.success(`{{ session('success.success') }}`, `{{ session('success.success_title') }}`);
            </script>
        @endif

        @if (session('warning'))
            <script>
                toastr.warning(`{{ session('warning.warning') }}`, `{{ session('warning.warning_title') }}`);
            </script>
        @endif

        @if (session('error'))
            <script>
                toastr.error(`{{ session('error.error') }}`, `{{ session('error.error_title') }}`);
            </script>
        @endif

    </div>


    <!-- MDB -->



    @if (!empty($js_content))
        @foreach ($js_content as $js)
            @include($js)
        @endforeach
    @endif

</body>

</html>
