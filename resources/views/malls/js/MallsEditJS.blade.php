<script>
    let regiones_selected = [];
    $(document).ready(function() {
        ValidaCampos('nombre', true, 'texto_min');
        ValidaCampos('descripcion', true, 'texto_min');
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
            ValidaCampos('acceso_r3', false, 'estado');
        })
        // $('#acceso_vehicle').change(function() {
        //     let val = $(this).val();
        //     if (val == 1) {
        //         // Verifica si 'acceso_r3' ya existe en el array antes de agregarlo
        //         if (regiones_selected.indexOf('acceso_vehicle') === -1) {
        //             regiones_selected.push('acceso_vehicle');
        //         }
        //     }
        //     ValidaCampos('acceso_vehicle', false, 'estado');
        // })
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
            console.log($('#nombre').val());
            console.log($('#descripcion').val());
            //validacion de campos configuracion base de datos
            // let db_host = ValidaCampos('db_host', true, 'texto_min');
            // let db_port = ValidaCampos('db_port', true, 'texto_min');
            // let db_user = ValidaCampos('db_user', true, 'texto_min');
            // let db_name = ValidaCampos('db_name', true, 'texto_min');
            // let db_password = ValidaCampos('db_password', true, 'texto_min');
            //validacion de campos configuracion region
            let acceso_r0 = ValidaCampos('acceso_r0', false, 'estado');
            let acceso_r1 = ValidaCampos('acceso_r1', false, 'estado');
            let acceso_r2 = ValidaCampos('acceso_r2', false, 'estado');
            let acceso_r3 = ValidaCampos('acceso_r3', false, 'estado');
            let acceso_rvehicle = ValidaCampos('acceso_vehicle', false, 'estado');
            let validarNombre = true;
            regiones_selected.forEach(element => {
                let vC = ValidaCampos(element + '_nombre', true, 'texto_min');
                if(vC == 0){
                    validarNombre = false;
                }
            });

            // let acceso_r1_nombre = ValidaCampos('acceso_r1_nombre', false, 'texto_min');
            // let acceso_r2_nombre = ValidaCampos('acceso_r2_nombre', false, 'texto_min');
            // let acceso_r3_nombre = ValidaCampos('acceso_r3_nombre', false, 'texto_min');


            let alMenosUnAccesoSeleccionado = false;
            let accesos = ['acceso_r0', 'acceso_r1', 'acceso_r2', 'acceso_r3', 'acceso_vehicle'];

            for (let i = 0; i < accesos.length; i++) {
                let accesoCampo = ValidaCampos(accesos[i], true, 'select');
                if (accesoCampo === 1) {
                    alMenosUnAccesoSeleccionado = true;
                    break;
                }
            }

            let distribucion_id = $('#distribucion_id').val();

            if (alMenosUnAccesoSeleccionado &&
                nombre_mall_val == 1 && descripcion_mall_val == 1 && validarNombre == 1 && distribucion_id > 0) {
                //Agregar DB y si está seleccionado acceso_r0, solicitar acceso_r0_ como obligatorio (Para todas las reg)
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
</script>
