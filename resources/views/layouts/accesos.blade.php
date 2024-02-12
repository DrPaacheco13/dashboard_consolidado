<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- Font Awesome --}}

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet" />
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap" rel="stylesheet" />
    <!-- MDB -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/4.4.0/mdb.min.css" rel="stylesheet" />

    <script src="https://kit.fontawesome.com/29dfe7f8a8.js" crossorigin="anonymous"></script>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">

    <title>Accesos - Mall Vivo {{$nombreMall}}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="https://fonts.google.com/">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    {{-- Highcharts --}}
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://code.highcharts.com/modules/export-data.js"></script>
    <script src="https://code.highcharts.com/modules/accessibility.js"></script>
    <script src="https://code.highcharts.com/modules/annotations.js"></script>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Poppins:200,300,400,600,700,800" rel="stylesheet">

    {{-- Boxicons CDN --}}
    <script defer src="https://use.fontawesome.com/releases/v5.15.4/js/all.js"
        integrity="sha384-rOA1PnstxnOBLzCLMcre8ybwbTmemjzdNlILg8O7z1lUkLXozs4DHonlDtnE7fpc" crossorigin="anonymous">
    </script>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.2/css/all.min.css" integrity="sha512-1sCRPdkRXhBV2PBLUdRb4tMg1w2YPf37qatUFeS7zlBy7jJI8Lf4VHwWfZZfpXtYSLy85pkm9GaYVYMfw5BC1A==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <link href='https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css' rel='stylesheet'>

    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
    <!-- Theme CSS -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    <style>
        .img-logo{
            max-width: 100%;
            max-height: 100%;
        }
        .logo-content{
            height: 100px;
            margin-left: 10px;
            margin-top: 10px
        }
        .texto-ini{
            max-width: 100%;
            max-height: 100%;
        }
        .texto-box{
            height: 100%;
        }
    </style>
</head>

<body style="background-color: #E4E9F7;">
    <div class="border-0 pb-0">
        <a href="{{route('inicio')}}" class="btn"><i class='bx bx-home-alt-2'></i></a>
        <div class="row align-items-center" style="">
            <h1 class="display-4 mb-0" style="text-align: center; margin-top: 25px;">Domotica Technology</h1>
        </div>
    </div>
    <div class="container" style="align-content: center">
        <div class="linea"></div>
<hr>
        <div class="border-0 pb-0">
            <div class="row align-items-center" style="">
                <h1 class="display-6 mb-0" style="text-align: center; margin-top: 25px;">Estadísticas del día</h1>
                <h1 class="display-6 mb-0" style="text-align: center; margin-top: 25px;">Flujos Mall Vivo {{$nombreMall}}</h1>
            </div>
        </div>
        <div class="container" style="margin-top: 10%;">
            <div class="row">
                <div class="col-md-5 card shadow-sm aforo-dia-concentrado">
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