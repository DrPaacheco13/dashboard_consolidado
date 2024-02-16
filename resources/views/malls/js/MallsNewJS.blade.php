<script>
    let regiones_selected = [];
    let rsp = '';
    $(document).ready(function() {

        // $('#btn_modificar_db').css('display', 'none');

        $('#btn_validar_db').click(function() {
            let db_host = $('#db_host').val();
            let db_port = $('#db_port').val();
            let db_user = $('#db_user').val()
            let db_name = $('#db_name').val();
            let db_password = $('#db_password').val();

            let db_host_valida = ValidaCampos('db_host', true, 'texto_min');
            let db_port_valida = ValidaCampos('db_port', true, 'texto_min');
            let db_user_valida = ValidaCampos('db_user', true, 'texto_min');
            let db_name_valida = ValidaCampos('db_name', true, 'texto_min');
            let db_password_valida = ValidaCampos('db_password', true, 'texto_min');

            if (db_host_valida == 1 && db_port_valida == 1 && db_user_valida == 1 &&
                db_name_valida == 1 && db_password_valida == 1) {
                // cargando('Espere por favor')
                $('#db_host').prop('disabled', true);
                $('#db_port').prop('disabled', true);
                $('#db_user').prop('disabled', true);
                $('#db_name').prop('disabled', true);
                $('#db_password').prop('disabled', true);

                let url = '{{ route('malls/validar-basedatos') }}';
                let method = 'POST';
                let data = {
                    host: db_host,
                    port: db_port,
                    user: db_user,
                    name: db_name,
                    password: db_password
                };
                GetDataAjax(url, method, data)
                    .then(function(data) {
                        $('#btn_validar_db').prop('disabled', true);
                        $('#btn_validar_db').hide();
                        $('#btn_modificar_db').show();
                        QuitarEstilosDB()
                        console.log(data);
                        $('#col_alerta_mkt').hide();
                        $('#row_camaras').show();
                        Swal.close();
                        data = data.data;
                        // GenerarRowCamera(data)
                        toastr.success('Base de datos conectada con éxito!', 'Gestión de Malls');

                    })
                    .catch(function(error) {
                        console.log(error);
                    });
            } else {
                toastr.error('Uno o más campos no están completos, por favor, verificar!');
            }
        });


        $('#acceso_r1').change(function() {
            let value = (this).value;
            if (value == '1') {
                $('#col_nombre_r1').css('display', 'block');
            } else {
                $('#col_nombre_r1').css('display', 'none');
            }
        });
        $('#acceso_r2').change(function() {
            let value = (this).value;
            if (value == '1') {
                $('#col_nombre_r2').css('display', 'block');
            } else {
                $('#col_nombre_r2').css('display', 'none');
            }
        });
        $('#acceso_r3').change(function() {
            let value = (this).value;
            if (value == '1') {
                $('#col_nombre_r3').css('display', 'block');
            } else {
                $('#col_nombre_r3').css('display', 'none');
            }
        });

        $('#nombre').keyup(function() {
            ValidaCampos('nombre', true, 'texto_min');
        })
        $('#descripcion').keyup(function() {
            ValidaCampos('descripcion', true, 'texto_min');
        })
        $('#db_host').keyup(function() {
            ValidaCampos('db_host', true, 'texto_min');
        })
        $('#db_port').keyup(function() {
            ValidaCampos('db_port', true, 'texto_min');
        })
        $('#db_user').keyup(function() {
            ValidaCampos('db_user', true, 'texto_min');
        })
        $('#db_name').keyup(function() {
            ValidaCampos('db_name', true, 'texto_min');
        })
        $('#db_password').keyup(function() {
            ValidaCampos('db_password', true, 'texto_min');
        })
        $('#acceso_r0').change(function() {
            let val = $(this).val();
            if (val == 1) {
                // Verifica si 'acceso_r0' ya existe en el array antes de agregarlo
                if (regiones_selected.indexOf('acceso_r0') === -1) {
                    regiones_selected.push('acceso_r0');
                }
            }
            ValidaCampos('acceso_r0', false, 'select');
        });

        $('#acceso_r0_nombre').keyup(function() {
            ValidaCampos('acceso_r0_nombre', false)
        })
        $('#acceso_r1').change(function() {
            let val = $(this).val();
            if (val == 1) {
                // Verifica si 'acceso_r1' ya existe en el array antes de agregarlo
                if (regiones_selected.indexOf('acceso_r1') === -1) {
                    regiones_selected.push('acceso_r1');
                }
            }
            ValidaCampos('acceso_r1', false, 'select');
        })
        $('#acceso_r1_nombre').keyup(function() {
            ValidaCampos('acceso_r1_nombre', false, 'text_min')
        })
        $('#acceso_r2').change(function() {
            let val = $(this).val();
            if (val == 1) {
                // Verifica si 'acceso_r2' ya existe en el array antes de agregarlo
                if (regiones_selected.indexOf('acceso_r2') === -1) {
                    regiones_selected.push('acceso_r2');
                }
            }
            ValidaCampos('acceso_r2', false, 'select');
        })
        $('#acceso_r2_nombre').keyup(function() {
            ValidaCampos('acceso_r2_nombre', false, 'text_min')
        })
        $('#acceso_r3').change(function() {
            let val = $(this).val();
            if (val == 1) {
                // Verifica si 'acceso_r3' ya existe en el array antes de agregarlo
                if (regiones_selected.indexOf('acceso_r3') === -1) {
                    regiones_selected.push('acceso_r3');
                }
            }
            ValidaCampos('acceso_r3', false, 'select');
        })
        $('#acceso_r3_nombre').keyup(function() {
            ValidaCampos('acceso_r3_nombre', false, 'text_min')
        })

        // $('#acceso_r0_nombre').prop('disabled', true);

        // $('#acceso_r0').change(function() {
        //     let value = $(this).val();
        //     // Activar o desactivar acceso_r0_nombre según el valor de acceso_r0
        //     $('#acceso_r0_nombre').prop('disabled', value !== '1');
        // });

        $('#btn_submit').click(function() {
            //console.log(regiones_selected);
            let nombre_mall_val = ValidaCampos('nombre', true, 'texto_min');
            let descripcion_mall_val = ValidaCampos('descripcion', true, 'texto_min');
            let distribucion_mall_val = ValidaCampos('distribucion_id', true, 'select');

            //validacion de campos configuracion base de datos
            let db_host = ValidaCampos('db_host', true, 'texto_min');
            let db_port = ValidaCampos('db_port', true, 'texto_min');
            let db_user = ValidaCampos('db_user', true, 'texto_min');
            let db_name = ValidaCampos('db_name', true, 'texto_min');
            let db_password = ValidaCampos('db_password', true, 'texto_min');
            //validacion de campos configuracion region
            let acceso_r0 = ValidaCampos('acceso_r0', false, 'estado');
            let acceso_r1 = ValidaCampos('acceso_r1', false, 'estado');
            let acceso_r2 = ValidaCampos('acceso_r2', false, 'estado');
            let acceso_r3 = ValidaCampos('acceso_r3', false, 'estado');
            let validarNombre = true;
            regiones_selected.forEach(element => {
                let vC = ValidaCampos(element + '_nombre', true, 'texto_min');
                if (vC == 0) {
                    validarNombre = false;
                }
            });


            let alMenosUnAccesoSeleccionado = false;
            let accesos = ['acceso_r0', 'acceso_r1', 'acceso_r2', 'acceso_r3', 'acceso_vehicle'];

            for (let i = 0; i < accesos.length; i++) {
                let accesoCampo = ValidaCampos(accesos[i], true, 'select');
                if (accesoCampo === 1) {
                    alMenosUnAccesoSeleccionado = true;
                    break;
                }
            }


            if (alMenosUnAccesoSeleccionado &&
                nombre_mall_val == 1 && descripcion_mall_val == 1 && distribucion_mall_val == 1 &&
                db_host == 1 &&
                db_port == 1 && db_user == 1 && db_name == 1 && db_password == 1 && validarNombre == 1
            ) {
                //Agregar DB y si está seleccionado acceso_r0, solicitar acceso_r0_ como obligatorio (Para todas las reg)
                HabilitarCamposDB();
                $('#formulario').submit();
            } else {
                toastr.error('Uno o más campos no están completos, por favor, verificar!');
            }

        });
        $('#logo').change(function() {
            const imagePreview = document.getElementById('logo_prev');

            if (this.files && this.files[0]) {
                const reader = new FileReader();

                reader.onload = function(e) {
                    // Mostrar la imagen previsualizada
                    imagePreview.src = e.target.result;
                };

                // Leer el contenido del archivo como una URL de datos
                reader.readAsDataURL(this.files[0]);
            }
        });
    });

    function QuitarEstilosDB() {
        $('#db_host').css('border-color', '');
        $('#db_port').css('border-color', '');
        $('#db_user').css('border-color', '');
        $('#db_name').css('border-color', '');
        $('#db_password').css('border-color', '');

        $('#invalid_db_host').text('');
        $('#invalid_db_port').text('');
        $('#invalid_db_user').text('');
        $('#invalid_db_name').text('');
        $('#invalid_db_password').text('');

    }

    function HabilitarCamposDB() {
        $('#btn_validar_db').prop('disabled', false);
        $('#db_host').prop('disabled', false);
        $('#db_port').prop('disabled', false);
        $('#db_user').prop('disabled', false);
        $('#db_name').prop('disabled', false);
        $('#db_password').prop('disabled', false);
        $('#btn_validar_db').show();
        $('#btn_modificar_db').hide();
    }

    function GenerarRowCamera(data) {
        // Primero, asegúrate de definir rsp como una cadena vacía para concatenar tu HTML
        let rsp = '';

        // Luego, elimina el elemento con el id 'row_data' antes de agregar uno nuevo
        $('#row_data').remove();

        // Ahora comienza a construir tu HTML dentro de rsp
        rsp += `
            <div class="row" id="row_data">
        <div class="col-12">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th class="text-center" width="20%">INDEX CODE</th>
                        <th class="text-center" width="60%">NOMBRE CAMARA</th>
                        <th class="text-center" width="20%">ESTADO</th>
                    </tr>
                </thead>
                <tbody>`;

        // Itera sobre los datos para generar las filas de la tabla
        data.forEach(element => {
            rsp += `
            <tr>
                <td class="text-center">${element.camaraindexcode}</td>
                <td class="text-center">
                    <!-- Asegúrate de que los inputs y selects estén dentro de las celdas de la tabla -->
                    <input type="hidden" id="id_camara_${element.camaraindexcode}" name="id_camara_${element.camaraindexcode}" value="${element.id}">
                    <input type="text" id="nombre_camara_${element.camaraindexcode}" name="nombre_camara_${element.camaraindexcode}" value="${element.nombre}" class="form-control-sm">
                </td>
                <td class="text-center">
                    <select class='form-control-sm' id="estado_camara_${element.camaraindexcode}" name="estado_camara_${element.camaraindexcode}">
                        <option value="" selected>PENDIENTE</option>
                        <option value="1">ACTIVO</option>
                        <option value="0">INACTIVO</option>
                    </select>    
                </td>
            </tr>`;
        });

        rsp += `
            </tbody>
            </table>
        </div>
            </div>`;

        // Después de construir el HTML, agrega rsp al contenedor con el id 'row_camaras_marketing'
        $('#row_camaras_marketing').html(rsp);

        // Finalmente, devuelve rsp (aunque actualmente no parece necesario)
        return rsp;
    }

    function AgregarInputsCamara() {
        let count_rows = document.querySelectorAll('#col_camaras .row').length;

        let html = `
        <div class="row d-flex justify-content-center pb-3">
            <div class="col-md-3">
                <input type="text" id="marketing_id_${count_rows}" name="camaras[${count_rows}][marketing_id]" placeholder="Ingrese ID de cámara" class="form-control">
            </div>
            <div class="col-md-7">
                <input type="text" id="nombre_camara_${count_rows}" name="camaras[${count_rows}][nombre_camara]" placeholder="Ingrese Nombre de cámara" class="form-control">
            </div>
        </div>`;

        document.getElementById('col_camaras').insertAdjacentHTML('beforeend',html);
    }
</script>
