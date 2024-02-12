<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <link rel="icon" href="{{ asset('img/logo.svg') }}">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <!-- Extra details for Live View on GitHub Pages -->
    <title>Login - DmTech</title>
    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no'
        name='viewport' />
    <!--     Fonts and icons     -->
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700,200" rel="stylesheet" />
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css"
        integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
    <!-- CSS Files -->
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('css/now-ui-dashboard.css?v=1.3.0') }}" rel="stylesheet" />
    <!-- CSS Just for demo purpose, don't include it in your project -->
    <link rel="stylesheet" href="{{ asset('css/particulas.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">

</head>

<body class="{{ $class ?? '' }}">

    <!-- particles.js container -->
    <div id="particles-js"></div> <!-- stats - count particles -->
    <div class="count-particles"> <span class="js-count-particles">--</span> particles </div>

    <div class="wrapper">
        @auth
            @include('layouts.page_template.auth')
        @endauth
        @guest
            @include('layouts.page_template.guest')
        @endguest
    </div>
    <!--   Core JS Files   -->
    <script src="{{ asset('js/core/jquery.min.js') }}"></script>
    <script src="{{ asset('js/core/popper.min.js') }}"></script>
    <script src="{{ asset('js/plugins/perfect-scrollbar.jquery.min.js') }}"></script>
    <!--  Notifications Plugin    -->
    <script src="{{ asset('js/plugins/bootstrap-notify.js') }}"></script>
    @stack('js')
    <!-- particles.js container -->
    <!-- particles.js lib - https://github.com/VincentGarreau/particles.js -->
    <script src="https://cdn.jsdelivr.net/particles.js/2.0.0/particles.min.js"></script> <!-- stats.js lib -->
    <script src="https://threejs.org/examples/js/libs/stats.min.js"></script>
    <script src="{{ asset('js/particulas.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>

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

    @include('auth.loginJS')
</body>

</html>
