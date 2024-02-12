       <!DOCTYPE html>
       <html lang="es">

       <head>
           <meta charset="UTF-8">
           <meta name="viewport" content="width=device-width, initial-scale=1.0">
           <link rel="preconnect" href="https://fonts.googleapis.com">
           <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
           <link href="https://fonts.googleapis.com/css2?family=Red+Hat+Display:wght@300&display=swap" rel="stylesheet">
           <style>
               * ::after ::before {
                   box-sizing: border-box;
               }

               * {
                   font-family: 'Red Hat Display', sans-serif;
               }

               *,
               html {
                   padding: 0%;
                   margin: 0%;
               }

               body {
                   display: block;
                   margin: 0%;
                   padding: 0%;
                   height: 720px;
                   font-size: 18.5px;
                   font-family: 'Red Hat Display', sans-serif;
               }

               .wrapper {
                   display: grid;
                   margin: 0%;
                   padding: 0%;
                   top: 0px;
                   height: max-content;
                   background-color: aliceblue;
                   justify-items: center;
               }

               .card {
                   width: 33.3333333%;
                   display: flex;
                   flex-direction: column;
                   align-items: center;
                   background-color: rgb(255, 255, 255);
                   margin: 2%;
                   border-radius: 10px;
                   transition-duration: 1s;
                   transition-timing-function: cubic-bezier(0.26, 0.5, 0.5, 0.87);
                   transition-delay: 10ms;
                   transition-property: all;
               }

               .card:hover {
                   transform: scale(101%);
                   box-shadow: 1px 1px 20px 20px #67858d4c;
               }

               .card * img {
                   padding: 0%;
                   margin: 0%;
                   border-radius: 5px;
               }

               .card>div {
                   margin: 0%;
                   width: 100%;
               }

               .card-header {
                   border-top-left-radius: 7px;
                   border-top-right-radius: 7px;
               }

               .card-header span {
                   align-self: center;
                   text-align: center;
                   font-size: 38px;
               }

               .card-body {
                   text-align: justify;
               }

               .card-body span:nth-child(2) {
                   display: flex;
                   flex-direction: column;
               }

               .card-body span:nth-child(2) .action {
                   border-radius: 5px;
                   width: 20%;
                   background-color: rgb(19, 55, 141);
                   color: aliceblue;
                   text-decoration: none;
                   padding: 3%;
                   margin-top: 5%;
                   align-self: center;
                   text-align: center;
                   font-weight: 500;
               }

               .action:hover {
                   background-color: red;
               }

               .card-header,
               .card-body,
               .card-footer {
                   width: 100%;
                   background-color: rgb(255, 255, 255);
                   padding: 5.6% !important;
               }

               .card-footer {
                   border-bottom-left-radius: 5px;
                   border-bottom-right-radius: 5px;
                   border-bottom: 3px solid black;
               }

               .card-footer span {
                   float: right;
                   font-style: italic;
                   color: rgb(16, 53, 86);
                   align-items: center;
               }

               img {
                   display: block;
                   margin: auto;
               }

               .page_break {
                   page-break-before: always;
               }

               table,
               th,
               td {
                   border: 1px solid;
               }

               table {
                   border-collapse: collapse;
                   font-family: 'Red Hat Display', sans-serif;
               }

               table>tbody>tr>td {
                   text-align: center
               }

               table>thead>tr>th {
                   background-color: #4a6595;
                   text-align: center;
               }

               th {
                   color: #fff;
               }

               .div-contenedor-de-imagenes img {
                   margin: 0 10px;
               }
           </style>
           <link rel="stylesheet"
               href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css"integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N"
               crossorigin="anonymous">
           <title>{{ $nombreMall }}</title>
           <link rel="stylesheet" href="css/styles.css">
       </head>

       <body>
           <div class="row div-contenedor-de-imagenes"
               style="background-color: #E4E9F7; margin-left: 1cm; margin-top: 1cm; margin-right: 1cm; height: 120px;">
               <img style="margin-top: 15px; margin-bottom: 10px; margin-left: 80px;" src="img/logoDMTECH.png"
                   width="250px" alt="Imagen" srcset="">
               <img style="margin-top: 25px; margin-bottom: 10px; margin-left: 100px;" src="{{ asset($logo_mall) }}"
                   width="200px" alt="Imagen" srcset="">
           </div>
           &nbsp;
           <h2 style="font-size: 25px; text-align: center;">{{ $nombreMall }}</h2>

           @if (empty($fecha2))
               <h2 style="font-size: 15px; text-align: center;">Reporte de datos fecha {{ $newDate }}</h2>
           @else
               <h2 style="font-family: 'Red Hat Display', sans-serif; font-size: 15px; text-align: center;">Reporte de
                   datos
                   desde {{ $newDate }} hasta
                   {{ $newDate2 }}</h2>
           @endif
           <hr>
           {{-- --------------------------------------------------------------------------------------------------------------------------------------------------------------------- --}}
           <div class="container">
               <h2 style="font-size: 25px; text-align: center; white-space: pre;">Comportamiento de visitas</h2>
               <div class="row" style="border-radius: 10px">
                   <div class="mx-auto">
                       <div class="row justify-content-around">
                           <div class="col-md-11 card" style="float: left">
                               <h3 class="display-5" style="font-size: 25px; text-align: center;">Ingresos clientes
                               </h3>
                               <h1 class="display-6" style="text-align: center;">
                                   @if (empty($fecha) && empty($fecha2))
                                       0
                                   @else
                                       {{ formatear_miles($datos->tEntrada) }}
                                   @endif
                               </h1>
                           </div>
                       </div>
                   </div>
               </div>
           </div>

           <br>
           &nbsp;

           <div style="margin-top: 2cm;">
               <br>
               <div class="container card" style="width=696px;">
                   <img src="https://quickchart.io/chart?c={type:'line',
                            data:{labels:['08:00','09:00','10:00','11:00', '12:00', '13:00', '14:00', '15:00', '16:00', '17:00', '18:00', '19:00', '20:00', '21:00', '22:00', '23:00']
                            , datasets:[{label:'Ingresos',
                            data:[@foreach ($datos_segmentados as $key => $value) {{ is_numeric($value) ? $value . ',' : '' }} @endforeach], fill: false}]}}"
                       alt="" width="700px" height="300px">
               </div>
           </div>
           {{-- --------------------------------------------------------------------------------------------------------------------------------------------------------------------- --}}
           <div class="page_break">
               @if (empty($fecha2))
                   <div>
                       <h3 style="font-size: 20px; text-align: center; white-space: pre; margin-top: 1cm;">
                           Comportamiento de
                           entradas por día</h3>
                   </div>
               @else
                   <h3 style="font-size: 20px; text-align: center; white-space: pre; margin-top: 1cm;">Comportamiento de
                       entradas por día</h3>
                   <div class="container card">
                       <img src="https://quickchart.io/chart?c={type:'bar',
                                data:{labels:[@foreach ($graficoPorDia as $item) '{{ $item->date }}', @endforeach]
                                , datasets:[{label:'',
                                data:[@foreach ($graficoPorDia as $item) {{ $item->Entradas }}, @endforeach], fill: false}]}}"
                           alt="" width="700px" height="300px">
                   </div>
                   <br>
               @endif
               @if (empty($fecha) && empty($fecha2))
                   <div>
                       <table style="margin-left: 1cm; margin-right: 1cm; margin: 0 auto;">
                           <thead>
                               <tr>
                                   <th style="width: 350px;" scope="col">Fecha</th>
                                   <th style="width: 350px;" scope="col">Entradas</th>
                               </tr>
                           </thead>
                           <tbody>
                               <tr>
                                   <td></td>
                                   <td></td>
                               </tr>
                           </tbody>
                       </table>
                   </div>
               @else
                   <div>
                       <table style="margin-left: 1cm; margin-right: 1cm; margin: 0 auto;">
                           <thead>
                               <tr>
                                   <th style="width: 350px;" scope="col">Fecha</th>
                                   <th style="width: 350px;" scope="col">Entradas</th>
                               </tr>
                           </thead>
                           <tbody>
                               @foreach ($graficoPorDia as $item)
                                   <tr>
                                       <td>
                                           <h6>{{ $item->date }}</h6>
                                       </td>
                                       <td>
                                           <h6>{{ number_format($item->Entradas, 0, ',', '.') }}</h6>
                                       </td>
                                   </tr>
                               @endforeach
                           </tbody>
                       </table>
                   </div>
               @endif
           </div>
           {{-- --------------------------------------------------------------------------------------------------------------------------------------------------------------------- --}}
           @if ($idmall != 3)

               <div class="page_break" style="margin-top: 1cm;">
                   <h3 style="font-size: 20px; text-align: center; white-space: pre; margin-top: 1cm;">Comportamiento de
                       entradas
                       por cámaras</h3>
                   <div class="card"
                       style="width: 715px; align-content: center; margin-top: 1cm; margin-left: 1cm; margin-right: 1cm;">
                       <img src="https://quickchart.io/chart?c={type:'bar',
                        data:{labels:[@foreach ($graficoPorCamara as $item) '{{ $item->nombre }}', @endforeach]
                        , datasets:[{label:'Entradas por cámara',
                        data:[@foreach ($graficoPorCamara as $item) {{ $item->Entradas }}, @endforeach], fill: false}]}}"
                           alt="" width="700px" height="300px">
                   </div>
                   &nbsp;
                   <table style="margin-left: 1cm; margin-right: 1cm; margin: 0 auto;">
                       <thead>
                           <tr>
                               <th class="" style="width: 350px;" scope="col">Nombre Cámara</th>
                               <th style="width: 350px;" scope="col">Entradas</th>
                           </tr>
                       </thead>
                       <tbody>
                           @foreach ($graficoPorCamara as $item)
                               <tr>
                                   <td style="text-align: left;">
                                       <h6 style="margin-left: 10px;">{{ $item->nombre }}</h6>
                                   </td>
                                   <td>
                                       <h6>{{ number_format($item->Entradas, 0, ',', '.') }}</h6>
                                   </td>
                               </tr>
                           @endforeach
                       </tbody>
                   </table>
               </div>
           @endif

           {{-- --------------------------------------------------------------------------------------------------------------------------------------------------------------------- --}}
           <div class="page_break">
               <h3 style="font-size: 20px; text-align: center; white-space: pre; margin-top: 1cm;">Comportamiento de
                   entradas
                   por segmento</h3>
               @if (empty($fecha) && empty($fecha2))
                   <div>
                       <table style="margin-left: 1cm; margin-right: 1cm; margin: 0 auto;">
                           <thead>
                               <tr>
                                   <th style="width: 150px;" scope="col">Segmento</th>
                                   <th style="width: 150px;" scope="col">Entradas</th>
                               </tr>
                           </thead>
                           <tbody>
                               <tr>
                                   <th scope="row">08:00</th>
                               </tr>
                               <tr>
                                   <th scope="row">09:00</th>
                               </tr>
                               <tr>
                                   <th scope="row">10:00</th>
                               </tr>
                               <tr>
                                   <th scope="row">11:00</th>
                               </tr>
                               <tr>
                                   <th scope="row">12:00</th>
                               </tr>
                               <tr>
                                   <th scope="row">13:00</th>
                               </tr>
                               <tr>
                                   <th scope="row">14:00</th>
                               </tr>
                               <tr>
                                   <th scope="row">15:00</th>
                               </tr>
                               <tr>
                                   <th scope="row">16:00</th>
                               </tr>
                               <tr>
                                   <th scope="row">17:00</th>
                               </tr>
                               <tr>
                                   <th scope="row">18:00</th>
                               </tr>
                               <tr>
                                   <th scope="row">19:00</th>
                               </tr>
                               <tr>
                                   <th scope="row">20:00</th>
                               </tr>
                               <tr>
                                   <th scope="row">21:00</th>
                               </tr>
                               <tr>
                                   <th scope="row">22:00</th>
                               </tr>
                               <tr>
                                   <th scope="row">23:00</th>
                               </tr>
                           </tbody>
                       </table>
                   </div>
               @else
                   <div class="mx-auto">
                       <table style="margin-left: 1cm; margin-right: 1cm; margin: 0 auto;">
                           <thead>
                               <tr>
                               <tr>
                                   <th style="width: 150px;" scope="col">Segmento</th>
                                   <th style="width: 150px;" scope="col">Entradas</th>
                               </tr>
                               </tr>
                           </thead>
                           <tbody>
                               @foreach ($datos_segmentados as $key => $value)
                                   <tr>
                                       <td scope="row">
                                           <h6>{{ GetSegmentoNumero($key) }}:00</h6>
                                       </td>
                                       <td>
                                           <h6>
                                               {{ is_numeric($value) ? $value : '' }}
                                           </h6>
                                       </td>
                                   </tr>
                               @endforeach

                           </tbody>
                       </table>
                   </div>
               @endif
           </div>
       </body>

       </html>
