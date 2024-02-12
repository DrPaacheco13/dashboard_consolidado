<script>
    function validaPassword(texto, id, msg = "Campo Obligatorio") {
        if ($('#' + id)) {
            if (texto !== '') {
                if (id == 'password' || id == 'password_confirm' || id == 'actual_password') {
                    if (texto.length < 4) {
                        $("#" + id).css('border-color', 'red');
                        $("#invalid_" + id).text('Contraseña debe tener al menos 4 Caracteres');
                        return 0;
                    } else {
                        if (id == 'actual_password') {
                            $("#" + id).css('border-color', 'green');
                            $("#invalid_" + id).text('');
                            return 1;
                        } else {
                            if (id == 'password_confirm') {
                                if ($('#password').val() !== texto) {
                                    $("#" + id).css('border-color', 'red');
                                    $("#invalid_" + id).text('Las Contraseñas No Coincíden');
                                    return 0;
                                } else {
                                    $("#" + id).css('border-color', 'green');
                                    $("#invalid_" + id).text('');
                                    return 1;
                                }
                            } else {
                                if (id == 'password') {
                                    if ($('#password_confirm').val() !== texto) {
                                        $("#" + id).css('border-color', 'red');
                                        $("#invalid_" + id).text('Las Contraseñas No Coincíden');
                                        return 0;
                                    } else {
                                        $("#" + id).css('border-color', 'green');
                                        $("#invalid_" + id).text('');
                                        return 1;
                                    }
                                }
                            }
                        }
                    }
                }
            } else {
                $('#' + id).css('border-color', 'red');
                $('#invalid_' + id).text(msg);
                return 0;
            }
        }
    }

    function cargando(msg = 'Cargando...', tiempo = 10000000000) {
        Swal.fire({
            title: `${msg}`,
            html: `No cierre ni actualice la página`,
            allowOutsideClick: false,
            allowEscapeKey: false,
            timer: tiempo,
            didOpen: () => {
                Swal.showLoading()
            }
        })
    }

    function SweetAlert(tipo = 'success', msg = '', title = '') {
        Swal.fire({
            icon: tipo,
            title: title,
            msg: msg
        });
    }

    function validarFechas(fechaInicial, fechaFinal) {
        // Obtener la fecha actual
        const fechaActual = new Date();

        // Convertir las cadenas de texto en objetos de fecha
        const fechaInicio = new Date(fechaInicial);
        const fechaFin = new Date(fechaFinal);

        // Validar que fechaFinal no sea mayor a fechaInicial
        if (fechaInicial > fechaFinal) {
            $("#fecha_inicial").css('border-color', 'red');
            $("#invalid_fecha_inicial").text('La Fecha Inicial no puede ser mayor a la Fecha Final');
            return 0;
        }

        // Validar que fechaFinal no sea mayor que la fecha actual
        if (fechaFin > fechaActual || fechaInicial > fechaActual) {
            return "La fecha final no puede ser mayor que la fecha actual";
        }

        // Si todas las validaciones pasan, las fechas son válidas

        return true;
    }

    function ValidaCampos(id, obligatorio = true, tipo = 'texto', msg = "Campo Obligatorio") {

        let texto = $('#' + id).val();
        if ($('#' + id)) {

            if (texto !== '') {
                switch (tipo) {
                    case 'fecha':
                        if (!/^\d{4}-\d{2}-\d{2}$/.test(texto)) {
                            $("#" + id).css('border-color', 'red');
                            $("#invalid_" + id).text('El formato de Fecha ingresado no es válido');
                            return 0;
                        } else {
                            $("#" + id).css('border-color', 'green');
                            $("#invalid_" + id).text('');
                            return 1;
                        }
                        break;
                    case 'texto_min':
                        texto = texto.trim();
                        texto = texto.trim();
                        if (texto.length < 3) {
                            $("#" + id).css('border-color', 'red');
                            $("#invalid_" + id).text('El largo Mínimo de 3 Caracteres');
                            return 0;
                        } else {
                            $("#" + id).css('border-color', 'green');
                            $("#invalid_" + id).text('');
                            return 1;
                        }
                        break;
                    case 'estado':
                        if (texto == '1' || texto == '0' || texto == 1 || texto == 0) {
                            $("#" + id).css('border-color', 'green');
                            $("#invalid_" + id).text('');
                            return 1;
                        } else {
                            $('#' + id).css('border-color', 'red');
                            $('#invalid_' + id).text(msg);
                            return 0;
                        }
                        break;
                    case 'tipo_filtro':
                        if (texto !== "1" && texto !== "2") {
                            $('#' + id).css('border-color', 'red');
                            $('#invalid_' + id).text(msg);
                            return 0;
                        } else {
                            $("#" + id).css('border-color', 'green');
                            $("#invalid_" + id).text('');
                            return 1;
                        }
                        break;
                    case 'select':
                        if (texto > 0) {
                            $("#" + id).css('border-color', 'green');
                            $("#invalid_" + id).text('');
                            return 1;
                        } else {
                            $("#" + id).css('border-color', 'red');
                            $("#invalid_" + id).text(msg);
                            return 0;
                        }
                        break;
                    default:
                        texto = texto.trim();
                        if (texto.length > 0) {
                            $("#" + id).css('border-color', 'green');
                            $("#invalid_" + id).text('');
                            return 1;
                        } else {
                            $("#" + id).css('border-color', 'red');
                            $("#invalid_" + id).text(msg);
                            return 0;
                        }
                        break;
                }

            } else {
                if (obligatorio == false) {
                    $("#" + id).css('border-color', '');
                    $("#invalid_" + id).text('');
                    return 1;
                } else {
                    $("#" + id).css('border-color', 'red');
                    $("#invalid_" + id).text(msg);
                    return 0;
                }
            }
        } else {
            toastr["error"](`No existe ID de Campo ${id}`, "Error de Validación")
            return 0;
        }

    }

    function cambiarColorYMensaje(idInput, tipo) {
        const input = document.getElementById(idInput);
        const span = document.getElementById('invalid_' + idInput);

        if (tipo === 'success') {
            input.style.borderColor = 'green';
            span.style.color = 'green';
            span.textContent = '';
        } else if (tipo === 'error') {
            input.style.borderColor = 'red';
            span.textContent = 'Campo requerido';
            span.style.color = 'red';
        }
    }

    function redondearDecimal(numero, decimales = 2) {
        return parseFloat(numero).toFixed(decimales);
    }

    function validaCorreo(id, msg = 'Campo Obligatorio') {
        let correo = $('#' + id).val();

        if ($("#" + id)) {
            if (correo !== '') {
                if (IsEmail(correo)) {
                    $("#" + id).css('border-color', 'green');
                    $("#invalid_" + id).text('');
                    return 1;
                } else {
                    $("#" + id).css('border-color', 'red');
                    $("#invalid_" + id).text(msg);
                    return 0;
                }
            } else {
                $("#" + id).css('border-color', 'red');
                $("#invalid_" + id).text('Campo Obligatorio');
                return 0;
            }
        }
    }

    function IsEmail(email) {
        let regex = /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
        if (!regex.test(email)) {
            return false;
        } else {
            return true;
        }

    }

    function ordenarFechaHumano(fechaISO) {
        var fecha = fechaISO.split("T")[0];
        return fecha;
    }
</script>

<script>
    function GetDataAjax(url, method, data) {
        return $.ajax({
                url: url,
                method: method,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    data: data
                },
                dataType: 'json',
            })
            .then(function(resp) {
                return resp;
            })
            .fail(function(jqXHR, textStatus, errorThrown) {
                console.error('Error en la petición AJAX:', textStatus, errorThrown);
                throw new Error('Error en la petición AJAX');
            });
    }

    function formatearNumero(numero) {
        if (numero !== null && numero !== undefined && numero !== '') {
            var pesos = new Intl.NumberFormat().format(numero);
        } else {
            var pesos = 0;
        }
        return pesos;
    }
</script>