<script>
    $(document).ready(function() {
        
        $('#name').keyup(function() {
            ValidaCampos('name', true, 'texto_min', 'Ingrese Nombre!');
        });
        $('#email').keyup(function() {
            validaCorreo('email');
        });
        $('#role_id').change(function() {
            ValidaCampos('role_id', true, 'select');
        });
        $('#role_id').change(function() {
            ValidaCampos('id_mall', true, 'select');
        });

        $('#role_id').change(function() {
            let value = (this).value;
            if (value == '3') {
                $('#col_mall').css('display', 'none');
                $('#col_distribucion').css('display', 'block');
            } else {
                $('#col_mall').css('display', 'block');
                $('#col_distribucion').css('display', 'none');
            }
        });
        $('#btn_submit').click(function() {

            //Después se validan nuevamente los campos
            let v_name = ValidaCampos('name', true, 'texto_min');
            let v_email = validaCorreo('email');
            let v_role_id = ValidaCampos('role_id', true, 'select');
            let v_id_mall = ValidaCampos('id_mall', true, 'select');

            if(v_name == 1 && v_email == 1 && v_role_id == 1 && v_id_mall == 1){
                $('#formulario').submit();
            } else {
                toastr.error('Favor verificar los campos e intentar nuevamente');
            }
        });
    });
</script>
