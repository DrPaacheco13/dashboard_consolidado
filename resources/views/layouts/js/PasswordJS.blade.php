<script>
    $(document).ready(function() {
        $('#password').keyup(function() {
            validaPassword($('#password').val(), 'password');
            validaPassword($('#password_confirm').val(), 'password_confirm');
        });
        $('#password_confirm').keyup(function() {
            validaPassword($('#password').val(), 'password');
            validaPassword($('#password_confirm').val(), 'password_confirm');
        });
        $('#actual_password').keyup(function() {
            validaPassword($('#actual_password').val(), 'actual_password')
        });

        $('#btn_cambiar').click(function() {
            let actual = validaPassword($('#actual_password').val(), 'actual_password')
            let nueva_password = validaPassword($('#password').val(), 'password');
            let confirm_password = validaPassword($('#password_confirm').val(), 'password_confirm');

            if (actual == 1 && nueva_password == 1 && confirm_password == 1) {
                $('#formulario').submit();
            } else {
                toastr["error"](
                    `Se encontraron 1 o más Campos con Problemas. Corrija e Intente nuevamente`,
                    "Error de Validación")
            }

        });
    });
</script>
