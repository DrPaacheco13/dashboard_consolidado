<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Usuarios</title>
    <!-- CSS only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <!-- JavaScript Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous">
    </script>
    <script src="https://kit.fontawesome.com/29ee9b9319.js" crossorigin="anonymous"></script>
    <script src="https://unpkg.com/boxicons@2.1.4/dist/boxicons.js"></script>

    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.css">
  
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.js"></script>

    <link rel="stylesheet" href="{{asset('css/styles.css')}}">
    @vite('resources/css/app.css')
    @livewireStyles
</head>

<body style="background-color: rgb(228, 233, 247)">
    <nav class="navbar bg-light">
        <form class="container-fluid justify-content-center">
          <a href="/home" class="btn btn-outline-primary me-2" type="button">Inicio</a>
          <a href="/usuarios" class="btn btn-outline-primary me-2" type="button">Usuarios</a>
          <a href="/gestion_mall" class="btn btn-outline-primary me-2" type="button">Mall</a>
          <a href="/users" class="btn btn-outline-primary me-2" type="button">Roles</a>
        </form>
      </nav>
    <div class="container card" style="margin-top: 50px;">
        @livewire('usuarios')
    </div>
    @livewireScripts
</body>

</html>
