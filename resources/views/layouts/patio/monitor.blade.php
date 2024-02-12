<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- MDB -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/4.4.0/mdb.min.css" rel="stylesheet" />

    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">

    <title>Monitor Dashboard Mall Vivo {{$nombreMall}} - Domotica Technology</title>

    {{-- Highcharts --}}
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://code.highcharts.com/modules/export-data.js"></script>
    <script src="https://code.highcharts.com/modules/accessibility.js"></script>
    <script src="https://code.highcharts.com/modules/annotations.js"></script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.2/css/all.min.css"
        integrity="sha512-1sCRPdkRXhBV2PBLUdRb4tMg1w2YPf37qatUFeS7zlBy7jJI8Lf4VHwWfZZfpXtYSLy85pkm9GaYVYMfw5BC1A=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <link href='https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css' rel='stylesheet'>
    <!-- Theme CSS -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
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

        a:hover {
            border-radius: 25px;
            {{ Route::currentRouteNamed('inicio') ? 'background-color: #7d95bf;' : '' }} {{ Route::currentRouteNamed('patio') ? 'background-color: #b39c8a;' : '' }} {{ Route::currentRouteNamed('cambiarContraseña') ? 'background-color: #bedaf3;' : '' }}
        }
    </style>
</head>

<body style="background-color: #E4E9F7;">
    <div class="border-0 pb-0">
        <a href="{{ route('inicio') }}" class="btn"><i class='bx bx-home-alt-2'></i></a>
    </div>
    <div class="container" style="align-content: center">
        <div class="linea"></div>
        <hr>
        <div class="border-0 pb-0">
            <div class="row align-items-center" style="">
                <h1 class="display-6 mb-0" style="text-align: center; margin-top: 25px;">Estadísticas del día</h1>
                <h1 class="display-6 mb-0" style="text-align: center; margin-top: 25px;">Patio de comidas Mall Vivo {{$nombreMall}}</h1>
            </div>
        </div>
        <div class="container" style="margin-top: 10%;">
            <div class="row">
                <div class="col-md-10 card shadow-sm aforo-dia-concentrado">
                    <div class="card-body">
                        <h3 class="display-3">Entradas</h3>
                        <br>
                        @foreach ($dHoy as $item)
                            <h1 class="display-1">{{ number_format($item->Entradas, 0, ',', '.') }}</h1>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        <script>
            setInterval("location.reload()", 60000);
        </script>
</body>

</html>
