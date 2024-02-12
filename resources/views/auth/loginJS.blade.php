<script>
    $(document).ready(function() {
        $('#btn_login').click(function() {
            let email = validaCampos('email', true, 'email');
            let password = validaCampos('password', true, 'texto_min_pass');
            // let pass = $('#').val();
            if (email == 1 && password == 1) {
                $('#formulario').submit();
                mostrarMensajeCarga();
            } else {
                toastr.error('1 o más campos son requeridos. Por favor, ingréselos',
                    'Error de Validación');
            }
            // console.log('here');
        });
    });

    function validaCampos(id, obligatorio = true, tipo = 'texto', msg = "Campo Obligatorio") {
        const campo = $('#' + id);

        if (!campo.length) {
            toastr["error"](`No existe ID de Campo ${id}`, "Error de Validación");
            return 0;
        }

        const texto = campo.val().trim();

        if (texto !== '') {
            switch (tipo) {
                case 'fecha':
                    return validarFormatoFecha(campo, texto);
                case 'texto_min':
                    return validarLongitudMinima(campo, texto, 3);
                case 'texto_min_pass':
                    return validarLongitudMinima(campo, texto, 4);
                case 'estado':
                    return validarEstado(campo, texto, msg);
                case 'tipo_filtro':
                    return validarTipoFiltro(campo, texto, msg);
                case 'select':
                    return validarSelect(campo, texto, msg);
                case 'email':
                    return validarEmail(campo, texto, msg);
                case 'password':
                    return validarPassword(campo, texto, msg);
                default:
                    return validarCampoTextoGenerico(campo, texto, msg);
            }
        } else {
            return (obligatorio) ? mostrarError(campo, msg) : actualizarEstilos(campo, false);
        }
    }

    function validarFormatoFecha(campo, texto) {
        if (!/^\d{4}-\d{2}-\d{2}$/.test(texto)) {
            return mostrarError(campo, 'El formato de Fecha ingresado no es válido');
        } else {
            return actualizarEstilos(campo);
        }
    }

    function validarLongitudMinima(campo, texto, longitud) {
        return (texto.length < longitud) ? mostrarError(campo, `El largo Mínimo de ${longitud} Caracteres`) :
            actualizarEstilos(campo);
    }

    function validarEstado(campo, texto, msg) {
        return (['1', '0', 1, 0].includes(texto)) ? actualizarEstilos(campo) : mostrarError(campo, msg);
    }

    function validarTipoFiltro(campo, texto, msg) {
        return (texto !== "1" && texto !== "2") ? mostrarError(campo, msg) : actualizarEstilos(campo);
    }

    function validarSelect(campo, texto, msg) {
        return (texto > 0) ? actualizarEstilos(campo) : mostrarError(campo, msg);
    }

    function validarEmail(campo, texto, msg) {
        const regexEmail = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return regexEmail.test(texto) ? actualizarEstilos(campo) : mostrarError(campo, msg);
    }

    function validarPassword(campo, texto, msg) {
        // Se requiere una longitud mínima de 8 caracteres y al menos una letra y un número
        const regexPassword = /^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$/;
        return regexPassword.test(texto) ? actualizarEstilos(campo) : mostrarError(campo, msg);
    }

    function validarCampoTextoGenerico(campo, texto, msg) {
        return (texto.length > 0) ? actualizarEstilos(campo) : mostrarError(campo, msg);
    }

    function mostrarError(campo, mensaje) {
        campo.css('border-color', 'red');
        $('#invalid_' + campo.attr('id')).text(mensaje);
        return 0;
    }

    function actualizarEstilos(campo, valido = true) {
        campo.css('border-color', valido ? 'green' : '');
        $('#invalid_' + campo.attr('id')).text('');
        return 1;
    }

    function mostrarMensajeCarga() {
        Swal.fire({
            title: 'Cargando...',
            allowOutsideClick: false,
        });
        Swal.showLoading();
    }
    toastr.options = {
        "closeButton": true,
        "progressBar": true,
    }
</script>
