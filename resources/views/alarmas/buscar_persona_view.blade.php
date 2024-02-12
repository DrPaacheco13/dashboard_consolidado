@extends('layouts.layout_main_view')

@section('content')
    <style>
        .galeria {
            display: flex;
            flex-flow: wrap;
            justify-content: center;
        }

        .galeria img {
            max-width: 150px;
            padding: 1rem;
        }
    </style>
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <div class="card h-100">
                    <div class="card-body">
                        <form action="{{ route('ingresar_persona.post') }}" method="post" id="formulario"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="row d-flex justify-content-center">
                                <div class="col-md-6">
                                    <div class="form-group text-center">
                                        <label for="img_persona" class="pb-2" style="font-size: 16px">SELECCIONE
                                            IMAGEN</label>
                                        <input type="file" class="form-control" id="img_persona" name="img_persona">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group text-center">
                                        <label for="prev_img_persona" style="font-size: 16px">PREVISUALIZACIÓN</label>
                                        <br>
                                        <img src="{{ asset('img/no_face.png') }}" width="150" alt=""
                                            id="prev_img_persona" class="img-fluid">
                                    </div>
                                </div>
                                <hr style="width: 90%">
                                <div class="col-md-3"></div>
                                <div class="col-md-6">
                                    <input type="text" id="nombre" name="nombre" class="form-control text-center"
                                        placeholder="Ingrese Nombre...">
                                </div>
                                <div class="col-md-3"></div>
                                <br>
                                <br>
                                <div class="col-md-3"></div>
                                <div class="col-md-6">
                                    <input type="date" id="fecha_ingreso" name="fecha_ingreso"
                                        class="form-control text-center">
                                </div>
                                <div class="col-md-3"></div>
                                <div class="col-md-12 text-right">
                                    <button type="submit" id="ingresar" class="btn btn-info text-white"><i
                                            class="fas fa-user-plus text-white"></i>
                                        Ingresar</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-6">

                <div class="card card-body h-100">
                    <div class="galeria">
                        @if (!empty($lista_negra))
                            @foreach ($lista_negra as $i)
                                <img src="{{ asset($i->img_persona . $i->nombre_archivo) }}" alt="">
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <br>
        <br>
    </div>
    <script>
        document.getElementById('img_persona').addEventListener('change', function(event) {
            var preview = document.getElementById('prev_img_persona');
            var file = event.target.files[0];
            var reader = new FileReader();

            reader.onload = function(e) {
                preview.src = e.target.result;
            }

            reader.readAsDataURL(file);
        });
    </script>
    <script>
        $(document).ready(function() {
            $('#img_persona').change(function() {
                var csrfToken = $('meta[name="csrf-token"]').attr('content');
                var file = $(this).prop('files')[0]; // Obtener el archivo seleccionado correctamente

                var formData = new FormData();
                formData.append('file', file);
                formData.append('_token', csrfToken);

                $.ajax({
                    url: '{{ route('analyze_persona') }}',
                    type: "POST",
                    data: formData,
                    processData: false,
                    contentType: false, // Asegúrate de no establecer contentType para que jQuery lo configure automáticamente como 'multipart/form-data'
                    dataType: 'json',
                    success: function(resp) {
                        console.log(resp);
                        let tipo = resp.tipo;
                        let msg = resp.msg;

                        if (tipo == 'success') {
                            toastr["success"](`Usuario Eliminado Correctamente`,
                                "Mantenedor de Usuario");
                        } else {
                            toastr["error"](`${msg}`, "Error Interno");
                        }
                    },
                    error: function(error) {
                        console.log(JSON.stringify(error));
                        toastr["error"]("Ha ocurrido un error en la solicitud",
                            "Error de Servidor");
                    }
                });
            });
        });
    </script>


@endsection
